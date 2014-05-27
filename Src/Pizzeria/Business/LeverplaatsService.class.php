<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeverplaatsService
 *
 * @author TDISK
 */
namespace Pizzeria\Business;
use Pizzeria\Data\LeverplaatsDAO;

class LeverplaatsService {
     public static function maakLeverPlaatsAan($straat, $huisnummer,$postcode) {
        LeverplaatsDAO::insert($straat, $huisnummer,$postcode);
        return LeverplaatsDAO::getLastInsertId();
    }
}
