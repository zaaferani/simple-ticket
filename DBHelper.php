<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 9:38 AM
 */

class DBHelper {
    private $conn;
    /**
     * DBHelper constructor.
     * @param $host
     * @param $db
     * @param $user
     * @param $password
     */
    public function __construct($host, $db, $user, $password)
    {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die;
        }
    }

    public function __destruct()
    {
        $this->conn = null; // close connection
    }

    public function checkLogin($username, $password){
        $res = $this->conn->prepare("
            SELECT * FROM users WHERE username = :username AND password = :password;
        ");

        $res->execute([
            ':username' => $username,
            ':password' => $password,
        ]);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $result = $res->fetchAll();
        if (!$result){
            return false;
        }
        return $result[0];

//        $res = $this->conn->query("
//            SELECT * FROM users
//            WHERE username = '$username' AND password = '$password';
//        ");
//        $result = $res->fetchAll(PDO::FETCH_ASSOC);
//        if (!$result){
//            return false;
//        }
//        return $result[0];
    }

    private function insert($table, $entity){
        $fields = [];
        $values = [];
        $param = [];
        foreach ($entity as $k=>$v){
            array_push($fields, $k);
            array_push($values, ":$k");
            $param[":$k"] = $v;
        }
        $fields = join("," , $fields);
        $values = join("," , $values);
        $res = $this->conn->prepare("
            INSERT INTO $table ($fields) VALUES ($values);
        ");

        $res->execute($param);
        return $this->conn->lastInsertId();
    }
    /**
     * @param $user array array of user information based users table
     * @return int return Id of inserted row
     */
    public function insertUser($user)
    {
        return $this->insert("users", $user);
    }

    public function checkUsername($username)
    {
        $res = $this->conn->prepare("
            SELECT * FROM users WHERE username = :username;
        ");

        $res->execute([
            ':username' => $username,
        ]);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $result = $res->fetchAll();
        if (!$result){
            return false;
        }
        return $result[0];
    }
    public function checkEmail($email)
    {
        $res = $this->conn->prepare("
            SELECT * FROM users WHERE email = :email;
        ");
        $res->execute([
            ':email' => $email,
        ]);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $result = $res->fetchAll();
        if (!$result){
            return false;
        }
        return $result[0];
    }

    public function getUser($id){
        $res = $this->conn->prepare("SELECT * FROM users WHERE id = :id;");
        $res->execute([
            ':id' => $id,
        ]);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $result = $res->fetchAll();
        if (!$result){
            return false;
        }
        return $result[0];
    }

    public function update($table, $entity, $where)
    {
        $set_fields = [];
        $w_fields = [];
        $param = [];
        foreach ($entity as $k=>$v){
            array_push($set_fields, "$k = :$k");
            $param[":$k"] = $v;
        }

        $set_fields = join(" , " , $set_fields);
        foreach ($where as $k=>$v){
            array_push($w_fields, "$k = :$k");
            $param[":$k"] = $v;
        }
        $w_fields = join(" AND " , $w_fields);
        $res = $this->conn->prepare("
            UPDATE $table SET $set_fields WHERE $w_fields;
        ");

        $res->execute($param);
        return $res->errorCode();
    }
}