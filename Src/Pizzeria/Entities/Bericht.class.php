<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bericht
 *
 * @author mark.vanderveken
 */
namespace Pizzeria\Entities;
class Bericht {
    private static $idMap;
    private $berichtid;
    private $auteur;
    private $tijdstip;
    private $text;
    private function __construct($berichtid,$auteur,$tijdstip,$text){
        $this->berichtid=$berichtid;
        $this->auteur=$auteur;
        $this->tijdstip=$tijdstip;
        $this->text=$text;
    }
    
    public static function create($berichtid,$auteur,$tijdstip,$text) {
        if(!isset(self::$idMap[$berichtid])){
            self::$idMap[$berichtid]=new Bericht($berichtid, $auteur, $tijdstip, $text);
        }
        return self::$idMap[$berichtid];
    }
    
    public function getBerichtid() {
        return $this->berichtid;
    }

    public function setBerichtid($berichtid) {
        $this->berichtid= $berichtid;
    }
    public function getAuteur() {
        return $this->auteur;
    }

    public function setAuteur($auteur) {
        $this->auteur= $auteur;
    }
    public function getTijdstip() {
        return $this->tijdstip;
    }

    public function setTijdstip($tijdstip) {
        $this->tijdstip= $tijdstip;
    }
    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text= $text;
    }

    //put your code here
}
