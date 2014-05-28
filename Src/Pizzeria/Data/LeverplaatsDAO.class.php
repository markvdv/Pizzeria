<?php

namespace Pizzeria\Data;

use Pizzeria\Entities\Leverplaats;
use Pizzeria\Entities\Postcode;

class LeverPlaatsDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM leverplaats inner join postcode on leverplaats.postcodeid= postcode.postcodeid";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $arr[] = Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $postcode);
        }
        return $arr;
    }

    public static function insert($straat, $huisnummer, $postcodeid) {
        $sql = "INSERT INTO leverplaats (straat,huisnummer,postcodeid) VALUES(?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    public static function getByStraatHuisnummerPostcodeid($straat, $huisnummer, $postcodeid) {
        $sql = "SELECT * FROM leverplaats  inner join postcode on leverplaats.postcodeid= postcode.postcodeid WHERE straat=? AND huisnummer=? AND leverplaats.postcodeid=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result = parent::$stmt->fetch();
        if ($result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $leverplaats = Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $postcode);
            return $leverplaats;
        }
    }

    public static function getById($leverplaatsid) {
        $sql = "SELECT * FROM leverplaats inner join postcode on leverplaats.postcodeid= postcode.postcodeid WHERE leverplaatsid=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
        $result = parent::$stmt->fetch();
        if ($result) {
             $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $leverplaats = Leverplaats::create($result['leverplaatsid'], $result['straat'], $result['huisnummer'], $postcode);
            return $leverplaats;
        }
    }

}
