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
    private $bestellingid;
    private $productid;

    private function __construct($bestelregelid, $bestellingid,$productid) {
        $this->bestelregelid = $bestelregelid;
        $this->bestellingid = $bestellingid;
        $this->productid=$productid;
    }

    public static function create($bestelregelid, $bestellingid,$productid) {
        if (!isset(self::$idMap[$bestelregelid])) {
            self::$idMap[$bestelregelid] = new Bestelregel($bestelregelid, $bestellingid,$productid);
        }
        return self::$idMap[$bestelregelid];
    }
   
    // <editor-fold defaultstate="collapsed" desc="getter and setter">
    public function getProductid() {
        return $this->productid;
    }

    public function setProductid($productid) {
        $this->productid= $productid;
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
