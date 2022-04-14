<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/car.php';

$database = new Database();
$db = $database->getConnection();

$car = new Car($db);

$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что на парковке есть места
if ($car->count() < 10) {

    if($car->create()){

        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Машина добавлена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается, сообщим пользователю
    else {

        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Ошибка!."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что мест нет
else {

    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Нет мест!"), JSON_UNESCAPED_UNICODE);
}
