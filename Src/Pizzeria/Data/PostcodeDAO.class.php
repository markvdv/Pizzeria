<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostcodeDAO
 *
 * @author Mark.Vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Entities\Postcode;

class PostcodeDAO extends DAO {

    public static function getByPostcodeWoonplaats($postcode, $woonplaats) {
        $sql = "SELECT * FROM postcode WHERE postcode=? AND woonplaats=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            return $postcode;
        } else {
            return false;
        }
    }

    public static function getById($id) {
        $sql = "SELECT * FROM postcode WHERE postcodeid=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $postcode = Postcode::create($result['postcodeid'], $result['postcode'], $result['woonplaats']);
            return $postcode;
        } else {
            return false;
        }
    }

}
