<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\EjerciciosController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/poblacion-pontevedra',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionPontevedra();
            },
            'get'
        );

        Route::add(
            '/poblacion-grupos-edad',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionGruposEdad();
            },
            'get'
        );

        Route::add(
            '/poblacion-pontevedra-2020',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionPontevedra2020();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
        );

        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}
