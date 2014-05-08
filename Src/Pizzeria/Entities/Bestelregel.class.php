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
    private $productid;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCT">
    private function __construct($bestelregelid, $productid) {
        $this->bestelregelid = $bestelregelid;
        $this->productid = $productid;
    }

// </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public static function create($bestelregelid, $productid) {
        if (!isset(self::$idMap[$bestelregelid])) {
            self::$idMap[$bestelregelid] = new Bestelregel($bestelregelid, $productid);
        }
        return self::$idMap[$bestelregelid];
    }

// </editor-fold>
       
    // <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">
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
