<?php

// <editor-fold defaultstate="collapsed" desc="used classes">
use Pizzeria\Business\AdminService;
use Pizzeria\Business\ApplicatieService;
use Pizzeria\Business\UserService;
use Pizzeria\DTO\Klant;
use Pizzeria\Exceptions\EmailBestaatAlException;
use Pizzeria\Exceptions\GeenEmailOpgegevenException;
use Pizzeria\Exceptions\GeenLeverZoneException;
use Pizzeria\Exceptions\GeenNaamOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordConfirmOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordOpgegevenException;
use Pizzeria\Exceptions\IncorrectPasswordException;
use Pizzeria\Exceptions\PasswordsDontMatchException;
use Pizzeria\Exceptions\UserNietGevondenException;

// </editor-fold>

session_start();

// <editor-fold defaultstate="collapsed" desc="doctrine en twig">

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
// </editor-fold>



$error = false;

if (isset($_GET['action'])) {
    switch ($_GET['action']) {

        // <editor-fold defaultstate="collapsed" desc="Loginpart of controller">
        case 'login':
            try {
                $klant = UserService::login($_POST['email'], $_POST['password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['klant'] = serialize($klant);
                setcookie("emailadres", $_POST['email'], time() + 3600);
                header('location:bestelmenucontroller.php');
                exit(0);
            } catch (GeenEmailOpgegevenException $GEOe) {
                $error = "GeenEmailOpgegeven";
            } catch (UserNietGevondenException $UNGe) {
                $error = 'UserNietGevonden';
            } catch (GeenPasswordOpgegevenException $GPOe) {
                $error = 'GeenPasswordOpgegeven';
            } catch (IncorrectPasswordException $IPe) {
                $error = 'IncorrectPassword';
            }
            if (isset($error)) {
               $producten=Pizzeria\Business\ProductService::toonProducten();
                $view = $twig->render('bestelmenu.twig', array('error' => $error,'winkelmand'=>$_SESSION['winkelmand'],'producten'=>$producten));
            }
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="loguit">
        case 'loguit':
            $bestelmenu = ApplicatieService::geefPizzaLijst();
            $_SESSION['bestelmenu'] = serialize($bestelmenu);
            unset($_SESSION['loggedin']);
            unset($_SESSION['bestellingen']);
            unset($_SESSION['adminloggedin']);
            header('location: bestelmenucontroller.php');
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="geenaccount redirect naar gegevens opgave en redirect naar maakleverplaats aan">
        case 'geenaccount':
            $klant = new Klant($_POST['naam'], $_POST['voornaam'], $_POST['adres'], $_POST['huisnummer'], $_POST['telefoon'], $_POST['postcode'], $_POST['woonplaats'], $_POST['opmerking']);
            if (!isset($_POST['registratie'])) {
                $_POST['registratie'] = null;
            }

            $fouten = ApplicatieService::controleerKlantgegevens($_POST['naam'], $_POST['voornaam'], $_POST['adres'], $_POST['huisnummer'], $_POST['telefoon'], $_POST['postcode'], $_POST['woonplaats'], $_POST['registratie'], $_POST['email'], $_POST['password'], $_POST['passwordconfirm']);
            if (!empty($fouten)) {
                $view = $twig->render('geenaccount.twig', array('errors' => $fouten, 'klant' => $klant));
                echo $view;
                exit(0);
            }


            //checken voor email indien accountaanmaak

            $_SESSION['loggedin'] = true;
            $_SESSION['klant'] = serialize($klant);
            header('location:bestelmenucontroller.php?action=afrekenen');
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="welaccount redirect naar login">
        case 'welaccount':
            $view = $twig->render('bestelmenu.twig');
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="verander klantgegevens">
        case 'verandergegevens':
            $klant = unserialize($_SESSION['klant']);
            if (isset($_POST['submit'])) {
                $klant = UserService::veranderGevens($klant, $_POST['naam'], $_POST['voornaam'], $_POST['adres'], $_POST['huisnummer'], $_POST['telefoon'], $klant->getPostcode(), $_POST['email'], $_POST['opmerking']);
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
                header("location:bestelmenucontroller.php?action=afrekenen");
                exit(0);
            } else {
                $view = $twig->render('klantgegevensoverzicht.twig', array('klantdata' => $klant));
            }
            break; // </editor-fold>
        case 'adminlogin':
            if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
                $view = $twig->render('header.twig', array('ingelogd' => 'admin'));
                $view .= $twig->render("adminlogin.twig");
                $view .= $twig->render('footer.twig');
            }
            if (isset($_POST['naam']) && isset($_POST['password'])) {
                try {
                    AdminService::login($_POST['naam'], $_POST['password']);
                    $_SESSION['adminloggedin'] = true;
                    header('location:bestellingoverzichtcontroller.php?action=toonoverzicht');
                    exit(0);
                    break;
                } catch (GeenNaamOpgegevenException $GEOe) {
                    $error = "GeenNaamOpgegeven";
                } catch (UserNietGevondenException $UNGe) {
                    $error = 'UserNietGevonden';
                } catch (GeenPasswordOpgegevenException $GPOe) {
                    $error = 'GeenPasswordOpgegeven';
                } catch (IncorrectPasswordException $IPe) {
                    $error = 'IncorrectPassword';
                }
                if (isset($error)) {
                    $view = $twig->render("adminlogin.twig", array('error' => $error));
                }
            }
    }
}
if (!isset($view)) {
    $view = $twig->render("geenaccount.twig", array("error" => $error));
}
echo $view;
exit(0);
