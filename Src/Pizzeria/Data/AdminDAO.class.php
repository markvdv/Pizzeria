<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminDAO
 *
 * @author Mark.Vanderveken
 */
namespace Pizzeria\Data;
use Pizzeria\Entities\Admin;
class AdminDAO extends DAO{
    public static function getByName($name) {
        $sql= "SELECT * FROM admin where naam=?";
        $args=  func_get_args();
       parent::execPreppedStmt($sql,$args);
        $result=parent::$stmt->fetch();
        if($result){
            $admin=Admin::create($result['adminid'],$result['naam'],$result['pw'],$result['salt']);   
            return $admin;
        }
        else{
            return false;
        }
}
}