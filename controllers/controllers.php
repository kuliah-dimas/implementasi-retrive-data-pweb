<?php

require("./../connection.php");

class Controller {

    function fetchData() {
        $db = new DB();
        $conn = $db->connection();

        $result = $conn->query("SELECT * FROM comments");
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
        $db = new DB();
        $conn = $db->connection();

        $comment = $_POST['comment'];

        $data = array();
        $result = $conn->query("INSERT INTO comments (comment) VALUES ('$comment')");
        if ($result) {
            $data['code'] = 200;
            $data['status'] = 'success';
            $data['msg'] = 'Successfully created comment';
            
            
            $dataLast = array(
                'id'=>mysqli_insert_id($conn),
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
}