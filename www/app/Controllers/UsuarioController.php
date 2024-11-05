<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;

class UsuarioController extends BaseController
{
    public function getAllUsuarios(): void
    {
        $data = [
            'titulo' => 'Mostrar todos los usuarios',
            'breadcrumb' => ['Usuarios', 'Mostrar todos']
        ];
        $model = new UsuarioModel();
        $usuarios = $model->getUsuarios();

        $data['usuarios'] = $this->calcularNeto($usuarios);
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    private function calcularNeto(array $usuarios): array
    {
        foreach ($usuarios as &$usuario) {
            $salarioBruto = new Decimal($usuario['salarioBruto']);
            $retencionIRPF = new Decimal($usuario['retencionIRPF'], 2);
            $neto = $salarioBruto - ($salarioBruto * $retencionIRPF / new Decimal('100', 2));
            $usuario['salarioNeto'] = $neto->toFixed(2, true, Decimal::ROUND_HALF_UP);
        }
        return $usuarios;
    }

    public function getAllUsuariosOrderBySalar(): void
    {
        $data = [
            'titulo' => 'Mostrar todos los usuarios',
            'breadcrumb' => ['Usuarios', 'Mostrar ordenados por salario']
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosOrderBySalarioBruto());
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function getUsuariosStandard(): void
    {
        $data = [
            'titulo' => 'Usuarios estándar',
            'breadcrumb' => ['Usuarios', 'Usuario estándar']
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosStandard());
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function getUsuariosCarlos(): void
    {
        $data = [
            'titulo' => 'Usuarios estándar',
            'breadcrumb' => ['Usuarios', 'Usuario Carlos']
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosCarlos());
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'),
            $data
        );
    }
}
