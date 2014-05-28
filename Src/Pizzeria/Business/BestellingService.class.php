<?php

namespace Pizzeria\Business;

use Pizzeria\Data\AccountDAO;
use Pizzeria\Data\BestellingDAO;
use Pizzeria\Data\BestelregelDAO;
use Pizzeria\Data\PostcodeDAO;
use Pizzeria\Data\ProductDAO;

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
        $producten = ProductDAO::getAll();
        $accounts = AccountDAO::getAll();
        $arr = array();
        foreach ($bestellingen as $bestelling) {
            $totaalprijs = 0;
            foreach ($accounts as $account) {

                if ($account->getTelefoon() == $bestelling->getTelefoon() && $account->getStraat() == $bestelling->getStraat() && $account->getHuisnummer() == $bestelling->getHuisnummer()) {
                    $arr[$bestelling->getBestellingid()]['klantnr'] = $account->getAccountid();
                   $arr[$bestelling->getBestellingid()]['korting']=self::berekenKorting($account->getAantalBestellingen());
                        
                } else {
                    $arr[$bestelling->getBestellingid()]['klantnr'] = $bestelling->getBestellingid();
                }
            }
            $arr[$bestelling->getBestellingid()]['klantgegevens'] = $bestelling;
            foreach ($bestelregels as $bestelregel) {
                if ($bestelling->getBestellingid() == $bestelregel->getBestellingid()) {
                    foreach ($producten as $product) {
                        if ($bestelregel->getProductid() == $product->getProductid()) {
                            $arr[$bestelling->getBestellingid()]['bestelregels'][] = $product;
                            $totaalprijs+=$product->getProductprijs();
                        }
                    }
                }
            }
            $arr[$bestelling->getBestellingid()]['prijs'] = $totaalprijs;
        }
        return $arr;
    }
    public static function rondBestellingAf($winkelmand,$klant) {
        $postcode= PostcodeDAO::getByPostcodeWoonplaats($klant->getPostcode(), $klant->getWoonplaats());
         //check of leverplaats al in de database zit 
            $leverplaats = LeverPlaatsService::getByStraatHuisnummerPostcodeid($klant->getStraat(), $klant->getHuisnummer(), $postcode->getPostcodeId());
            if (!$leverplaats) {
                $leverplaatsid = LeverplaatsService::maakLeverplaatsAan($klant->getStraat(), $klant->getHuisnummer(), $postcode->getPostcodeId());
            } else {
                $leverplaatsid = $leverplaats->getLeverplaatsid();
            }
        BestellingDAO::insert($klant->getNaam(), $klant->getVoornaam(), $klant->getTelefoon(), $leverplaatsid, $klant->getOpmerking(),$klant->getAccountid());
       
       $bestellingid = BestellingDAO::getLastInsertId();
        foreach ($winkelmand->getBestelregels() as $bestelregel) {
            var_dump($bestelregel);
            BestelregelDAO::insert($bestellingid, $bestelregel['product']->getProductnaam());
        }
    }
    
    public static function verwijderBestelling($id,$bestellingen) {
        BestellingDAO::delete($id);
        foreach ($bestellingen as $key =>$value){
            if ($key==$id) {
                unset($bestellingen[$key]);
            }
        }
        return $bestellingen;
    }
}
