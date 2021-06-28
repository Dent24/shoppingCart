<?php

require_once './connect.php';

$serachOne = <<<serachone
SELECT * FROM product;
serachone;
$resultOne = mysqli_query($link, $serachOne);

while($one = mysqli_fetch_assoc($resultOne)){
    $oneId = $one["id"];
    $sall = <<<sallserach
    SELECT SUM(demand) demand FROM product p
    JOIN orderDetail od ON od.productId = p.id
    JOIN memberOrder mo ON od.orderId = mo.id
    WHERE DATEDIFF(NOW(), orderTime) < 1 AND p.id = $oneId
    sallserach;
    $sallResult = mysqli_query($link, $sall);
    $sallIt = mysqli_fetch_assoc($sallResult);

    if($sallIt["demand"] == ""){
        $sallIt["demand"] = 0;
    }

    $name[] = $one["productName"];
    $array[] = $sallIt["demand"];
}

$name = json_encode($name);
$array = json_encode($array);

?>


<canvas id="myChart"  width="200" height="100"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: <?= $name ?>,
            datasets: [{
                label: '本日銷售量',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: <?= $array?>
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>