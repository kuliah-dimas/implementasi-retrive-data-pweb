<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
http_response_code(200);
exit;
}

include("./../controllers/controllers.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];

$controller = new Controller();

switch ($requestMethod) {
    case 'GET':
        $data = $controller->fetchData();
        echo json_encode($data);
        break;
    case 'POST':
        $data = $controller->insertData();
        echo json_encode($data);
        break;
    default:
        echo "METHOD NOT FOUND!";
}