<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '\Database.php';

$method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $params = explode('/', $q);

    if (isset($params[0])) $type = $params[0];
    if (isset($params[1])) $id = $params[1];

    switch($method) {
        case 'GET':
            isset($id) ? Database::getPost($id) : Database::getPosts();
            break;
        case 'POST':
            if ($type === 'posts') {
                $input['title'] = htmlspecialchars(trim($_POST['title']));
                $input['body'] = htmlspecialchars(trim($_POST['body']));
                Database::addPost($input);
            }
            break;
        case 'PATCH':
            if ($type === 'posts') {
                if (isset($id)) {
                    $data = file_get_contents('php://input');
                    $data = json_decode($data, true);
                    Database::updatePost($id, $data);
                }
            }
            break;
        case 'DELETE':
            if ($type === 'posts') {
                if (isset($id)) {
                    Database::deletePost($id);
                }
            }
            break;
    }
}
