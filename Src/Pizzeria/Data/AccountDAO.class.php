<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountDAO
 *
 * @author Mark.Vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Data\DAO;
use Pizzeria\Entities\Account;

class AccountDAO extends DAO {

    public static function getAll() {
        $sql = 'SELECT * FROM account';
        parent::execPreppedStmt($sql);
        $arr = array();
        $resultSet = parent::$stmt->fetchall();
        if($resultSet){
        foreach ($resultSet as $result) {
            $account =  Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['telefoon'],$result['email'], $result['pw'], $result['salt'], $result['leverplaatsid']);
            $arr[] = $account;
        }
        return $arr;
        }
    }

    public static function getByEmail($email) {
        $sql = 'SELECT * FROM account where email=?';
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result=parent::$stmt->fetch();
        if ($result) {
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'],$result['telefoon'], $result['email'], $result['pw'], $result['salt'], $result['leverplaatsid']);
            return $account;
        }
    }

    public static function getById($id) {
        $sql = 'SELECT * FROM account where accountid=?';
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result=parent::$stmt->fetch();
        if ($result) {
            $result = $stmt->fetch();
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'],$result['telefoon'], $result['email'], $result['pw'], $result['salt'], $result['leverplaatsid']);
            return $account;
        } else {
            return false;
        }
    }

    public static function insert($naam, $voornaam, $telefoon,$leverplaatsid, $email, $pw, $salt) {
        $sql = "INSERT INTO account (naam,voornaam,telefoon,leverplaatsid,email,pw,salt) VALUES(?,?,?,?,?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }


    

}
