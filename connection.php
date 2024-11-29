<?php

class DB {
    function connection() {
        $db_name = "retrive_data_comment";
        $db_user = "root";
        $db_pass = "";
        $db_host = "localhost";
        $db_port = 3306;

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
        return $conn;
    }
}