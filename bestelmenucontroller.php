<?php
session_start();
// <editor-fold defaultstate="collapsed" desc="used classes">

use Doctrine\Common\ClassLoader;
require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("Pizzeria", "Src");
$classLoader->setFileExtension(".class.php");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("Src/Pizzeria/Presentation");
$twig = new Twig_Environment($loader, array('debug' => true));

use Pizzeria\Business\ApplicatieService;
use Pizzeria\Business\ProductService;
use Pizzeria\DTO\Winkelmand;
use Pizzeria\Exceptions\WinkelmandLeegException;

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="doctrine twig">



// <editor-fold defaultstate="collapsed" desc="setup bestelmenu">
if (!isset($_SESSION['winkelmand']) || !isset($_SESSION['producten'])||!isset($_SESSION['loggedin'])) {
    //$producten = ApplicatieService::geefPizzaLijst();
    $producten = ApplicatieService::geefPizzaLijst();
    $winkelmand = new Winkelmand;
    $_SESSION['producten'] = serialize($producten);
    $_SESSION['winkelmand'] = serialize($winkelmand);
    $_SESSION['loggedin']=false;
}
if (isset($_COOKIE['emailadres'])) {
    $emailadres = $_COOKIE['emailadres'];
} else {
    $emailadres = null;
}
$producten = unserialize($_SESSION['producten']); // </editor-fold>
$winkelmand = unserialize($_SESSION['winkelmand']);
//$klant= unserialize($_SESSION['klant']);
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //$bestelmenu->ingelogd = true;
} else {
    //$bestelmenu->ingelogd = false;
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
            $product = ProductService::zoekProductOpNaam($_GET['productnaam']);
            $winkelmand->voegProductToe($product);
            $_SESSION['winkelmand'] = serialize($winkelmand);
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="verwijderregel om regel van winkelmand te verwijderen">
        case 'verwijderregel':
            $winkelmand->verwijderProduct($_GET['productindex']);
            $_SESSION['winkelmand'] = serialize($winkelmand);
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="afronden en wegschrijven van bestelling na nazicht door klant">
        case 'rondbestellingaf':
            try {
                ApplicatieService::rondBestellingAf($bestelmenu->winkelmand, $bestelmenu->klantdata);
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("bestelling.twig", array('klantdata' => $bestelmenu->klantdata, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'korting' => $bestelmenu->klantdata->getKorting(), 'besteld' => 'afronden'));
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

            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                $_SESSION['winkelmand'] = serialize($winkelmand);
                $view = $twig->render("winkelmand.twig", array('klant' => serialize($_SESSION['klant']), 'winkelmand' => $winkelmand));
              //  $view = $twig->render("bestelling.twig", array('klantdata' => $_SESSION['klantdata'], 'winkelmand' => $winkelmand));
            } else if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                //redirect naar niet aangemeld

                $view = $twig->render('nietaangemeld.twig');
            }
            break; // </editor-fold>
    }
}
if (!isset($view)) {
    $view = $twig->render('bestelmenu.twig', array('emailadrescookie' => $emailadres, 'producten' => $producten, 'winkelmand' => $winkelmand,'loggedin'=>$_SESSION['loggedin']));
}
echo $view;
exit(0);
