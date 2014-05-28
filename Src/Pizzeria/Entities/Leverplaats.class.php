<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Leverplaats
 *
 * @author TDISK
 */
namespace Pizzeria\Entities;
class Leverplaats {
    
private $leverplaatsid;
private $straat;
private $huisnummer;
private $postcode;
private static $idMap;

private function __construct($leverplaatsid, $straat, $huisnummer, $postcode) {
    $this->leverplaatsid = $leverplaatsid;
    $this->straat = $straat;
    $this->huisnummer = $huisnummer;
    $this->postcode = $postcode;
}
public function create($leverplaatsid, $straat, $huisnummer, $postcode){
    if(!isset(self::$idMap[$leverplaatsid])){
        self::$idMap[$leverplaatsid]= new Leverplaats($leverplaatsid, $straat, $huisnummer, $postcode);
    }
    return self::$idMap[$leverplaatsid];
}
public function getLeverplaatsid() {
    return $this->leverplaatsid;
}

public function getStraat() {
    return $this->straat;
}

public function getHuisnummer() {
    return $this->huisnummer;
}

public function getPostcode() {
    return $this->postcode;
}



}
