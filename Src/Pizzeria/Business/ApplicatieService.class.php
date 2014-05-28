<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicatieService
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Business;

use Pizzeria\Business\LeverplaatsService;
use Pizzeria\Business\ProductService;
use Pizzeria\Business\UserService;
use Pizzeria\Data\LeverPlaatsDAO;
use Pizzeria\Data\PostcodeDAO;

class ApplicatieService {

    public static function geefPizzaLijst() {
        $producten = ProductService::toonProducten();
        return $producten;
    }

    public static function controleerKlantgegevens($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $woonplaats, $cbregistratie, $email, $password, $passwordconfirm) {
        $foutenarray = UserService::controleerKlantgegevens($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $woonplaats, $cbregistratie, $email, $password, $passwordconfirm);
        if ($foutenarray) {
            return $foutenarray;
        }
        $oPostcode = PostcodeDAO::getByPostcodeWoonplaats($postcode, $woonplaats);

        if ($cbregistratie !== null) {
        //check of leverplaats al in de database zit 
            $leverplaats = LeverPlaatsDAO::getByStraatHuisnummerPostcodeid($straat, $huisnummer, $oPostcode->getPostcodeid());
            if (!$leverplaats) {
                $leverplaatsid = LeverplaatsService::maakLeverplaatsAan($straat, $huisnummer, $oPostcode->getPostcodeid());
            } else {
                $leverplaatsid = $leverplaats->getLeverplaatsid();
            }
            UserService::maakAccountAan($naam, $voornaam, $leverplaatsid, $email, $password);
        }
    }

    public static function rondBestellingAf($winkelmand, $klant) {
        // <editor-fold defaultstate="collapsed" desc="check voor lege winkelmand">
     
        BestellingService::rondBestellingAf($winkelmand, $klant);
    }

}
