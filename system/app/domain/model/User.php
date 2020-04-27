<?php
namespace app\domain;
use app\domain\Model;

class User extends Model {
    private $m_table = 'users';

    public function index()
    {

    }

    public function create($i_data)
    {
        $sql = "INSERT INTO $this->m_table( name, email, password, at_created) VALUES( :name, :email, :password, :at_created)";

        $data = [
            ':name' => $i_data['name'], 
            ':email' => $i_data['email'], 
            ':password' => password_hash($i_data['password'], PASSWORD_DEFAULT), 
            ':at_created' => date('Y-m-d H:i:s'),
        ];
        $stmt = excuteSQL($sql, $data);
        return $stmt;
    }

    public function show($i_id, $i_all = false)
    {   
        $sql = null;
        if($i_all) {
            $sql = "SELECT * FROM $this->m_table WHERE user_id = :user_id";
        } else {
            $sql = "SELECT * FROM $this->m_table WHERE user_id = :user_id AND delete_flg = 0";
        }
        $data = [':user_id' => $i_id];
        $stmt = excuteSQL($sql, $data);
        return $stmt->fetch();
    }


    public function delete($id)
    {
    
    }

    public function edit()
    {
    
    }



    public function checkDuplicateEmail($i_email, $i_all = false)
    {   
        $sql = null;
        if($i_all) {
            $sql = "SELECT * FROM $this->m_table WHERE email = :email";
        } else {
            $sql = "SELECT * FROM $this->m_table WHERE email = :email AND delete_flg = 0";
        }
        $data = array(':email' => $i_email);
        $stmt = excuteSQL($sql, $data);
        return $stmt->fetch();
    }

}