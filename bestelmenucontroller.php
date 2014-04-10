<?php

// <editor-fold defaultstate="collapsed" desc="doctrine twig">
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

// <editor-fold defaultstate="collapsed" desc="used classes">

use Pizzeria\Business\ApplicatieService;
use Pizzeria\Business\BestellingService;
use Pizzeria\Exceptions\WinkelmandLeegException; // </editor-fold>

// <editor-fold defaultstate="collapsed" desc="setup bestelmenu">
session_start();
if (!isset($_SESSION['bestelmenu'])) {
    $bestelmenu = ApplicatieService::prepBestelmenu();
    $_SESSION['bestelmenu'] = serialize($bestelmenu);
}
if (isset($_COOKIE['emailadres'])) {
    $emailadres = $_COOKIE['emailadres'];
} else {
    $emailadres = null;
}
$bestelmenu = unserialize($_SESSION['bestelmenu']); // </editor-fold>

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $bestelmenu->ingelogd = true;
} else {
    $bestelmenu->ingelogd = false;
}
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        // <editor-fold defaultstate="collapsed" desc="oproepen van bestelmenu om bestelling te veranderen">
        case 'veranderbestelling':
            $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
            $view .= $twig->render('bestelmenu.twig', array('emailadrescookie' => $emailadres, 'klantdata' => $bestelmenu->klantdata, 'ingelogd' => $bestelmenu->ingelogd, 'producten' => $bestelmenu->producten, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'update' => true));
            $view .= $twig->render('winkelmand.twig', array('klantdata' => $bestelmenu->klantdata, 'producten' => $bestelmenu->producten, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs));
            $view .= $twig->render('footer.twig');
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="voegtoe om regels bij winkelmand te voegen">
        case 'voegtoe':
            $bestelmenu = ApplicatieService::voegToeAanWinkelmand($_GET['id'], $bestelmenu);
            $_SESSION['bestelmenu'] = serialize($bestelmenu);
            header('location:bestelmenucontroller.php');
            exit(0);
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="verwijderregel om regel van winkelmand te verwijderen">
        case 'verwijderregel':
            $bestelmenu->winkelmand = ApplicatieService::verwijderRegelVanWinkelmand($_GET['id'], $bestelmenu->winkelmand);
            $_SESSION['bestelmenu'] = serialize($bestelmenu);
            header('location:bestelmenucontroller.php');
            exit(0);
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="afronden en wegschrijven van bestelling na nazicht door klant">
        case 'rondbestellingaf':
            try {
                ApplicatieService::rondBestellingAf($bestelmenu->winkelmand, $bestelmenu->klantdata);
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("bestelling.twig", array('klantdata' => $bestelmenu->klantdata, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'korting' => $bestelmenu->klantdata->getKorting(),'besteld'=>'afronden'));
                $view .= $twig->render('footer.twig');
            } catch (WinkelmandLeegException $WLe) {
                $error = 'WinkelmandIsLeeg';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render('bestelmenu.twig', array('producten' => $bestelmenu->producten));
                $view .= $twig->render('winkelmand.twig', array('klantdata' => $bestelmenu->klantdata, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'error' => $error));
                $view .= $twig->render('footer.twig');
            }
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="doorverwijzing naar afrekening">
        case 'afrekenen':

            if ($bestelmenu->klantdata->getAantalbestellingen() !== null) {
                $korting = BestellingService::berekenKorting($bestelmenu->klantdata->getAantalBestellingen());
            } else {
                $korting = 0;
            }
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                $bestelmenu->klantdata->setKorting($korting);
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("bestelling.twig", array('klantdata' => $bestelmenu->klantdata, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'korting' => $bestelmenu->klantdata->getKorting(),'besteld'=>'afrekenen'));
                $view .= $twig->render('footer.twig');
            } else if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                //redirect naar niet aangemeld
                $view = $twig->render('header.twig');
                $view .= $twig->render('nietaangemeld.twig');
                $view .= $twig->render('footer.twig');
            }
            break; // </editor-fold>
    }
}else{
    $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd,'emailadrescookie'=>$emailadres));
    $view .= $twig->render('bestelmenu.twig', array('emailadrescookie' => $emailadres, 'klantdata' => $bestelmenu->klantdata, 'producten' => $bestelmenu->producten, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'korting' => $bestelmenu->klantdata->getKorting()));
    $view .= $twig->render('winkelmand.twig', array('klantdata' => $bestelmenu->klantdata, 'producten' => $bestelmenu->producten, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs));
    $view .= $twig->render('footer.twig');
}
echo $view;
exit(0);
