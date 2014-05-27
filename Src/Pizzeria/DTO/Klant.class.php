<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Klant
 * 
 * @author mark.vanderveken
 */

namespace Pizzeria\DTO;

class Klant {
   private $naam;
   private $voornaam;
   private $straat;
   private $huisnummer; 
   private $telefoon; 
   private $postcode;
   private $woonplaats;
   private $opmerking;
   private $email;
   private $accountid;
    
    
    
    
    public function __construct($naam  , $voornaam , $straat, $huisnummer, $telefoon, $postcode,$woonplaats, $opmerking=null,$email=null,$accountid=null) {
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->telefoon = $telefoon;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->opmerking = $opmerking;
        $this->email = $email;
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

    public function getWoonplaats() {
        return $this->woonplaats;
    }

    public function setWoonplaats($woonplaats) {
        $this->woonplaats = $woonplaats;
    }
    public function getEmail() {
        return $this->email;
    }


}
