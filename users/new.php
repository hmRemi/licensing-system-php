<?php

function generateID()
{
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['usr']) && isset($_POST['passwd'])) {
    $usr = $_POST['usr'];
    $passwd = $_POST['passwd'];

    include '../utils/mysql.php';
    include '../utils/user.php';
    include '../utils/licenses.php';

    $checkStmt = $conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
    $checkStmt->bind_param("s", $usr);
    $checkStmt->execute();

    if ($checkStmt->get_result()->num_rows > 0) {
        $error = "<div class=\"alert alert-danger\"><center>That user already exists.<center></div>";
    } else {
        $id = generateID();

        $first_hash = hash('sha256', $passwd);
        $second_hash = hash('sha512', $first_hash);
        $third_hash = hash('sha512', $second_hash);
        $final_hash = password_hash($third_hash, PASSWORD_ARGON2I, ['memory_cost' => 1024, 'time_cost' => 4, 'threads' => 1]);

        $stmt = $conn->prepare("INSERT INTO users (USERNAME, `PASSWORD`, ID) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usr, $final_hash, $id);
        $stmt->execute();

        $error = "<div class=\"alert alert-success\"><center>User successfully created.<center></div>";
    }
}

?>


<?php

if (isset($_COOKIE['USER_TOKEN'])) {

    include '../utils/tokens.php';

    if (!tokenExist($_COOKIE['USER_TOKEN'])) {
        header("Location: /logout");
        exit();
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Licenses</title>
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
                        <h2 class="h5 no-margin-bottom">New user</h2>
                    </div>
                </div>

                <!-- Add License form -->
                <div class="no-padding-top no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="block">
                                    <div id="snow"></div>
                                    <div class="title"><strong>Fill the information</strong></div>

                                    <!-- Form -->
                                    <div class="block-body">
                                        <?php if (isset($error)) echo $error; ?>

                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <label class="form-control-label">Username</label>
                                                <input type="text" placeholder="Username" class="form-control" name="usr" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">Password</label>
                                                <input type="password" placeholder="Password" class="form-control" name="passwd" required>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary mt-2">Add user</button>
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
    </body>

    </html>

<?php

} else {
    header("Location: /panel/login");
    exit();
}

?>