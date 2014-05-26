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

use Pizzeria\Business\ProductService;
use Pizzeria\Business\UserService;
use Pizzeria\Data\AccountDAO;
use Pizzeria\Data\BestellingDAO;
use Pizzeria\Data\BestelregelDAO;
use Pizzeria\Data\PostcodeDAO;
use Pizzeria\Exceptions\WinkelmandLeegException;

class ApplicatieService {

    public static function geefPizzaLijst() {
        $producten = ProductService::toonProducten();
        return $producten;
    }

    public static function controleerKlantgegevens($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $woonplaats) {
        $foutenarray = UserService::controleerKlantgegevens($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $woonplaats);
        if ($foutenarray) {
            return $foutenarray;
        }
    }

    public static function rondBestellingAf($winkelmand, $klant) {
        // <editor-fold defaultstate="collapsed" desc="check voor lege winkelmand">
        if (!isset($winkelmand->bestelregels)) {
            throw new WinkelmandLeegException;
        }// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="check of postcode een object of getal is, indien getal ->object">
        if (!is_object($klant->getPostcode())) {
            $klant->postcode = PostcodeDAO::getByPostcodeWoonplaats($klant->postcode, $klant->woonplaats);
        }// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="check of klant een account heeft zo ja dan is accountid klantnr, zo nee is bestellingid klantnr">
        if (null !== $klant->getEmail() && $klant->getEmail() !== "") {
            $account = AccountDAO::getByEmail($klant->getEmail());
            $klantnr = $account->getAccountid();
        } else {
            $klantnr = BestellingDAO::getLastInsertId() + 1;
        }
// </editor-fold>
        BestellingDAO::insert($klant->getNaam(), $klant->getVoornaam(), $klant->getStraat(), $klant->getHuisnummer(), $klant->getTelefoon(), $klant->getPostcode()->getPostcodeid(), $klantnr, $klant->getOpmerking());
        $bestellingid = BestellingDAO::getLastInsertId();
        //$bestelregelid = BestellingDAO::getLastInsertId();
        foreach ($winkelmand->bestelregels as $bestelregel) {
            BestelregelDAO::insert($bestellingid, $bestelregel->getProductid());
        }
        $klant->setAantalBestellingen($klant->getAantalBestellingen() + 1);
        if (isset($account)) {

            UserService::veranderGevens($klant);
        }
    }

}
