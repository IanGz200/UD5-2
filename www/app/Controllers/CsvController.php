<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CsvModel;

class CsvController extends BaseController
{
    private const DATA_FOLDER = '../app/Data/';
    private const SEXOS = ['Total', 'Mujeres', 'Hombre'];

    public function showPoblacionPontevedra(): void
    {
        $data = [
            'titulo' => 'Población Pontevedra',
            'breadcrumb' => ['Csv', 'Población Pontevedra']
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra.csv');
        $data['registros'] = $model->loadData();
        if (count($data['registros']) > 1) {
            $minMax = $this->getMaxMinPob($data['registros']);
            $data = array_merge($data, $minMax);
            $data['showMinMax'] = true;
        }
        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    private function getMaxMinPob(array $registros): array
    {
        $min = $registros[1];
        $max = $registros[1];
        $min[3] = $this->cleanPoblacion($min[3]);
        $max[3] = $this->cleanPoblacion($max[3]);
        for ($i = 1; $i < count($registros); $i++) {
            $actual = $registros[$i];
            if (filter_var($actual[3], FILTER_VALIDATE_INT)) {
                $poblacionActual = $this->cleanPoblacion($actual[3]);
                if ($poblacionActual > $max[3]) {
                    $max = $actual;
                    $max[3] = $this->cleanPoblacion($max[3]);
                }
                if ($poblacionActual < $min[3]) {
                    $min = $actual;
                    $min[3] = $this->cleanPoblacion($min[3]);
                }
            }
        }
        $resultado = [];
        $resultado['min'] = $min;
        $resultado['max'] = $max;
        return $resultado;
    }

    private function cleanPoblacion(string $poblacion): int
    {
        return (int)str_replace('.', '', $poblacion);
    }

    public function showPoblacionGruposEdad(): void
    {
        $data = [
            'titulo' => 'Población Grupos Edad',
            'breadcrumb' => ['Csv', 'Población Grupos Edad']
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_grupos_edad.csv');
        $data['registros'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function showPoblacionPontevedra2020(): void
    {
        $data = [
            'titulo' => 'Población Pontevedra 2020',
            'breadcrumb' => ['Csv', 'Población Pontevedra 2020'],
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra_2020_totales.csv');
        $data['registros'] = $model->loadData();

        if (count($data['registros']) > 1) {
            $minMax = $this->getMaxMinPob($data['registros']);
            $data = array_merge($data, $minMax);
            $data['min'][1] = '';
            $data['min'][2] = '';
            $data['max'][1] = '';
            $data['max'][2] = '';
        }

        $data['showMinMax'] = false;

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function showAltaPoblacionPontevedra(): void
    {
        $data = [
            'titulo' => 'Insertar registro en población Pontevedra',
            'breadcrumb' => ['Csv', 'Población Pontevedra', 'Nuevo registro'],
            'sexos' => self::SEXOS
        ];
        $this->view->showViews(array('templates/header.view.php', 'new-pontevedra.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAltaPoblacionPontevedra(): void
    {
        $data = [];
        $errors = $this->checkErrorsAltaPontevedra($_POST);
        if (empty($errors)) {
        } else {
            $data = [
                'titulo' => 'Insertar registro en población Pontevedra',
                'breadcrumb' => ['Csv', 'Población Pontevedra', 'Nuevo registro'],
                'sexos' => self::SEXOS
            ];
            $data['errors'] = $errors;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->showViews(array('templates/header.view.php', 'new-pontevedra.view.php', 'templates/footer.view.php'), $data);
        }
    }

    private function checkErrorsAltaPontevedra(array $data): array
    {
        $errors = [];
        if (!preg_match('/^[1-9]([0-9]|[0-9]{4})\s\p{L}[\p{L}\s]*$/iu', $data['municipio'])) {
            $errors['municipio'] = 'El municipio debe estar formado por el código postal (2 o 5 números) y un nombre formado por letras y espacios';
        }

        if (!in_array($data['sexo'], self::SEXOS)) {
            $errors['sexo'] = 'Elija una opción válida';
        }

        $resto = (int)date('Y') - (int)$data['anho'];
        if (
            (!filter_var($data['anho'], FILTER_VALIDATE_INT) ||
            ($resto < 0) ||
            ($resto > 100))
        ) {
            $errors['anho'] = 'Escoja un año del listado';
        }

        if (!filter_var($data['poblacion'], FILTER_VALIDATE_INT)) {
            $errors['poblacion'] = 'La población debe ser un número entero';
        } else {
            if ($data['poblacion'] < 0) {
                $errors['poblacion'] = 'La población debe ser un número mayor o igual a cero';
            }
        }

        return $errors;
    }
}
