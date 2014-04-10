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

$bestelmenu = unserialize($_SESSION['bestelmenu']); // </editor-fold>
if (!isset($_SESSION['bestellingen'])) {
    $bestellingen = BestellingService::prepBestellingOverzicht();
    $_SESSION['bestellingen'] = serialize($bestellingen);
}
$bestellingen = unserialize($_SESSION['bestellingen']);
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
            $view = $twig->render('header.twig', array('ingelogd' => true));
            $view .= $twig->render("bestellingoverzicht.twig", array('bestellingen' => $bestellingen));
            $view .= $twig->render('footer.twig');
            break;
    }
}
echo $view;
