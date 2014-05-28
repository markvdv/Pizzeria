<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bestelregel
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Entities;



class Bestelregel {

    private static $idMap = array();
    private $bestelregelid;
    private $product;
    private $bestellingid;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCT">
    private function __construct($bestelregelid, $product,$bestellingid) {
        $this->bestelregelid = $bestelregelid;
        $this->product = $product;
        $this->bestellingid = $bestellingid;
    }

// </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($bestelregelid, $product,$bestellingid) {
        if (!isset(self::$idMap[$bestelregelid])) {
            self::$idMap[$bestelregelid] = new Bestelregel($bestelregelid, $product,$bestellingid);
        }
        return self::$idMap[$bestelregelid];
    }

// </editor-fold>
       
    // <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">
    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product= $product;
    }

    public function getBestelregelid() {
        return $this->bestelregelid;
    }

    public function setBestelregelid($bestelregelid) {
        $this->bestelregelid = $bestelregelid;
    }

    public function getBestellingid() {
        return $this->bestellingid;
    }

    public function setBestellingid($bestellingid) {
        $this->bestellingid = $bestellingid;
    }

// </editor-fold>
}
