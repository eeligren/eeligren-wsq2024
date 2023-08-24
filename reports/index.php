<?php

    require_once __DIR__ . '/../php/events.php';
    require_once __DIR__ . '/../php/sessions.php';
    require_once __DIR__ . '/../php/channels.php';
    require_once __DIR__ . '/../php/rooms.php';

    if(!isset($_GET['id'])) header('location: /events/');

    $eventData = get_event($_GET['id']);
    if(!$eventData) header('location: /events/');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Event Backend</title>

    <base href="../">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
<?php include __DIR__ . '/../components/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../components/sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2"><?php echo $eventData['name']; ?></h1>
                </div>
                <span class="h6"><?php echo $eventData['date']; ?></span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Room Capacity</h2>
                </div>
            </div>

            <div id="chart-container" style="width: 100%; height: auto;">
                <canvas id="graphCanvas"></canvas>
            </div>

            <script>
                $(document).ready(function () {
                    showGraph();
                });


                function showGraph()
                {   
                    $.post("../php/chart.php",
                    function (data)
                    {
                        console.log(data);         
                        new Chart($('#graphCanvas'), {
                            type: 'bar',
                            data: {
                                
                                labels: [data.rooms],
                                datasets: [{
                                    label: 'Attendees',
                                    data: [data.attendees], // Ensimmäisen tolpan rivin 1 datat
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                                }, {
                                    label: 'Capacity',
                                    data: [data.capacity], // Ensimmäisen tolpan rivin 2 datat
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
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

                }
            </script>

        </main>
    </div>
</div>

</body>
</html>
