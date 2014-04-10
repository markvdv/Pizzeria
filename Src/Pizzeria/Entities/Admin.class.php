<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Mark.Vanderveken
 */
namespace Pizzeria\Entities;
class Admin {
    private static $idMap=array();
   private $adminid;
   private $naam;
   private $pw;
   private $salt;
   private function __construct($adminid,$naam,$pw,$salt) {
       $this->adminid=$adminid;
       $this->naam=$naam;
       $this->pw=$pw;
       $this->salt=$salt;
   }
   public static function create($adminid,$naam,$pw,$salt) {
       if(!isset(self::$idMap[$adminid])){
           self::$idMap[$adminid]=new Admin($adminid, $naam, $pw, $salt);
       }
       return self::$idMap[$adminid];
   }
   // <editor-fold defaultstate="collapsed" desc="gettersetter">
   public function getNaam() {
       return $this->naam;
   }

   public function setNaam($naam) {
       $this->naam = $naam;
   }

   public function getPw() {
       return $this->pw;
   }

   public function setPw($pw) {
       $this->pw = $pw;
   }

   public function getSalt() {
       return $this->salt;
   }

   public function setSalt($salt) {
       $this->salt = $salt;
   }

// </editor-fold>

}
