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
    public function voegProductToe($product) {
        $this->bestelregels[] = array();
        end($this->bestelregels);
        $key = key($this->bestelregels);
        $this->bestelregels[$key]['product'] = $product;
    }
    public function verwijderProduct($productindex) {
        unset($this->bestelregels[$productindex]);
    }
    public function getTotaalprijs() {
       $totaal = 0;
       foreach($this->bestelregels as $product){
           $totaal += $product['product']->getProductprijs();
       }
       return $totaal/100;
    }

    public function getBestelregels() {
        return $this->bestelregels;
    }
}
