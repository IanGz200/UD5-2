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
            '/test',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showFormularioNombre();
            },
            'get'
        );

        Route::add(
            '/test',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doFormularioNombre();
            },
            'post'
        );

        Route::add(
            '/anagrama',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showAnagrama();
            },
            'get'
        );

        Route::add(
            '/anagrama',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doAnagrama();
            },
            'post'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showMismasLetras();
            },
            'get'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doMismasLetras();
            },
            'post'
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
