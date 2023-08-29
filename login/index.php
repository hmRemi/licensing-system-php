<?php

require '../utils/mysql.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $first_hash = hash('sha256', $password);
    $second_hash = hash('sha512', $first_hash);
    $third_hash = hash('sha512', $second_hash);

    $stmt = $conn->prepare("SELECT * FROM users WHERE USERNAME = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result= $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if(password_verify($third_hash, $row['PASSWORD'])) {
            // Username and password verified

            include '../utils/tokens.php';

            setToken(generateToken(), $row['ID']);

            header("Location: /panel/");
            exit();
        }else{
            $error = "<div class=\"alert alert-danger\"><center>Invalid username or password<center></div>";
        }
    }else{
        $error = "<div class=\"alert alert-danger\"><center>Invalid username or password<center></div>";
    }
}

?>

<?php

if (!isset($_COOKIE['USER_TOKEN'])) {

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

<div id="snow"></div>
    <body style="background: #22252a;">
        <div class="container">
            <div class="row" style="padding-top: 25%">
                <div class="card col-md-4 mr-auto ml-auto border-primary">
                    <form class="form" action="" method="POST">
                        <div class="card-header text-center"><strong>Audi Development</strong></div>

                        <div class="card-body">
                            <!-- Error alert -->
                            <?php if (isset($error)) echo $error; ?>

                            <!-- Username -->
                            <div class="form-group">
                                <label class="form-control-label"></label>
                                <input id="username" type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="form-control-label"></label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-2 col-md-12">Log in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JS Files -->
        <script type="text/javascript" src="/panel/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/popper.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/front.js"></script>
        <script type="text/javascript" src="/panel/assets/js/chart.min.js"></script>
        <script type="text/javascript" src="/panel/assets/js/custom-chart.js"></script>
        <script type="text/javascript" src="/panel/assets/js/PureSnow.js"></script>
        <script type="text/javascript" src="/panel/assets/js/bootstrap.min.js" charset="UTF-8"></script>
    </body>

    </html>

<?php

} else {
    header("Location: /panel/");
    exit();
}

?>