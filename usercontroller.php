<?php

use Pizzeria\Business\AdminService;
use Pizzeria\Business\ApplicatieService;
use Pizzeria\Business\UserService;
use Pizzeria\DTO\Klant;
use Pizzeria\Exceptions\EmailBestaatAlException;
use Pizzeria\Exceptions\GeenEmailOpgegevenException;
use Pizzeria\Exceptions\GeenHuisnummerOpgegevenException;
use Pizzeria\Exceptions\GeenLeverZoneException;
use Pizzeria\Exceptions\GeenNaamOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordConfirmOpgegevenException;
use Pizzeria\Exceptions\GeenPasswordOpgegevenException;
use Pizzeria\Exceptions\GeenPostcodeOpgegevenException;
use Pizzeria\Exceptions\GeenStraatOpgegevenException;
use Pizzeria\Exceptions\GeenTelefoonOpgegevenException;
use Pizzeria\Exceptions\GeenVoornaamOpgegevenException;
use Pizzeria\Exceptions\GeenWoonplaatsOpgegevenException;
use Pizzeria\Exceptions\IncorrectPasswordException;
use Pizzeria\Exceptions\PasswordsDontMatchException;
use Pizzeria\Exceptions\UserNietGevondenException;

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
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="used classes">
// </editor-fold>


$error = false;
$klant = new Klant();
$_SESSION['klant'] = serialize($klant);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        // <editor-fold defaultstate="collapsed" desc="Loginpart of controller">
        case 'login':
            try {
                $klant = UserService::login($_POST['email'], $_POST['password']);
                $_SESSION['loggedin'] = true;
                $bestelmenu->klantdata = $klant;
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
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
                $view = $twig->render('header.twig', array('error' => $error));
                $view .= $twig->render('bestelmenu.twig', array('klantdata' => $bestelmenu->klantdata, 'producten' => $bestelmenu->producten));
                $view .= $twig->render('winkelmand.twig', array('klantdata' => $bestelmenu->klantdata, 'producten' => $bestelmenu->producten, 'winkelmand' => $bestelmenu->winkelmand, 'totaalprijs' => $bestelmenu->winkelmand->totaalprijs, 'korting' => $bestelmenu->klantdata->getKorting()));
                $view .= $twig->render('footer.twig');
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
        // <editor-fold defaultstate="collapsed" desc="nieuwe account aanmaak">
        case 'nieuweaccount':
            try {
                $bestelmenu = unserialize($_SESSION['bestelmenu']);
                $klantdata = array_merge($_SESSION['post'], $_POST);
                $klant = UserService::maakAccountAan($klantdata);
                $bestelmenu->klantdata = $klant;
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
                $_SESSION['loggedin'] = true;
                header('location:bestelmenucontroller.php?action=afrekenen');
                exit(0);
            } catch (GeenEmailOpgegevenException $GEOe) {
                $error = 'GeenEmailOpgegeven';
                //$view=$twig->render("emailregistratie.twig", array('error', $error));
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("emailregistratie.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            } catch (PasswordsDontMatchException $PDMe) {
                $error = 'PasswordsDontMatch';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("emailregistratie.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            } catch (EmailBestaatAlException $EBAe) {
                $error = 'EmailBestaatAl';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("emailregistratie.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            } catch (GeenPasswordOpgegevenException $GPOe) {
                $error = 'GeenPasswordOpgegeven';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("emailregistratie.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            } catch (GeenPasswordConfirmOpgegevenException $GPCOe) {
                $error = 'GeenPasswordConfirmOpgegeven';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("emailregistratie.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            } catch (GeenLeverZoneException $GPCOe) {
                $error = 'GeenPasswordConfirmOpgegeven';
                $view = $twig->render('header.twig', array('ingelogd' => $bestelmenu->ingelogd));
                $view .= $twig->render("geenaccount.twig", array('error' => $error));
                $view .= $twig->render('footer.twig');
            }
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="geenaccount redirect naar gegevens opgave en redirect naar maakaccountaan">
        case 'geenaccount':
            
            /*if (count($_POST) == 0) {
                $view = $twig->render('geenaccount.twig');
            } else if (count($_POST) > 0) {
                if (isset($_POST['registratie'])) {
                    $_SESSION['post'] = $_POST;
                    $view = $twig->render('emailregistratie.twig');
                } else {
                    try {

                        //veldvalidatie ook met javascript?
                        $klant = UserService::controleerKlantgegevens($_POST['naam'], $_POST['voornaam'], $_POST['adres'], $_POST['huisnummer'], $_POST['telefoon'], $_POST['postcode'], $_POST['woonplaats'], $_POST['opmerking']);
                        $bestelmenu->klantdata = $klant;
                        $_SESSION['bestelmenu'] = serialize($bestelmenu);
                        $_SESSION['loggedin'] = true;
                        header('location:bestelmenucontroller.php?action=afrekenen');
                    } catch (GeenVoornaamOpgegevenException $GVOe) {
                        $error = 'GeenVoornaamOpgegeven';
                    } catch (GeenNaamOpgegevenException $GNOe) {
                        $error = 'GeenNaamOpgegeven';
                    } catch (GeenStraatOpgegevenException $GSOe) {
                        $error = 'GeenStraatOpgegeven';
                    } catch (GeenHuisnummerOpgegevenException $GHOee) {
                        $error = 'GeenHuisnummerOpgegeven';
                    } catch (GeenTelefoonOpgegevenException $GTOe) {
                        $error = 'GeenTelefoonOpgegeven';
                    } catch (GeenLeverZoneException $GLZe) {
                        $error = 'GeenLeverZone';
                    } catch (GeenPostcodeOpgegevenException $GPOe) {
                        $error = 'GeenPostcodeOpgegeven';
                    } catch (GeenWoonplaatsOpgegevenException $GWOe) {
                        $error = 'GeenWoonplaatsOpgegeven';
                    }
                }
            }*/
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="welaccount redirect naar login">
        case 'welaccount':
            $view = $twig->render('header.twig', array( 'emailadrescookie' => $emailadres));
            break; // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="verander klantgegevens">
        case 'verandergegevens':
            $klant = $bestelmenu->klantdata;
            if (isset($_POST['submit'])) {
                $klant = UserService::veranderGevens($klant, $_POST['naam'], $_POST['voornaam'], $_POST['adres'], $_POST['huisnummer'], $_POST['telefoon'], $klant->getPostcode(), $_POST['email'], $_POST['opmerking']);
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
                header("location:bestelmenucontroller.php?action=afrekenen");
                exit(0);
            } else {
                $view = $twig->render('header.twig', array('ingelogd' => true));
                $view .= $twig->render('klantgegevensoverzicht.twig', array('klantdata' => $klant));
                $view .= $twig->render('footer.twig');
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
                    $view = $twig->render('header.twig', array('ingelogd' => true));
                    $view .= $twig->render("adminlogin.twig", array('error' => $error));
                    $view .= $twig->render('footer.twig');
                }
            }
    }
}
$view=$twig->render("geenaccount.twig",array("error"=>$error));
echo $view;
exit(0);
