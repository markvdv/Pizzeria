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
$producten = ApplicatieService::geefPizzaLijst();
//check voor winkelmand
if (!isset($_SESSION['winkelmand'])) {
    $winkelmand = new Winkelmand;
    $_SESSION['winkelmand'] = serialize($winkelmand);
}
//check voorloggedin of niet
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin']=false;
}
//check voor email cookie 
if (isset($_COOKIE['emailadres'])) {
    $emailadres = $_COOKIE['emailadres'];
} else {
    $emailadres = null;
}
//check voor klantdata
if(isset($_SESSION['klant'])){
   $klant=unserialize( $_SESSION['klant']);
}
else{$klant=null;} 

$winkelmand = unserialize($_SESSION['winkelmand']);


if ($_SESSION['loggedin'] === true) {
    //$bestelmenu->ingelogd = true;
} else {
    //$bestelmenu->ingelogd = false;
}


if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        // <editor-fold defaultstate="collapsed" desc="voegtoe om regels bij winkelmand te voegen">
        case 'voegtoe':
            $product = ProductService::zoekProductOpNaam($_GET['productnaam']);
            $winkelmand->voegProductToe($product);
            $_SESSION['winkelmand'] = serialize($winkelmand);
            break; 
            // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="verwijderregel om regel van winkelmand te verwijderen">
        case 'verwijderregel':
            $winkelmand->verwijderProduct($_GET['productindex']);
            $_SESSION['winkelmand'] = serialize($winkelmand);
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="doorverwijzing naar afrekening">
        case 'afrekenen':
            if ($_SESSION['loggedin'] ==true) {
                $_SESSION['winkelmand'] = serialize($winkelmand);
                $klant=unserialize($_SESSION['klant']);
                $view = $twig->render("winkelmand.twig", array('klant' =>$klant, 'winkelmand' => $winkelmand,'loggedin'=>$_SESSION['loggedin']));
            } else {
                //redirect naar niet aangemeld
                $view = $twig->render('geenklantgegevens.twig');
            }
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="afronden en wegschrijven van bestelling na nazicht door klant">
        case 'rondbestellingaf':
            try {
                ApplicatieService::rondBestellingAf($winkelmand, $klant);
                $view = $twig->render("winkelmand.twig", array('klant' => $klant, 'winkelmand' => $winkelmand,'loggedin'=>$_SESSION['loggedin']));
            } catch (WinkelmandLeegException $WLe) {
                $error = 'WinkelmandIsLeeg';
            }
            break; // </editor-fold>
    }
}
if (!isset($view)) {
    $view = $twig->render('bestelmenu.twig', array('emailadrescookie' => $emailadres, 'producten' => $producten, 'loggedin'=>$_SESSION['loggedin'],'klant' =>$klant, 'winkelmand' => $winkelmand));
}
echo $view;
exit(0);
