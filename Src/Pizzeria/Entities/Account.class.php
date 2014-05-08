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
    private $email;
    private $pw;
    private $salt;
    private $leverplaats;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCTOR">
    function __construct($accountid, $naam, $voornaam, $email, $pw, $salt, $leverplaats) {
        $this->accountid = $accountid;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->email = $email;
        $this->pw = $pw;
        $this->salt = $salt;
        $this->leverplaats = $leverplaats;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($accountid, $naam, $voornaam, $email, $pw, $salt, $leverplaats) {
        if (!isset(self::$idMap[$accountid])) {
            self::$idMap[$accountid] = new Account($accountid, $naam, $voornaam, $email, $pw, $salt, $leverplaats);
        }
        return self::$idMap[$accountid];
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">

    public function getAccountid() {
        return $this->accountid;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function getVoornaam() {
        return $this->voornaam;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPw() {
        return $this->pw;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getLeverplaats() {
        return $this->leverplaats;
    }

    public function setAccountid($accountid) {
        $this->accountid = $accountid;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPw($pw) {
        $this->pw = $pw;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setLeverplaats($leverplaats) {
        $this->leverplaats = $leverplaats;
    }

// </editor-fold>
}
