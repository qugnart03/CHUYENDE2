<?php
include_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
class SIEUTHICODE
{
    private $ketnoi;
    public function connect()
    {
        if (!$this->ketnoi) {
            $this->ketnoi = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']) or die('Error => DATABASE');
            mysqli_query($this->ketnoi, "set names 'utf8'");
        }
    }
    public function dis_connect()
    {
        if ($this->ketnoi) {
            mysqli_close($this->ketnoi);
        }
    }
    public function getUser($username)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `users` WHERE `username` = '$username' ")->fetch_array();
        return $row;
    }
    public function site($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `options` WHERE `key` = '$data' ")->fetch_array();
        return $row['value'];
    }
    public function query($sql)
    {
        $this->connect();
        $row = $this->ketnoi->query($sql);
        return $row;
    }
    public function cong($table, $data, $sotien, $where)
    {
        $this->connect();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` + '$sotien' WHERE $where ");
        return $row;
    }
    public function tru($table, $data, $sotien, $where)
    {
        $this->connect();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` - '$sotien' WHERE $where ");
        return $row;
    }
    public function insert($table, $data)
    {
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysqli_real_escape_string($this->ketnoi, $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';

        return mysqli_query($this->ketnoi, $sql);
    }
    public function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $escaped_value = $value !== null ? mysqli_real_escape_string($this->ketnoi, $value) : 'NULL';
            $sql .= "$key = '" . $escaped_value . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return mysqli_query($this->ketnoi, $sql);
    }

    public function update_value($table, $data, $where, $value1)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where . ' LIMIT ' . $value1;
        return mysqli_query($this->ketnoi, $sql);
    }
    public function remove($table, $where)
    {
        $this->connect();
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->ketnoi, $sql);
    }
    public function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }
    public function get_row($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
    public function num_rows($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $row = mysqli_num_rows($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
}

if (isset($_SESSION['username'])) {
    $SIEUTHICODE = new SIEUTHICODE;
    $getUser = $SIEUTHICODE->get_row(" SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "' ");
    $my_username = true;
    $my_money = $getUser['money'];
    $my_level = $getUser['level'];
    if (!$getUser) {
        session_start();
        session_destroy();
        header('location: /');
    }
    if ($getUser['money'] < 0) {
        $SIEUTHICODE->update("users", array(
            'banned' => 1,
        ), "username = '" . $_SESSION['username'] . "' ");
        session_start();
        session_destroy();
        header('location: /');
        die();
    }
    $SIEUTHICODE->update("users", [
        'time'  => time(),
        'device'=>$_SERVER['HTTP_USER_AGENT']
    ], " `id` = '" . $getUser['id'] . "' ");
} else {
    $my_level = null;
    $my_money = 0;
}
function CheckLogin()
{
    global $my_username;
    if ($my_username != true) {
        return die('<script type="text/javascript">setTimeout(function(){ location.href = "' . BASE_URL('Auth/Login') . '" }, 0);</script>');
    }
}
function CheckAdmin()
{
    global $my_level;
    if ($my_level != 'admin') {
        return die('<script type="text/javascript">setTimeout(function(){ location.href = "' . BASE_URL('Auth/Login') . '" }, 0);</script>');
    }
}
function CheckCtv()
{
    global $my_level;
    if ($my_level != 'ctv') {
        return die('<script type="text/javascript">setTimeout(function(){ location.href = "' . BASE_URL('') . '" }, 0);</script>');
    }
}