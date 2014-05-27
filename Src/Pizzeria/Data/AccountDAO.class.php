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

use Pizzeria\Entities\Account;
use Pizzeria\Entities\Postcode;
use Pizzeria\Data\DAO;

class AccountDAO extends DAO {

    public static function getAll() {
        $sql = 'SELECT * FROM account inner join postcode on account.postcodeid=postcode.postcodeid';
        parent::execPreppedStmt($sql);
        $arr = array();
        $resultSet = parent::$stmt->fetchall();
        foreach ($resultSet as $result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['straat'], $result['huisnummer'], $result['telefoon'], $postcode, $result['pw'], $result['salt'], $result['opmerking'], $result['email'], $result['aantalbestellingen']);
            $arr[] = $account;
        }
        return $arr;
    }

    public static function getByEmail($email) {
        $sql = 'SELECT * FROM account where email=?';
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result=parent::$stmt->fetch();
        if ($result) {
            $result = parent::$stmt->fetch();
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['email'], $result['pw'], $result['salt'], $result['leverplaatsid']);
            return $account;
        }
    }

    public static function getById($id) {
        $sql = 'SELECT * FROM account inner join postcode on account.postcodeid=postcode.postcodeid where accountid=?';
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result=parent::$stmt->fetch();
        if ($result) {
            $result = $stmt->fetch();
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['straat'], $result['huisnummer'], $result['telefoon'], $postcode, $result['pw'], $result['salt'], $result['opmerking'], $result['email'], $result['aantalbestellingen']);
            return $account;
        } else {
            return false;
        }
    }

    public static function insert($naam, $voornaam, $leverplaatsid, $email, $pw, $salt) {
        $sql = "INSERT INTO account (naam,voornaam,leverplaatsid,email,pw,salt) VALUES(?,?,?,?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }


    

}
