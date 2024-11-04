<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function getAllUsuarios(): void
    {
        $model = new UsuarioModel();
        var_dump($model->getUsuarios());
    }

}