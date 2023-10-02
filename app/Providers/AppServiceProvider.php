<?php

namespace App\Providers;

use App\Http\Controllers\InicioController;
use Illuminate\Support\Facades\Session;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Dispatcher $events): void
    {
        $this->app->bind(YourController::class, function ($app) {
            return InicioController::iniciarCorreo(); //Asignar la direccion que utiliza la aplicacion para enviar correos
        });

        Paginator::useBootstrapFour();

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // $resultado = DB::select("SELECT * FROM MENUS ORDER BY Orden", array(null));
            $resultado = DB::select("SELECT me.Id_Menu, me.Url , me.Orden, me.Id_Padre, me.Icono, me.Id_Modulo, mo.Nombre_Modulo, mri.Id_Rol, ro.Nombre FROM Menus AS me
                                        JOIN Menus_Roles_Intermedia AS mri ON me.Id_Menu = mri.Id_Menu
                                        JOIN Modulos AS mo ON me.Id_Modulo = mo.Id_Modulo
                                        JOIN Roles AS ro ON mri.Id_Rol = ro.Id_Rol
                                        WHERE mri.Id_Rol = ? ORDER BY me.Orden", [Auth::user()->Id_Rol]);

            $permisos = DB::select("SELECT pri.Id_Permiso_Modulo, pri.Id_Rol, pmi.Id_Permiso, cp.Nombre_Permiso, pmi.Id_Modulo, mo.Nombre_Modulo FROM PermisosModulos_Roles_Intermedia AS pri
                                        JOIN Permisos_Modulos_Intermedia AS pmi ON pri.Id_Permiso_Modulo = pmi.Id_Permiso_Modulo
                                        JOIN Catalogo_Permisos AS cp ON pmi.Id_Permiso = cp.Id_Permiso
                                        JOIN Modulos AS mo ON pmi.Id_Modulo = mo.Id_Modulo
                                    WHERE pri.Id_Rol = ?", [Auth::user()->Id_Rol]);


            

            $agregados = array(); // Array para almacenar los elementos ya agregados al menú
            $padres = array();

            foreach ($resultado as $value) {
                if ($value->Id_Padre == 0) {

                    // Verificar si el elemento ya ha sido agregado al menú
                    if (!in_array($value->Nombre_Modulo, $agregados)) {

                        $event->menu->add([
                            'text'        => $value->Nombre_Modulo,
                            'key'         => $value->Nombre_Modulo,
                            'url'         => $value->Url,
                            'icon'        => $value->Icono,
                            'label_color' => 'warning'
                        ]);

                        $agregados[] = $value->Nombre_Modulo; // Agregar el elemento al array de agregados
                        $padres[] = $value->Nombre_Modulo;
                    }
                } else if ($value->Id_Padre > 0) {
                    $event->menu->addIn(end($padres), [
                        'key' => $value->Nombre_Modulo,
                        'text' => $value->Nombre_Modulo,
                        'icon' => $value->Icono,
                        'url' => $value->Url,
                    ]);
                }
            }

            $modulos = array();

            foreach ($permisos as $value) {
                $moduloID = $value->Id_Modulo;

                if (!isset($modulos[$moduloID])) {
                    $modulos[$moduloID] = array();
                }

                $modulos[$moduloID][] = $value->Nombre_Permiso;
            }

            Session::put('permisos', $modulos);
        });
    }
}
