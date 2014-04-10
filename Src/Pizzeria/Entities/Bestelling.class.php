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
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $telefoon;
    private $postcode;
    private $opmerking;

    private function __construct($bestellingid, $tijdstip, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,$opmerking) {
        $this->bestellingid = $bestellingid;
        $this->tijdstip = $tijdstip;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->telefoon = $telefoon;
        $this->postcode = $postcode;
        $this->opmerking = $opmerking;
    }

    public static function create($bestellingid, $tijdstip, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,$opmerking) {
        if (!isset(self::$idMap[$bestellingid])) {
            self::$idMap[$bestellingid] = new Bestelling($bestellingid, $tijdstip, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,$opmerking);
        }
        return self::$idMap[$bestellingid];
    }

    // <editor-fold defaultstate="collapsed" desc="getter and setter">
    public function getBestellingid() {
        return $this->bestellingid;
    }

    public function setBestellingid($bestellingid) {
        $this->bestellingid = $bestellingid;
    }

    public function getTijdstip() {
        return $this->tijdstip;
    }

    public function setTijdstip($tijdstip) {
        $this->tijdstip = $tijdstip;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function getVoornaam() {
        return $this->voornaam;
    }

    public function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    public function getStraat() {
        return $this->straat;
    }

    public function setStraat($straat) {
        $this->straat = $straat;
    }

    public function getHuisnummer() {
        return $this->huisnummer;
    }

    public function setHuisnummer($huisnummer) {
        $this->huisnummer = $huisnummer;
    }

    public function getTelefoon() {
        return $this->telefoon;
    }

    public function setTelefoon($telefoon) {
        $this->telefoon = $telefoon;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }
    public function getOpmerking() {
        return $this->opmerking;
    }

    public function setOpmerking($opmerking) {
        $this->opmerking= $opmerking;
    }

// </editor-fold>
}
