<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '\Database.php';

$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$params = explode('/', $q);

if (isset($params[0])) $type = $params[0];
if (isset($params[1])) $id = $params[1];

if ($method === 'GET') {
    if ($type === 'posts') {
        if (isset($id)) {
            Database::getPost($id);
        } else {
            Database::getPosts();
        }
    }
} elseif ($method === 'POST') {
    if ($type === 'posts') {

        // die(print_r($_POST));
        $input['title'] = htmlspecialchars(trim($_POST['title']));
        $input['body'] = htmlspecialchars(trim($_POST['body']));
        Database::addPost($input);
    }
} elseif ($method === 'PATCH') {
    if ($type === 'posts') {
        if (isset($id)) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);

            Database::updatePost($id, $data);
        }
    }
} elseif ($method === 'DELETE') {
    if ($type === 'posts') {
        if (isset($id)) {
            Database::deletePost($id);
        }
    }
}
