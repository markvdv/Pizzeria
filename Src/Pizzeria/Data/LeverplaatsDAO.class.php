<?php

namespace Pizzeria\Data;

use Pizzeria\Entities\Leverplaats;

class LeverPlaatsDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM leverplaats";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $arr[] = Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $result['postcodeid']);
        }
        return $arr;
    }

    public static function insert($straat, $huisnummer, $postcodeid) {
        $sql = "INSERT INTO leverplaats (straat,huisnummer,postcodeid) VALUES(?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    public static function getByStraatHuisnummerPostcodeid($straat, $huisnummer, $postcodeid) {
        $sql = "SELECT * FROM leverplaats WHERE straat=? AND huisnummer=? AND postcodeid=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result=parent::$stmt->fetch();
        if ($result) {
            $result = parent::$stmt->fetch();
            $leverplaats = Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $result['postcodeid']);
            return $leverplaats;
        }
    }

    public static function getById($leverplaatsid) {
        var_dump($leverplaatsid);
        $sql = "SELECT * FROM leverplaats WHERE leverplaatsid=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result = parent::$stmt->fetch();
        if ($result){
        $leverplaats= Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $result['postcodeid']);
        return $leverplaats;
        }
    }

}
