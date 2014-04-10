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
$twig->addExtension(new Twig_Extension_Debug); // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="used classes">

use Pizzeria\Business\BerichtService; // </editor-fold>

session_start();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'tooninfo':
            $gastenboek = BerichtService::haalBerichtenOp();
            if (!isset($_SESSION['loggedin'])) {
                $view = $twig->render('header.twig', array('ingelogd' => false));
            } else {
                $view = $twig->render('header.twig', array('ingelogd' => true));
            }
            $view .= $twig->render('algemeneinfo.twig', array('gastenboek' => $gastenboek));
            $view .= $twig->render('footer.twig');
            break;
        case 'voegberichttoe':
            BerichtService::voegBerichtToe($_POST['auteur'], $_POST['bericht']);
            header('location:berichtcontroller.php?action=tooninfo');
            exit(0);
    }
}
echo $view;
exit(0);
