<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminService
 *
 * @author Mark.Vanderveken
 */
namespace Pizzeria\Business;
use Pizzeria\Data\AdminDAO;
use Pizzeria\Exceptions\UserNietGevondenException;
use Pizzeria\Exceptions\IncorrectPasswordException;
use Pizzeria\Exceptions\GeenNaamOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordOpgegevenException;

class AdminService {
    public static function login($naam,$pw) {

        if($naam==''){
            throw new GeenNaamOpgegevenException;
        }
        if ($pw=='') {
            throw new GeenPasswordOpgegevenException;
        }
        $admin=AdminDAO::getByName($naam);
        if (!$admin) {
            throw new UserNietGevondenException;
        } 
        if ($admin->getPw()!=hash('sha256',$pw.$admin->getSalt())) {
            throw new IncorrectPasswordException;
        }
        return $admin;
    }
}
