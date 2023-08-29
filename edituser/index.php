<?php


?>
<?php

if (isset($_COOKIE['USER_TOKEN'])) {

    include '../utils/tokens.php';

    if (!tokenExist($_COOKIE['USER_TOKEN'])) {
        header("Location: /logout");
        exit();
    }


    if (isset($_GET['pl'])) {
        include '../utils/user.php';

        $plugin = $_GET['pl'];
        $licenseInfo = getLicenseInfo($plugin)->fetch_assoc();
        $discord = explode('#', $licenseInfo['DISCORD'])[0];
        $discriminator = explode('#', $licenseInfo['DISCORD'])[1];
        $ips = $licenseInfo['MAX-IPS'];

        if (getID($_COOKIE['USER_TOKEN']) !== 'UNX80G' && getUsername(getID($_COOKIE['USER_TOKEN'])) !== $licenseInfo['CREATED-BY']) {
            header("Location: /licenses");
            exit();
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
                            <h2 class="h5 no-margin-bottom">Edit license</h2>
                        </div>
                    </div>

                    <!-- Edit license form -->
                    <div class="no-padding-top no-padding-bottom">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="block">
                                        <div id="snow"></div>
                                        <div class="title"><strong>Edit the information</strong></div>

                                        <!-- Form -->
                                        <div class="block-body">
                                            <?php if (isset($error)) echo $error; ?>

                                            <form action="" method="POST">
                                                <div class="form-group">
                                                    <label class="form-control-label">Plugin Name</label>
                                                    <input type="text" placeholder="Plugin Name" class="form-control" value="<?php echo $plugin; ?>" name="newPlugin" required>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">License</label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="License" class="form-control" name="newLicense" id="newLicense" value="<?php echo $license; ?>" required>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary" onclick="generateNewLicense()">Generate</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">Discord</label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="example" class="form-control" name="newDiscord" value="<?php echo $discord; ?>" required>
                                                        <div class="input-group-append"><span class="input-group-text">#</span></div>
                                                        <input type="number" placeholder="0001" class="form-control col-md-2" name="newDiscriminator" min="1" max="9999" value="<?php echo $discriminator; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="form-control-label">Max IPs (0 for unlimited IPs)</label>
                                                    <input type="number" placeholder="0" class="form-control" name="newIps" value="<?php echo $ips; ?>" min="0" max="9999" required>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary mt-2">Edit license</button>
                                                </div>
                                            </form>
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

            <script>
                function randomStr(len, arr) {
                    var ans = '';
                    for (var i = len; i > 0; i--) {
                        ans += arr[Math.floor(Math.random() * arr.length)];
                    }
                    return ans;
                }

                function generateNewLicense() {
                    $('#newLicense').val(randomStr(25, '0123456789abcdefghikjlmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'));
                }
            </script>
        </body>

        </html>

<?php
    } else {
        header("Location: /panel/licenses");
        exit();
    }
} else {
    header("Location: /panel/");
    exit();
}
?>