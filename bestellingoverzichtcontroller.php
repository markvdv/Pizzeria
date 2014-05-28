<?php

// <editor-fold defaultstate="collapsed" desc="doctrine twig">
session_start();

use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("Pizzeria", "Src");
$classLoader->setFileExtension(".class.php");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("Src/Pizzeria/Presentation");
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug);

use Pizzeria\Business\BestellingService;

 // </editor-fold>
    $bestellingen = BestellingService::prepBestellingOverzicht();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete':
            $bestellingen = BestellingService::verwijderBestelling($_GET['id'], $bestellingen);
            $_SESSION['bestellingen'] = serialize($bestellingen);
            header('location:bestellingoverzichtcontroller.php');
            break;
        case 'toonoverzicht':
            if (!isset($_SESSION['adminloggedin'])||$_SESSION['adminloggedin']!=true) {
                header('location:usercontroller.php?action=adminlogin' );
                exit(0);
            }
          
            break;
    }
}
  $view = $twig->render("bestellingoverzicht.twig", array('bestellingen' => $bestellingen));
echo $view;
