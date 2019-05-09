<?php
$con = mysqli_connect("localhost", "root", "","doingsdone");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: "
        . mysqli_connect_error());
};


// $user_id = 10;меняем id юзера для тестов (9 или 10)





