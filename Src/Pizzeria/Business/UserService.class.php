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
use Pizzeria\Data\PostcodeDAO;
use Pizzeria\DTO\Klant;
use Pizzeria\Exceptions\GeenEmailOpgegevenException;
use Pizzeria\Exceptions\UserNietGevondenException;
use Pizzeria\Exceptions\GeenLeverZoneException;
use Pizzeria\Exceptions\PasswordsDontMatchException;
use Pizzeria\Exceptions\EmailBestaatAlException;
use Pizzeria\Exceptions\IncorrectPasswordException;
use Pizzeria\Exceptions\GeenPasswordOpgegevenException;

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
        } else if (hash('sha256', $pw . $account->getSalt()) != $account->getPw()) {
            throw new IncorrectPasswordException;
        }// </editor-fold>
        $postcode = PostcodeDAO::getById($account->getPostcode()->getPostcodeid());
        $klant = self::prepKlantData($account->getNaam(), $account->getVoornaam(), $account->getStraat(), $account->getHuisnummer(), $account->getTelefoon(), $postcode, $account->getOpmerking(), $account->getEmail(), $account->getAantalBestellingen());
        return $klant;
    }

    public static function controleerKlantgegevens($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $woonplaats) {
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
        if (!$postcode) {
            //  throw new GeenLeverZoneException;
            $foutenarray[] = new \Exception("Geen lever zone", 8);
        }


        if (!empty($foutenarray)) {
            return $foutenarray;
        }
    }

    public static function prepKlantData($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $opmerking, $email = null, $aantalbestellingen = null) {
        $klant = new Klant($naam, $voornaam, $straat, $huisnummer, $telefoon, $postcode, $opmerking, $email, $aantalbestellingen);
        return $klant;
    }

    public static function maakAccountAan($klantdata) {
        // <editor-fold defaultstate="collapsed" desc="check voor lege velden en of paswoorden overeen komen">
        if ($klantdata['email'] == "") {
            throw new GeenEmailOpgegevenException;
        }
        if ($klantdata['password'] == "") {
            throw new GeenPasswordOpgegevenException;
        }
        if ($klantdata['passwordconfirm'] == "") {
            throw new GeenPasswordConfirmOpgegevenException;
        }
        if ($klantdata['password'] != $klantdata['passwordconfirm']) {
            throw new PasswordsDontMatchException;
        }// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="check of email al is geregistreerd">
        $account = AccountDAO::getByEmail($klantdata['email']);
        if ($account) {
            throw new EmailBestaatAlException;
        }// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="salt en paswoord hash">
        $salt = bin2hex(openssl_random_pseudo_bytes(mt_rand(40, 50))); //random salt
        $pw = hash('sha256', $klantdata['password'] . $salt); // </editor-fold>
        $postcode = PostcodeDAO::getByPostcodeWoonplaats($klantdata['postcode'], $klantdata['woonplaats']);
        if (!$postcode) {
            throw new GeenLeverZoneException;
        }
        $insert = AccountDAO::insert($klantdata['naam'], $klantdata['voornaam'], $klantdata['adres'], $klantdata['huisnummer'], $klantdata['telefoon'], $postcode->getPostcodeid(), $klantdata['email'], $pw, $salt, $klantdata['opmerking'], 0);
        $insertid = AccountDAO::getLastInsertId();
        $account = AccountDAO::getById($insertid);
        return $account;
    }

    public static function veranderGevens($klant, $naam = null, $voornaam = null, $straat = null, $huisnummer = null, $telefoon = null, $postcode = null, $email = null, $opmerking = null) {
        $account = AccountDAO::getByEmail($klant->getEmail());
        // <editor-fold defaultstate="collapsed" desc="updaten van klantobject voor klantgegevens">
        // <editor-fold defaultstate="collapsed" desc="naam=null dan moete alleen aantalbestellingen veranderd worden">
        if ($naam != null) {
            $klant->setNaam($naam);
            $klant->setVoornaam($voornaam);
            $klant->setStraat($straat);
            $klant->setHuisnummer($huisnummer);
            $klant->setPostcode($postcode);
            $klant->setTelefoon($telefoon);
            $klant->setEmail($email);
            $klant->setOpmerking($opmerking); // </editor-fold>
        }// </editor-fold>

        if ($account) {
            $values = array();
            $params = array();
            $methods = get_class_methods($account);
            foreach ($methods as $method) {
                if (preg_match('/get/', $method) && $method != "getKorting") {
                    if (is_object($account->$method())) {
                        $values[] = $account->$method()->getPostcodeid();
                        $params[] = 'postcodeid';
                    } else {
                        $values[] = $account->$method();
                        $params[] = str_replace('get', '', $method);
                    }
                }
            }
            $first = array_shift($values);
            array_push($values, $first);
            $first = array_shift($params);
            array_push($params, $first);
            $values = array_combine($params, $values);
            AccountDAO::update($values);
            //AccountDAO::update($klant, $account->getAccountid());
        }
        return $klant;
    }

}
