<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class PreferenciasController extends \Com\Daw2\Core\BaseController
{
    public function showPreferencias()
    {
        $data = array(
            'titulo' => 'Preferencias de usuario',
            'breadcrumb' => ['Inicio', 'Preferencias'],
        );
        $this->view->showViews(
            array('templates/header.view.php', 'preferencias.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function doPreferencias()
    {
        if (isset($_POST['darkmode_button'])) {
            if (isset($_POST['dark_mode'])) {
                setcookie("dark_mode", '1', time() + (86400 * 365));
                $_COOKIE["dark_mode"] = '1';
            } else {
                setcookie("dark_mode", '0', time() + (86400 * 365));
                $_COOKIE["dark_mode"] = '0';
            }
        } elseif (isset($_POST['username_button'])) {
            if (isset($_POST['username']) && mb_strlen($_POST['username']) > 0 && mb_strlen($_POST['username']) <= 50) {
                $_SESSION["username"] = htmlspecialchars($_POST['username']);
            } else {
                $_SESSION["username"] = "Usuario";
            }
        }

        $data = array(
            'titulo' => 'Preferencias de usuario',
            'breadcrumb' => ['Inicio', 'Preferencias'],
        );
        $this->view->showViews(array('templates/header.view.php', 'preferencias.view.php', 'templates/footer.view.php'), $data);
    }
}
