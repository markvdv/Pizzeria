<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Klant
 * STD class om de gegevens(adres, naam, telefoon, postcodeid) voor de levering bij te houden
 * @author mark.vanderveken
 */

namespace Pizzeria\DTO;

class Klant {
    public function __construct($naam  , $voornaam , $straat, $huisnummer, $telefoon, $postcode, $opmerking) {
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->telefoon = $telefoon;
        $this->postcode = $postcode;
        $this->opmerking = $opmerking;
        $this->email = $email;
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
        $this->opmerking = $opmerking;
    }



}
