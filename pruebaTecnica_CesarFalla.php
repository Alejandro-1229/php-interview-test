<?php
//Intervalo de años que piden
$years = range(1995, 2020);
$values = [];

//Consumir la API y hacer un loop por cada año
foreach ($years as $year) {
    $url = "https://api.worldbank.org/pip/v1/pip?country=PER&year=$year";
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    
    //En los años 1995 y 1996 no tienen datos por lo tanto validamos todos los headcounts
    $values[] = $data[0]['headcount'] ?? null;

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de Pobreza en Perú</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div id="container" style="width:100%; height:400px;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myChart = Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Índice de Pobreza en Perú (1995-2020)'
                },
                xAxis: {
                    categories: <?php echo json_encode($years); ?>
                },
                yAxis: {
                    title: {
                        text: 'Headcount (%)'
                    }
                },
                series: [{
                    name: 'Pobreza',
                    data: <?php echo json_encode($values); ?>
                }]
            });
        });
    </script>
</body>
</html>
