<?php

if (isset($_COOKIE['USER_TOKEN'])) {

    include '../utils/tokens.php';

    if (!tokenExist($_COOKIE['USER_TOKEN'])) {
        header("Location: /panel/logout");
        exit();
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Audi Development</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="msapplication-TileImage" content="/panel/assets/img/favicon.png">
        <!-- ICONS -->
        <link rel="shortcut icon" type="image/x-icon" href="/panel/assets/img/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/panel/assets/img/favicon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/panel/assets/img/favicon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/panel/assets/img/favicon.png">
        <!-- Material Icons -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- Google fonts - Muli-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
        <!-- Bootstrap CSS -->
        <link href="/panel/assets/css/chart.min.css" rel="stylesheet" />
        <!-- Chart CSS -->
        <link href="/panel/assets/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="/panel/assets/css/custom.css" rel="stylesheet" />
        <!-- Bootstrap Theme -->
        <link rel="stylesheet" href="/panel/assets/css/style.default.css" id="theme-stylesheet">
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/57a4588e0c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php include '../parts/navbar.php'; ?>

        <div class="d-flex align-items-stretch">
            <?php include '../parts/sidebar.php'; ?>

            <div class="page-content">
                <!-- Title -->
                <div class="page-header">
                    <div class="container-fluid">
                        <h2 class="h5 no-margin-bottom">Users</h2>
                    </div>
                </div>

                <!-- Table of Licenses -->
                <div class="no-padding-top no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="block">
                                    <div id="snow"></div>
                                    <div class="title"><strong>Manage the users</strong> <button type="button" class="btn btn-success float-right"><a href="new.php"><i class="fas fa-plus"></i> Create an user</a></button></div>

                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead class="thead-dark">
                                                <tr class="text-center">
                                                    <th>Username</th>
                                                    <th>Permissions</th>
                                                    <th>ID</th>
                                                    <th> </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                include '../utils/mysql.php';
                                                $sql = "SELECT * FROM users";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    $i = 0;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $i++;
                                                        echo "<tr>";

                                                        echo "<center><td><center>" . $row['USERNAME'] . (getID($_COOKIE['USER_TOKEN']) === $row['ID'] ? " <strong>(You)</strong>" : "") . "</center></td></center>";
                                                        echo "<center><td><center>" . (getID($_COOKIE['USER_TOKEN']) === $row['ID'] ? "Administrator" : "Sub-Administrator") . "</center></td></center>";
                                                        echo "<center><td><center>" . $row['ID'] . "</center></td></center>";
                                                        echo "<center><td><center><button type=\"button\" class=\"btn btn-danger float-right btn-sm\" data-toggle=\"modal\" data-target=\"#confirm$i\"" . ($row['ID'] === 'UNX80G' ? " disabled style= \"cursor: not-allowed;\"" : "") . ">Delete</button></center></td></center>";
                                                ?>

                                                        <!-- Modal of confirm delete -->
                                                        <div id="confirm<?php echo $i; ?>" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
                                                            <div role="document" class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"><strong class="modal-title">Delete confirmation</strong>
                                                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close" style="border: none; outline: none;"><span aria-hidden="true">×</span></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete the user '<?php echo $row['USERNAME']; ?>'?</p>
                                                                        <p>All his licenses will be deleted.</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                                                        <button type="button" class="btn btn-danger"><a <?php echo "href=\"delete.php?usr=" . $row['USERNAME'] . "&id=" . $row['ID'] . "\""; ?>>Delete</a></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                <?php
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<div class=\"alert alert-danger\"><center>There are no licenses yet<center></div>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS Files -->
        <script type="text/javascript" src="/panel/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/popper.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/front.js"></script>
        <script type="text/javascript" src="/panel/assets/js/chart.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/PureSnow.js"></script>
        <script type="text/javascript" src="/panel/assets/js/bootstrap.min.js" charset="UTF-8"></script>
    </body>

    </html>

<?php
} else {
    header("Location: /panel/login");
    exit();
}
?>