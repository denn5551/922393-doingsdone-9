<?php
$con = mysqli_connect("localhost", "root", "","doingsdone");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: "
        . mysqli_connect_error());
};

session_start();

$is_auth = isset($_SESSION['user']);





