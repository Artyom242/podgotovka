<?php
/** @var PDO $db */
$db = require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

$login = htmlspecialchars(['login']);
$password = htmlspecialchars(['password']);

if (!empty($login) && !empty($password)) {
    $base_login = $db->query('select * from users where login = "{$login}"');
    $base_password = $db->query('select * from users where password = "{$password}"');

    if ($base_login == $login && $password == $base_password ){
        $_SESSION['id'] = $login ;

        http_response_code(200);
        $data = json_decode(file_get_contents('php://input'), true);

        json_encode([
            'data' => [
                'user_token' => ''
            ]
        ]);
    }
} else {
    http_response_code(401);
    $data = json_decode(file_get_contents('php://input'), true);
    json_encode([
        'error' => [
            'code' => '401',
            'message' => 'Authentication failed'
        ]
    ]);
}

header('Content-Type: application/json');
//http_response_code(422);
