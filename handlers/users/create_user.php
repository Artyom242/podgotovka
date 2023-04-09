<?php

//var_dump(json_decode(file_get_contents('php://input'), true));

//header('Content-Type: application/json');
////http_response_code(422);
//
//$data = json_decode(file_get_contents('php://input'), true);
//
//echo json_encode([
//    'id' => 16,
//    'start' => $data['start'] ?? '',
//    'end' => '2023-12-12',
//]);


/** @var PDO $db */
$db = require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

$name = $_POST['name'];
$login = $_POST['login'];
$password = $_POST['password'];
$role = $_POST['role_id'];

$is_user_exist = $db->query('select * from users where login = "{$login}"') ->fetchAll(PDO::FETCH_ASSOC);
if (!empty($name) && !empty($login) && !empty($password) && !empty($role) ){
    if (!$is_user_exist){
        $sql = $db->prepare("insert into users (name, login, password, role) values (?, ?, ?, ?)");
        $sql->execute([$name, $login, $password, $role]);
        var_dump($sql);

        $is_user_exist = $db->query("select * from users where login = {$login}") ->fetchAll(PDO::FETCH_ASSOC);
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode([
            "data" => [
                'id' => $is_user_exist['id'],
                'status' => 'created',
            ]]);
    }
} else{
    json_encode([
        "error" => [
            'code' => '422',
            'message' => 'Validation error',
            'errors' => [
                'login' => 'The login is incorrect',
                'password' => 'The password is incorrect',
            ]
        ]]);
}

header('Content-Type: form-data');
http_response_code(422);
