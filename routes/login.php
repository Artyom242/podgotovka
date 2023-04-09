<?php

if ($_SERVER['REQUEST_METHOD' == 'POST']) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/handlers/users/login.php';
}