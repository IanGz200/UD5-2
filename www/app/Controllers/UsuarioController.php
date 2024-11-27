<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;
use http\Message;

class UsuarioController extends BaseController
{
    private IUsuarioModel $modelo;
    const ORDER_DEFECTO = 1;

    public function usuariosFiltro(): void
    {
        $data = [
            'titulo' => 'Listado usuarios',
            'breadcrumb' => ['Usuarios', 'Listado usuarios']
        ];

        if (isset($_SESSION['flash']['message'])) {
            $data['message'] = $_SESSION['flash']['message'];
            $data['message_type'] = $_SESSION['flash']['message_type'] ?? 'info';
            unset($_SESSION['flash']);
        }
        $auxRolModel = new AuxRolModel();
        $data['roles'] = $auxRolModel->getAll();

        $countriesModel = new AuxCountriesModel();
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
        if ($pageSize <= 0) {
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        if (UsuarioModel::getOffset($page, $pageSize) >= $numReg) {
            $page = 1;
        }

        return $page;
    }

    private function getMaxPage(int $numReg, int $pageSize = -1): int
    {
        if ($pageSize <= 0) {
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
            if (!is_null($usuario['salarioBruto']) && !is_null($usuario['retencionIRPF'])) {
                $salarioBruto = new Decimal($usuario['salarioBruto']);
                $retencionIRPF = new Decimal($usuario['retencionIRPF']);
                $neto = $salarioBruto - ($salarioBruto * $retencionIRPF / new Decimal('100', 2));
                $usuario['salarioNeto'] = $neto->toFixed(2, true, Decimal::ROUND_HALF_UP);
            } else {
                $usuario['salarioNeto'] = 0;
            }
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

    public function showNewUsuario(array $input = [], array $errors = []): void
    {
        $data = $this->getCommonData();

        $data += [
            'titulo' => 'Alta usuario',
            'breadcrumb' => ['Usuarios', 'Alta usuario']
        ];

        $data['input'] = $input;
        $data['errors'] = $errors;

        $this->view->showViews(
            array('templates/header.view.php', 'usuario.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function doNewUsuario(): void
    {
        $errors = $this->checkForm($_POST);
        if ($errors === []) {
            $insertData = $_POST;
            $insertData['activo'] = isset($insertData['activo']) ? 1 : 0;
            foreach ($insertData as $key => $value) {
                if (empty($value)) {
                    $insertData[$key] = null;
                }
            }
            $model = new UsuarioModel();
            if ($model->insertUsuario($insertData)) {
                header('Location: /usuarios-filtro');
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $errors['username'] = 'No se ha podido realizar el guardado';
                $this->showNewUsuario($input, $errors);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showNewUsuario($input, $errors);
        }
    }

    private function checkForm(array $datos, string $oldUsername = ''): array
    {
        $errors = [];
        if ($oldUsername === '' || $oldUsername != $datos['username']) {
            if (empty($datos['username'])) {
                $errors['username'] = 'El nombre de usuario es requerido';
            }
            if (!preg_match('/^\p{L}[\p{L}_\p{N}]{2,49}$/u', $datos['username'])) {
                $errors['username'] = 'El username debe empezar por una letra y estar formado por letras, _ y números';
            }
            $model = new UsuarioModel();
            if (!is_null($model->getByUsername($datos['username']))) {
                $errors['username'] = 'El nombre de usuario ya existe';
            }
        }
        $floats2 = [
            'salarioBruto' => ['nombre' => 'Salario Bruto', 'min' => 600],
            'retencionIRPF' => ['nombre' => 'Retención IRPF', 'min' => 0]
        ];
        foreach ($floats2 as $campo => $attr) {
            $nombre = $attr['nombre'];
            $min = $attr['min'];
            if (!empty($datos[$campo])) {
                if (filter_var($datos[$campo], FILTER_VALIDATE_FLOAT) === false) {
                    $errors[$campo] = "$nombre debe ser un número decimal en formato americano";
                } else {
                    if ($datos[$campo] < $min) {
                        $errors[$campo] = "El mínimo aceptado es de $min";
                    }
                    $salarioBrutoDecimal = new Decimal($datos[$campo]);
                    if ($salarioBrutoDecimal - $salarioBrutoDecimal->round(2) != 0) {
                        $errors[$campo] = "$nombre sólo puede tener dos decimales";
                    }
                }
            }
        }

        if (empty($datos['id_rol'])) {
            $errors['id_rol'] = 'Seleccione un rol';
        } else {
            if (filter_var($datos['id_rol'], FILTER_VALIDATE_INT) === false) {
                $errors['id_rol'] = 'Rol no válido';
            } else {
                $auxRolModel = new AuxRolModel();
                $rol = $auxRolModel->find((int)$datos['id_rol']);
                if (is_null($rol)) {
                    $errors['id_rol'] = 'Rol no válido';
                }
            }
        }

        if (empty($datos['id_country'])) {
            $errors['id_country'] = 'Seleccione un país';
        } else {
            if (filter_var($datos['id_country'], FILTER_VALIDATE_INT) === false) {
                $errors['id_country'] = 'País no válido';
            } else {
                $auxRolModel = new \Com\Daw2\Models\AuxCountriesModel();
                $rol = $auxRolModel->find((int)$datos['id_country']);
                if (is_null($rol)) {
                    $errors['id_country'] = 'País no válido';
                }
            }
        }
        return $errors;
    }

    public function showEditUsuario(string $username, array $input = [], array $errors = []): void
    {
        $model = new UsuarioModel();
        $usuario = $model->getByUsername($username);
        if (is_null($usuario)) {
            header('Location: /usuarios-filtro');
        }
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Edición de usuario',
            'breadcrumb' => ['Usuarios', 'Edición de usuario']
        ];

        $data['input'] = ($input === []) ? $usuario : $input;

        $data['errors'] = $errors;

        $this->view->showViews(
            array('templates/header.view.php', 'usuario.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    private function getCommonData(): array
    {
        $data = [];
        $modelRoles = new AuxRolModel();
        $data['roles'] = $modelRoles->getAll();

        $countriesModel = new AuxCountriesModel();
        $data['countries'] = $countriesModel->getAll();
        return $data;
    }

    public function doEditUsuario(string $username)
    {
        $model = new UsuarioModel();
        $usuario = $model->getByUsername($username);
        if (is_null($usuario)) {
            header('Location: /usuarios-filtro');
        }
        $errors = $this->checkForm($_POST, $username);
        if ($errors === []) {
            $insertData = $_POST;
            $insertData['activo'] = isset($insertData['activo']) ? 1 : 0;
            foreach ($insertData as $key => $value) {
                if (empty($value)) {
                    $insertData[$key] = null;
                }
            }
            $model = new UsuarioModel();
            if ($model->updateUsuario($insertData, $username)) {
                header('Location: /usuarios-filtro');
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $errors['username'] = 'No se ha podido realizar el guardado';
                $this->showEditUsuario($username, $input, $errors);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditUsuario($username, $input, $errors);
        }
    }

    public function deleteUsuario(string $username): void
    {
        $model = new UsuarioModel();
        if ($model->deleteUsuario($username)) {
            $mensaje = new Mensaje('Usuario eliminado correctamente', Mensaje::SUCCESS, 'Éxito');
        } else {
            $mensaje = new Mensaje('No se ha podido eliminar el usuario', Mensaje::ERROR, 'Error');
        }
        $this->addFlashMessage($mensaje);
        header('Location: /usuarios-filtro');
    }
}
