<?php

namespace Pizzeria\Business;

use Pizzeria\Data\BestellingDAO;
use Pizzeria\Data\BestelregelDAO;
use Pizzeria\Data\PostcodeDAO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BestelService
 *
 * @author Mark.Vanderveken
 */
class BestellingService {

    public static function prepBestellingOverzicht() {
        $bestellingen = BestellingDAO::getAll();
        $bestelregels = BestelregelDAO::getAll();
        $arr = array();
        foreach ($bestellingen as $bestelling) {
            $arr[$bestelling->getBestellingid()] = array();
            $arr[$bestelling->getBestellingid()]['bestelling'] = $bestelling;
            $arr[$bestelling->getBestellingid()]['totaalprijs'] = 0;
            foreach ($bestelregels as $bestelregel) {

                if ($bestelregel->getBestellingid() == $bestelling->getBestellingid()) {
                    $arr[$bestelling->getBestellingid()]['bestelregels'][] = $bestelregel;
                    $arr[$bestelling->getBestellingid()]['totaalprijs']+=$bestelregel->getProduct()->getProductPrijs();
                }
            }
        }
        return $arr;
    }

    public static function rondBestellingAf($winkelmand, $klant) {
        $postcode = PostcodeDAO::getByPostcodeWoonplaats($klant->getPostcode(), $klant->getWoonplaats());
        //check of leverplaats al in de database zit 
        $leverplaats = LeverPlaatsService::getByStraatHuisnummerPostcodeid($klant->getStraat(), $klant->getHuisnummer(), $postcode->getPostcodeId());
        BestellingDAO::insert($klant->getNaam(), $klant->getVoornaam(), $klant->getTelefoon(), $leverplaats->getLeverplaatsid(), $klant->getOpmerking(), $klant->getAccountid());
        $bestellingid = BestellingDAO::getLastInsertId();
        foreach ($winkelmand->getBestelregels() as $bestelregel) {
            BestelregelDAO::insert($bestellingid, $bestelregel['product']->getProductnaam());
        }
    }

    public static function verwijderBestelling($id, $bestellingen) {
        BestellingDAO::delete($id);
        foreach ($bestellingen as $key => $value) {
            if ($key == $id) {
                unset($bestellingen[$key]);
            }
        }
        return $bestellingen;
    }

}
