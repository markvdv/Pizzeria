<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BerichtService
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Business;

use Pizzeria\Data\BerichtDAO;

class BerichtService {

    public static function haalBerichtenOp() {
        $berichten = BerichtDAO::getAll();
        return $berichten;
    }

    public static function voegBerichtToe($auteur, $text) {
        BerichtDAO::insert($auteur, $text);
    }

}
