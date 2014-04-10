<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bestelling
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\DTO;
class Winkelmand {
    
    private $bestelregels;
    
    public function __construct() {
        $this->bestelregels = array();
    }

    /**VoegProductToe: voegt product toe aan winkelmandje
     * 
     * @param object $product
     */
    public function VoegProductToe($product) {
        $key = 0;
        while (array_key_exists($key, $this->bestelregels)) {
            $key+=1;
        }
        $this->bestelregels[$key] = $product;
    }
    public function verwijderProduct($id) {
        unset($this->bestelregels[$id]);
    }
    public function getTotaalprijs() {
       $totaal = 0;
       foreach($this->bestelregels as $bestelregel){
           $totaal += $bestelregel->product->getProductprijs();
       }
       return $totaal;
    }

    public function getBestelregels() {
        return $this->bestelregels;
    }
}
