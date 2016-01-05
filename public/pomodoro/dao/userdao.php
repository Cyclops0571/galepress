<?php

require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../model/user.php";
require_once dirname(__FILE__) . "/dao.php";

class UserDao extends Dao
{
    public function create_table()
    {
        $db = $this->get_connection();

        $result = $db->query("CREATE TABLE user(username VARCHAR(255) PRIMARY KEY, status VARCHAR(10), begin INTEGER) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
        echo $result;
    }

    public function add($user)
    {
        $db = parent::get_connection();
        if ($stmt = $db->prepare("INSERT INTO user (username, status, begin) VALUES (?, ?, ?) ")) {
            $stmt->bind_param('sss', $user->username, $user->status, $user->begin);
            $stmt->execute();
            $stmt->close();
        }
        return $user;
    }

    public function update($user)
    {
        $db = $this->get_connection();
        if ($stmt = $db->prepare("UPDATE user SET status = ?, begin = ? WHERE username = ?")) {
            $stmt->bind_param('sss', $user->status, $user->begin, $user->username);
            $stmt->execute();
            $stmt->close();
        }
        return $user;
    }

    public function delete($username)
    {
        $db = $this->get_connection();
        if ($stmt = $db->prepare("DELETE FROM user WHERE username = ?")) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->close();
        }
        return true;
    }

    public function get($username)
    {
        $user = null;
        $db = $this->get_connection();
        if ($stmt = $db->prepare("SELECT user.status, user.begin, record.* FROM user INNER JOIN record on user.username = record.username WHERE record.date = ?  user.username = ?")) {
            $stmt->bind_param('ss', date('Y-m-d'), $username);
            $stmt->execute();
            $stmt->bind_result($username, $status, $begin, $date, $success, $fail);
            if ($stmt->fetch()) {
                $user = new User();
                $user->username = $username;
                $user->status = $status;
                $user->begin = $begin;
                $user->date = $date;
                $user->success = $success;
                $user->fail = $fail;
      }
            $stmt->close();
        }
        return $user;
    }

    public function get_all()
    {
        $users = array();
        $db = $this->get_connection();
        if ($stmt = $db->prepare("SELECT user.status, user.begin, record.* FROM user INNER JOIN record on user.username = record.username WHERE record.date = ? ORDER BY user.username")) {
            $stmt->bind_param('s', date('Y-m-d'));
            $stmt->execute();
            $stmt->bind_result($username, $status, $begin, $date, $success, $fail);
            while ($stmt->fetch()) {
                $user = new User();
                $user->username = $username;
                $user->status = $status;
                $user->begin = $begin;
                $user->date = $date;
                $user->success = $success;
                $user->fail = $fail;
                $users[] = $user;
            }
            $stmt->close();
        }
        return $users;
    }

    function __destruct()
    {
        parent::__destruct();
    }
}
