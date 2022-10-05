<?php

class Database
{
    private const HOST = 'localhost';
    private const USER = 'root';
    private const PASS = '';
    private const DB_NAME = 'api_test';

    public static function getConnection()
    {
        $dsn = "mysql:host=" . self::HOST . "; dbname=" . self::DB_NAME . ";";
        $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
        $db = new PDO($dsn, self::USER, self::PASS, $options);

        return $db;
    }

    public static function getPosts()
    {
        $db = self::getConnection();
        $db = $db->query('SELECT * FROM posts');
        $postsList = [];
        while ($post = $db->fetch()) {
            $postsList[] = $post;
        }
        echo json_encode($postsList, JSON_UNESCAPED_UNICODE);
    }

    public static function getPost($id)
    {
        $db = self::getConnection();
        $db = $db->prepare('SELECT * FROM posts WHERE id = ?');
        $db->execute([$id]);
        $post = $db->fetch();

        if ($post) {
            echo json_encode($post, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Post not found'
            ];
            echo json_encode($res);
        }
    }

    public static function addPost($input)
    {
        $db = self::getConnection();
        $query = $db->prepare("INSERT INTO posts VALUES (null, ?, ?);");
        $query->execute([$input['title'], $input['body']]);

        $res = [
            'status' => true,
            'post_id' => $db->lastInsertId()
        ];

        http_response_code(201);

        echo json_encode($res);
    }

    public static function updatePost($id, $input) {
        $db = self::getConnection();
        $query = $db->prepare("UPDATE posts SET title = ?, body = ? WHERE id = ?");
        $query->execute([$input['title'], $input['body'], $id]);

        $res = [
            'status' => true,
            'message' => "Post id $id is updated"
        ];

        http_response_code(200);
        
        echo json_encode($res);
    }

    public static function deletePost($id) {
        $db = self::getConnection();
        $query = $db->prepare('DELETE FROM posts WHERE id = ?');
        $query->execute([$id]);

        $res = [
            'status' => true,
            'message' => "Post id $id is deleted"
        ];

        http_response_code(200);
        
        echo json_encode($res);
    }
}
