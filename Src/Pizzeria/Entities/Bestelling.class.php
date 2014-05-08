<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bestelling
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Entities;

class Bestelling {

    private static $idMap = array();
    private $bestellingid;
    private $tijdstip;
    private $leverplaatsid;
    private $accountid;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCTOR">
    function __construct($bestellingid, $tijdstip, $leverplaatsid, $accountid) {
        $this->bestellingid = $bestellingid;
        $this->tijdstip = $tijdstip;
        $this->leverplaatsid = $leverplaatsid;
        $this->accountid = $accountid;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($bestellingid, $tijdstip, $leverplaatsid, $accountid) {
        if (!isset(self::$idMap[$bestellingid])) {
            self::$idMap[$bestellingid] = new Bestelling($bestellingid, $tijdstip, $leverplaatsid, $accountid);
        }
        return self::$idMap[$bestellingid];
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">
    public function getBestellingid() {
        return $this->bestellingid;
    }

    public function getTijdstip() {
        return $this->tijdstip;
    }

    public function getLeverplaatsid() {
        return $this->leverplaatsid;
    }

    public function getAccountid() {
        return $this->accountid;
    }

    public function setBestellingid($bestellingid) {
        $this->bestellingid = $bestellingid;
    }

    public function setTijdstip($tijdstip) {
        $this->tijdstip = $tijdstip;
    }

    public function setLeverplaatsid($leverplaatsid) {
        $this->leverplaatsid = $leverplaatsid;
    }

    public function setAccountid($accountid) {
        $this->accountid = $accountid;
    }

// </editor-fold>
}
