<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Postcode
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Entities;

class Postcode {

    private static $idMap = array();
    private $postcodeid;
    private $postcode;
    private $woonplaats;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCT">
    private function __construct($postcodeid, $postcode, $woonplaats) {
        $this->postcodeid = $postcodeid;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
    }

// </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($postcodeid, $postcode, $woonplaats) {
        if (!isset(self::$idMap[$postcodeid])) {
            self::$idMap[$postcodeid] = new Postcode($postcodeid, $postcode, $woonplaats);
        }
        return self::$idMap[$postcodeid];
    }

// </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">
    public function getPostcodeid() {
        return $this->postcodeid;
    }

    public function setPostcodeid($postcodeid) {
        $this->postcodeid = $postcodeid;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function getWoonplaats() {
        return $this->woonplaats;
    }

    public function setWoonplaats($woonplaats) {
        $this->woonplaats = $woonplaats;
    }

// </editor-fold>
}
