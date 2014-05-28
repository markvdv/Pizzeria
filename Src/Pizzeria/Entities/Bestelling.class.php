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
    private $leverplaats;
    private $telefoon;
    private $accountid;
    private $opmerking;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCTOR">
    function __construct($bestellingid, $tijdstip, $naam,$voornaam,$leverplaats,$telefoon, $accountid,$opmerking) {
        $this->bestellingid = $bestellingid;
        $this->tijdstip = $tijdstip;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->leverplaats = $leverplaats;
        $this->accountid = $accountid;
        $this->telefoon = $telefoon;
        $this->opmerking=$opmerking;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($bestellingid, $tijdstip, $naam,$voornaam,$leverplaats,$telefoon, $accountid,$opmerking) {
        if (!isset(self::$idMap[$bestellingid])) {
            self::$idMap[$bestellingid] = new Bestelling($bestellingid, $tijdstip, $naam,$voornaam,$leverplaats,$telefoon, $accountid,$opmerking);
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

    public function getLeverplaats() {
        return $this->leverplaats;
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

    public function setLeverplaats($leverplaats) {
        $this->leverplaats = $leverplaats;
    }

    public function setAccountid($accountid) {
        $this->accountid = $accountid;
    }
    public function getTelefoon() {
        return $this->telefoon;
    }
    public function getOpmerking() {
        return $this->opmerking;
    }
// </editor-fold>
}
