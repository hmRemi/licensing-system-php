<?php

if (isset($_COOKIE['USER_TOKEN'])) {
    include 'utils/tokens.php';

    if (!tokenExist($_COOKIE['USER_TOKEN'])) {
        header("Location: /logout");
        exit();
    }

    include 'utils/mysql.php';
    include 'utils/stats.php';

    $currentDay = date("d");
    $dates = "";
    $values = "";

    for ($i = $currentDay - 6; $i <= $currentDay; $i++) {
        if ($i > 0) {
            if ($i == $currentDay) $dates .= "\"" . $i . " " . date("F") . "\"";
            else $dates .= "\"" . $i . " " . date("F") . "\", ";
            if ($i == $currentDay) $values .= "\"" . getRequestByDay($i . " " . date("F")) . "\"";
            else $values .= "\"" . getRequestByDay($i . " " . date("F")) . "\", ";
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Audi Development</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="msapplication-TileImage" content="assets/img/favicon.png">
        <!-- ICONS -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon.png">
        <!-- Material Icons -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- Google fonts - Muli-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
        <!-- Bootstrap CSS -->
        <link href="assets/css/chart.min.css" rel="stylesheet" />
        <!-- Chart CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- Bootstrap Theme -->
        <link rel="stylesheet" href="assets/css/style.default.css" id="theme-stylesheet">
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/57a4588e0c.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <?php include 'parts/navbar.php'; ?>

        <div class="d-flex align-items-stretch">
            <?php include 'parts/sidebar.php'; ?>
            <div class="page-content">
                <!-- Title -->
                <div class="page-header">
                    <div class="container-fluid">
                        <h2 class="h5 no-margin-bottom">Home</h2>
                    </div>
                </div>

                <!-- Statistics -->
                <section class="no-padding-top no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="statistic-block block">
                                    <div class="progress-details d-flex align-items-end justify-content-between">
                                        <div class="title">
                                            <div><strong>Total Users</strong>
                                            <!--<div class="icon"><i class="icon-user-1"></i></div>-->
                                        </div>
                                        <div class="number dashtext-1"><?php include 'utils/stats.php';
                                                                        echo $totalUsers; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="statistic-block block">
                                    <div class="progress-details d-flex align-items-end justify-content-between">
                                        <div class="title">
                                            <div><strong>Total Licenses</strong>
                                            <!--<div class="icon"><i class="icon-contract"></i></div>-->
                                        </div>
                                        <div class="number dashtext-2"><?php include 'utils/stats.php';
                                                                        echo $totalLicenses; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="statistic-block block">
                                    <div class="progress-details d-flex align-items-end justify-content-between">
                                        <div class="title">
                                            <div><strong>Total Requests</strong>
                                            <!--<div class="icon"><i class="icon-paper-and-pencil"></i></div>-->
                                        </div>
                                        <div class="number dashtext-3"><?php include 'utils/stats.php'; echo $totalRequests; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Request chart -->
                <section class="no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="line-chart block chart">
                                    <div id="snow"></div>
                                    <div class="title">
                                        <strong>Requests per day</strong>
                                    </div>
                                    <canvas id="requestChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- JS Files -->
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/popper.min.js"></script>
        <script type="text/javascript" src="assets/js/front.js"></script>
        <script type="text/javascript" src="assets/js/chart.min.js"></script>
        <script type="text/javascript" src="assets/js/PureSnow.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js" charset="UTF-8"></script>

        <!-- Chart JS -->
        <script>
            $(document).ready(function() {

                'use strict';

                Chart.defaults.global.defaultFontColor = '#75787c';

                var REQUESTCHART = $('#requestChart');
                var requestChart = new Chart(REQUESTCHART, {
                    type: 'line',
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    color: 'transparent'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                gridLines: {
                                    color: 'transparent'
                                },
                                ticks: {
                                    precision: 0
                                }
                            }]
                        },
                    },
                    data: {
                        labels: [<?php echo $dates; ?>],
                        datasets: [{
                            label: "Requests",
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "rgba(134, 77, 217, 0.88)",
                            borderColor: "rgba(134, 77, 217, 088)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "rgba(134, 77, 217, 0.88)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(134, 77, 217, 0.88)",
                            pointHoverBorderColor: "rgba(134, 77, 217, 0.88)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [<?php echo $values; ?>],
                            spanGaps: false
                        }]
                    }
                });
            });
        </script>

        <footer class="footer">
            <div class="footer__block block no-margin-bottom">
                <div class="container-fluid text-center">
                    <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                    <p class="no-margin-bottom">Audi Development @2022</p>
                </div>
            </div>
        </footer>
    </body>

    </html>

<?php

} else {
    header("Location: /login");
    exit();
}
?>