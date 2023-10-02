<div class="d-flex justify-content-between">
  <div id="copyright">
    <a href='https://grupoinndex.com/' target="_blank"></a>
  </div>
  <div id="footer-date"></div>
  <div>Versión 1.0.0</div>
</div>

<script>
  function formatTime(value) {
    return value < 10 ? `0${value}` : value;
  }

  setInterval(() => {
    const fecha = new Date();
    const anio = fecha.getFullYear();
    const mes = formatTime(fecha.getMonth() + 1);
    const dia = formatTime(fecha.getDate());
    const hora = formatTime(fecha.getHours());
    const minutos = formatTime(fecha.getMinutes());
    const segundos = formatTime(fecha.getSeconds());

    document.getElementById('footer-date').innerText = `${hora}:${minutos}:${segundos}`;

    // Obtener el elemento 'a' dentro de 'copyright'
    const linkElement = document.querySelector('#copyright a');
    // Restaurar el contenido original del enlace y agregar el año actual
    linkElement.innerHTML = 'Grupo Inndex &copy; ' + anio;
  }, 1000);
</script>