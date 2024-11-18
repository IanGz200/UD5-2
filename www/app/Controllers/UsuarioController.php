<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountries;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;

class UsuarioController extends BaseController
{
    const ORDER_DEFECTO = 1;

    public function usuariosFiltro(): void
    {
        $data = [
            'titulo' => 'Listado usuarios',
            'breadcrumb' => ['Usuarios', 'Listado usuarios']
        ];
        $auxRolModel = new AuxRolModel();
        $data['roles'] = $auxRolModel->getAll();

        $countriesModel = new AuxCountries();
        $data['countries'] = $countriesModel->getAll();

        $model = new UsuarioModel();
        $filtros = [];
        if (!empty($_GET['username'])) {
            $filtros['username'] = '%' . $_GET['username'] . '%';
        }
        if (!empty($_GET['id_rol'])) {
            $filtros['id_rol'] = ((int)$_GET['id_rol']);
        }
        if ((!empty($_GET['min_salar']) && filter_var($_GET['min_salar'], FILTER_VALIDATE_FLOAT))) {
            $filtros['min_salar'] = new Decimal($_GET['min_salar']);
        }
        if (!empty($_GET['max_salar']) && filter_var($_GET['max_salar'], FILTER_VALIDATE_FLOAT)) {
            $filtros['max_salar'] = new Decimal($_GET['max_salar']);
        }
        if ((!empty($_GET['min_retencion']) && filter_var($_GET['min_retencion'], FILTER_VALIDATE_FLOAT))) {
            $filtros['min_retencion'] = new Decimal($_GET['min_retencion']);
        }
        if (!empty($_GET['max_retencion']) && filter_var($_GET['max_retencion'], FILTER_VALIDATE_FLOAT)) {
            $filtros['max_retencion'] = new Decimal($_GET['max_retencion']);
        }
        if (!empty($_GET['id_country'])) {
            $filtros['id_country'] = $_GET['id_country'];
        }

        $order = $this->getOrderColumn();
        $data['order'] = $order;

        $_copiaGET = $_GET;
        unset($_copiaGET['page']);
        $data['queryStringNoPage'] = http_build_query($_copiaGET);
        if (!empty($data['queryStringNoPage'])) {
            $data['queryStringNoPage'] .= '&';
        }

        unset($_copiaGET['order']);

        $data['queryString'] = http_build_query($_copiaGET);
        if (!empty($data['queryString'])) {
            $data['queryString'] .= '&';
        }

        $registros = $model->countUsuarioFiltros($filtros);
        $page = isset($_GET['page']) && filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?
            $this->getPage((int)$_GET['page'], $registros) :
            1;

        $data['page'] = $page;

        $data['maxPage'] = $this->getMaxPage($registros);

        $usuarios = $model->getUsuarioFiltros($filtros, $order, $page);


        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data['usuarios'] = $this->calcularNeto($usuarios);

        $this->view->showViews(
            array('templates/header.view.php', 'usuarios-filtro.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    private function getPage(int $page, int $numReg, int $pageSize = -1): int
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($pageSize <= 0){
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        if (UsuarioModel::getOffset($page, $pageSize) >= $numReg) {
            $page = 1;
        }

        return $page;
    }

    private function getMaxPage(int $numReg, int $pageSize = -1): int{
        if ($pageSize <= 0){
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        return (int)ceil($numReg / $pageSize);
    }

    private function getOrderColumn(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(UsuarioModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::ORDER_DEFECTO;
    }

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
