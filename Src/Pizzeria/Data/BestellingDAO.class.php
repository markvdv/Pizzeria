<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BestellingDAO
 *
 * @author Mark.Vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Entities\Bestelling;
use Pizzeria\Entities\Leverplaats;
use Pizzeria\Entities\Postcode;

class BestellingDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM bestelling inner join leverplaats on bestelling.leverplaatsid=leverplaats.leverplaatsid inner join postcode on leverplaats.postcodeid=postcode.postcodeid";
        parent::execPreppedStmt($sql);
        $resultSet =parent::$stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $postcode= Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            $leverplaats= Leverplaats::create($result['leverplaatsid'],$result['straat'],$result['huisnummer'],$postcode);
            $bestelling = Bestelling::create($result['bestellingid'], $result['tijdstip'], $result['naam'], $result['voornaam'], $leverplaats, $result['telefoon'],$result['accountid'],$result['opmerking']);
            $arr[] = $bestelling;
        }
        return $arr;
    }
    
    public static function insert($naam, $voornaam, $telefoon, $leverplaatsid,$opmerking=null,$accountid=null) {
        $sql="INSERT INTO bestelling (naam,voornaam,telefoon,leverplaatsid,opmerking,accountid) VALUES (?,?,?,?,?,?)";
        $args=  func_get_args();
        parent::execPreppedStmt($sql,$args);
    }
    public static function delete($id) {
        $sql="DELETE FROM bestelling WHERE bestellingid=?";
        $args=func_get_args();
        parent::execPreppedStmt($sql,$args);
    }

}
