<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function getAllUsuarios(): void
    {
        $data = [
            'titulo' => 'Mostrar todos los usuarios',
            'breadcrumb' => ['Usuarios', 'Mostrar todos']
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $model->getUsuarios();
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'),
            $data
        );
    }

}