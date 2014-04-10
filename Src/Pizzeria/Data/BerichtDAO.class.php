<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BerichtDAO
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Entities\Bericht;

class BerichtDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM bericht";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $bericht = Bericht::create($result['berichtid'], $result['auteur'], $result['tijdstip'], $result['text']);
            $arr[] = $bericht;
        }
        return $arr;
    }

    public static function insert($auteur, $text) {
        $sql = "INSERT into bericht(auteur,text) VALUES (?,?)";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $stmt->fetch();
    }

}
