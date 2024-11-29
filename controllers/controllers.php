<?php

require("./../connection.php");

class Controller {

    var $conn;

    public function __construct() {

        $db = new DB();
        $conn = $db->connection();
        $this->conn = $conn;

        $tableName = "comments";
        $this->checkAndCreateTable($tableName);
    }

    function fetchData() {
        $result = $this->conn->query("SELECT * FROM comments");
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array(
                    "id"=> intval($row["id"]),
                    "comment"=> $row["comment"],
                );
                $data[] = $item;
            }
        } else {
            return [];
        }

        return $data;
    }

    function insertData() {
        $comment = $_POST['comment'];

        $data = array();
        $result = $this->conn->query("INSERT INTO comments (comment) VALUES ('$comment')");
        if ($result) {
            $data['code'] = 200;
            $data['status'] = 'success';
            $data['msg'] = 'Successfully created comment';
            
            
            $dataLast = array(
                'id'=>mysqli_insert_id($this->conn),
                'comment'=> $comment,
            );

            $data['data'] = $dataLast;
            
            return $data;
        } else {
            $data['code'] = 400;
            $data['status'] = 'failed';
            $data['msg'] = 'Failed to created comment';
            
            return $data;
        }
    }

    private function checkAndCreateTable($tableName) {
        $checkTableExists = "SHOW TABLES LIKE '$tableName'";

        $result = $this->conn->query($checkTableExists);

        if ($result->num_rows == 0) {
            $createTableQuery = "
                CREATE TABLE $tableName (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    comment VARCHAR(255) NOT NULL
                )
            ";

            $this->conn->query($createTableQuery);
        }
    }
}