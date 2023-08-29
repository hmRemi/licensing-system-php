<?php

  if(isset($_COOKIE['USER_TOKEN'])) {
    include '../utils/tokens.php';

    removeToken($_COOKIE['USER_TOKEN']);
  }
  header("Location: /login/");
  exit();
