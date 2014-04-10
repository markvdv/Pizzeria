<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Entities;

class Account {

    private static $idMap = array();
    private $accountid;
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $telefoon;
    private $postcode;
    private $email;
    private $pw;
    private $salt;
    private $opmerking;
    private $aantalbestellingen;
    private $korting=0;

    private function __construct($accountid, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,  $pw, $salt,$opmerking,$email,$aantalbestellingen) {
        $this->accountid = $accountid;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->telefoon = $telefoon;
        $this->postcode = $postcode;
        $this->pw = $pw;
        $this->salt = $salt;
        $this->opmerking = $opmerking;
        $this->email = $email;
        $this->aantalbestellingen = $aantalbestellingen;
    }

    public static function create($accountid, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,  $pw, $salt,$opmerking,$email,$aantalbestellingen) {
        if (!isset(self::$idMap[$accountid])) {
            self::$idMap[$accountid] = new Account($accountid, $naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode,  $pw, $salt,$opmerking,$email,$aantalbestellingen);
        }
        return self::$idMap[$accountid];
    }
   
// <editor-fold defaultstate="collapsed" desc="getter and setter">

    public function getAccountid() {
        return $this->accountid;
    }

    public function setAccountid($accountid) {
        $this->accountid = $accountid;
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPw() {
        return $this->pw;
    }

    public function setPw($pw) {
        $this->pw = $pw;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }
    public function getOpmerking() {
        return $this->opmerking;
    }

    public function setOpmerking($opmerking) {
        $this->opmerking= $opmerking;
    }
    public function getAantalBestellingen() {
        return $this->aantalbestellingen;
    }

    public function setAantalBestellingen($aantalbestellingen) {
        $this->aantalbestellingen= $aantalbestellingen;
    }

    public function getKorting() {
        return $this->korting;
    }

    public function setKorting($korting) {
        $this->korting= $korting;
    }

// </editor-fold>
}
