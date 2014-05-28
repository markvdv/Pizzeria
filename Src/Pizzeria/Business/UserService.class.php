<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserService
 *
 * @author Mark.Vanderveken
 */

namespace Pizzeria\Business;

use Pizzeria\Data\AccountDAO;
use Pizzeria\Data\LeverPlaatsDAO;
use Pizzeria\Data\PostcodeDAO;
use Pizzeria\DTO\Klant;
use Pizzeria\Exceptions\GeenEmailOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordOpgegevenException;
use Pizzeria\Exceptions\IncorrectPasswordException;
use Pizzeria\Exceptions\UserNietGevondenException;

class UserService {

    public static function login($email, $pw) {
        // <editor-fold defaultstate="collapsed" desc="check voor lege velden">
        if (empty($email)) {
            throw new GeenEmailOpgegevenException;
        }
        if (empty($pw)) {
            throw new GeenPasswordOpgegevenException;
        }// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="check of account bestaat en paswoord klopt">
        $account = AccountDAO::getByEmail($email);
        if (!$account) {
            throw new UserNietGevondenException;
        }
        if (hash('sha256', $pw . $account->getSalt()) != $account->getPw()) {
            throw new IncorrectPasswordException;
        }// </editor-fold>
        $leverplaats=LeverPlaatsDAO::getById($account->getLeverplaatsId());
        $postcode = PostcodeDAO::getById($leverplaats->getPostcode()->getPostcodeId());
        $klant = new Klant($account->getNaam(), $account->getVoornaam(),$account->getTelefoon(),  $leverplaats->getStraat(),$leverplaats->getHuisnummer(),$postcode->getPostcode(),$postcode->getWoonplaats(),null,$account->getEmail(),$account->getAccountId() );
        return $klant;
    }

    public static function controleerKlantgegevens($naam, $voornaam,$telefoon, $straat, $huisnummer, $postcode, $woonplaats, $cbregistratie, $email, $password, $passwordconfirm) {
        $foutenarray = array();
        //checken voor velden die getallen moeten zijn enzovoorts
        if ($naam == '') {
            //throw new GeenNaamOpgegevenException;
            $foutenarray[] = new \Exception("Geen naam opgegeven", 0);
        }
        if ($voornaam == '') {
            //throw new GeenVoornaamOpgegevenException;
            $foutenarray[] = new \Exception("Geen voornaam opgegeven", 1);
        }
        if ($woonplaats == '') {
            //throw new GeenWoonplaatsOpgegevenException;
            $foutenarray[] = new \Exception("Geen woonplaats opgegeven", 2);
        }
        if ($straat == '') {
            //throw new GeenStraatOpgegevenException;
            $foutenarray[] = new \Exception("Geen straat opgegeven", 3);
        }
        if ($huisnummer == '') {
            //throw new GeenHuisnummerOpgegevenException;
            $foutenarray[] = new \Exception("Geen huisnummer opgegeven", 4);
        }
        if ($postcode == '') {
            //throw new GeenPostcodeOpgegevenException;
            $foutenarray[] = new \Exception("Geen postcode opgegeven", 5);
        }
        if (!is_numeric($postcode)) {
            $foutenarray[] = new \Exception("Postcode is geen getal", 6);
        }

        if ($telefoon == '') {
            //throw new GeenTelefoonOpgegevenException;
            $foutenarray[] = new \Exception("Geen telefoonnummer opgegeven", 7);
        }// </editor-fold>
        $postcode = PostcodeDAO::getByPostcodeWoonplaats($postcode, $woonplaats);
        var_dump($postcode);
        if (!$postcode) {
            //  throw new GeenLeverZoneException;
            $foutenarray[] = new \Exception("Geen lever zone", 8);
        }
        if ($cbregistratie !== null) {
            if ($email == '') {
                //throw new GeenPostcodeOpgegevenException;
                $foutenarray[] = new \Exception("Geen email opgegeven", 9);
            }
            $emailcheck= AccountDAO::getByEmail($email);
            if ($emailcheck){
                 $foutenarray[] = new \Exception("Email is al geregistreerd", 10);
            }
            if ($password == '') {
                //throw new GeenTelefoonOpgegevenException;
                $foutenarray[] = new \Exception("Geen paswoord opgegeven", 11);
            }// </editor-fold>

            if ($passwordconfirm == '') {
                //throw new GeenTelefoonOpgegevenException;
                $foutenarray[] = new \Exception("Geen paswoord bevestiging opgegeven", 12);
            }// </editor-fold>
            if ($password !== $passwordconfirm) {
                $foutenarray[] = new \Exception("Paswoorden komen niet overeen", 13);
            }
        }
        if (!empty($foutenarray)) {
            return $foutenarray;
        }
    }

    public static function maakAccountAan($naam, $voornaam,$leverplaatsid, $email, $password) {
         $salt = bin2hex(openssl_random_pseudo_bytes(mt_rand(40, 50))); //random salt
        $password = hash('sha256', $password . $salt); // </editor-fold>
        AccountDAO::insert($naam, $voornaam, $leverplaatsid,$email, $password, $salt);
    }
    public static function veranderGegevens($klant, $nieuwegegevens) {
        $klant->setNaam($nieuwegegevens['naam']);
        $klant->setVoornaam($nieuwegegevens['voornaam']);
        $klant->setStraat($nieuwegegevens['adres']);
        $klant->setHuisnummer($nieuwegegevens['huisnummer']);
        $klant->setPostcode($nieuwegegevens['postcode']);
        $klant->setWoonplaats($nieuwegegevens['woonplaats']);
        $klant->setTelefoon($nieuwegegevens['telefoon']);
        $klant->setOpmerking($nieuwegegevens['opmerking']);
        return $klant;
    }

}
