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
        $stmt = parent::execPreppedStmt($sql);
        $arr = array();
        $resultSet = $stmt->fetchall();
        foreach ($resultSet as $result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['straat'], $result['huisnummer'], $result['telefoon'], $postcode, $result['pw'], $result['salt'], $result['opmerking'], $result['email'], $result['aantalbestellingen']);
            $arr[] = $account;
        }
        return $arr;
    }

    public static function getByEmail($email) {
        $sql = 'SELECT * FROM account inner join postcode on account.postcodeid=postcode.postcodeid where email=?';
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['straat'], $result['huisnummer'], $result['telefoon'], $postcode, $result['pw'], $result['salt'], $result['opmerking'], $result['email'], $result['aantalbestellingen']);
            return $account;
        } else {
            return false;
        }
    }

    public static function getById($id) {
        $sql = 'SELECT * FROM account inner join postcode on account.postcodeid=postcode.postcodeid where accountid=?';
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $account = Account::create($result['accountid'], $result['naam'], $result['voornaam'], $result['straat'], $result['huisnummer'], $result['telefoon'], $postcode, $result['pw'], $result['salt'], $result['opmerking'], $result['email'], $result['aantalbestellingen']);
            return $account;
        } else {
            return false;
        }
    }

    public static function insert($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcodeid, $email, $pw, $salt, $opmerking, $aantalbestellingen) {
        $sql = "INSERT INTO account (naam,voornaam,straat,huisnummer,telefoon,postcodeid,email,pw,salt,opmerking,aantalbestellingen) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    //public static function update($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcodeid, $email, $opmerking, $id) {
   // public static function update($klant, $id) {
    public static function update($values) {
        // $sql = "UPDATE account  SET naam=?,voornaam=?,straat=?,huisnummer=?,telefoon=?, postcodeid=?,email=?,opmerking=? where accountid=?";
        //$args = func_get_args();
        $sql = "UPDATE account SET ";
            foreach ($values as $key => $value) {
                $args[] = $value;
                if (($key!='Accountid')) {
                    
                $arr[] = strtolower($key);
                }
            }
            $sql.=implode($arr, "=?,");
            $sql.= "=? WHERE accountid=?";
            $stmt = parent::execPreppedStmt($sql, $args);
        }
    }


