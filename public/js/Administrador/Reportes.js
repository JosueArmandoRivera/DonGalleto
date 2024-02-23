let chartDia;
let chartSemana;
let chartMes;
let chartAno;
let variable;
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('myChart').getContext('2d');
    chartDia = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['De chocolate', 'Combinada', 'Azúcar', 'Tartina', 'Decorada', 'Yaculada', 'Canela', 'Navideña'],
            datasets: [{
                label: 'Tipo de Galleta',
                data: [250, 700, 150, 80, 300, 1200, 750, 800],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

$(document).on('click', '#semana', function () {
    chartDia.destroy();
    validar2();
    var ctx = document.getElementById('myChart').getContext('2d');
    chartSemana = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['De chocolate', 'Combinada', 'Azúcar', 'Tartina', 'Decorada', 'Yaculada', 'Canela', 'Navideña'],
            datasets: [{
                label: 'Tipo de Galleta',
                data: [2500, 1200, 700, 1800, 600, 600, 350, 290],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    //chartSemana='';
});
$(document).on('click', '#dia', function () {
    location. reload();
    //chartDia='';
});

$(document).on('click', '#mes', function () {
    chartSemana.destroy();
    validar2();

    var ctx = document.getElementById('myChart').getContext('2d');
    chartMes = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['De chocolate', 'Combinada', 'Azúcar', 'Tartina', 'Decorada', 'Yaculada', 'Canela', 'Navideña'],
            datasets: [{
                label: 'Tipo de Galleta',
                data: [1500, 2000, 100, 3000, 2000, 1500, 2000, 2500],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    //chartMes='';
});

$(document).on('click', '#ano', function () {
    chartMes.destroy();
    validar2();
    var ctx = document.getElementById('myChart').getContext('2d');
    chartAno = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['De chocolate', 'Combinada', 'Azúcar', 'Tartina', 'Decorada', 'Yaculada', 'Canela', 'Navideña'],
            datasets: [{
                label: 'Tipo de Galleta',
                data: [15000, 8760, 4100, 11395, 780, 1500, 5900, 13600],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    //chartAno='';
});

function validar(variable){
    if(empty(variable)){
        variable.destroy();
    }
}

function validar2(){
    console.log('validar2');
    console.log(chartDia !='', chartDia);
try {
    if(chartDia !=''){
        chartDia.clear();
        console.log('Se eliminó dia');
        chartDia='';
        return
    } 
    if(chartSemana !=''){
        chartSemana.clear();
        chartSemana='';   
        console.log('Se eliminó semana');
        return
    
    }
    if(chartMes !=''){
        chartMes.clear();
        chartMes='';
        console.log('Se eliminó Mes');
        return
    
    }
    if(chartAno !=''){
        chartAno.destroy();
        chartAno='';
        console.log('Se eliminó Año');
        return
    
    }
} catch (error) {
    console.log(error);
}
}