<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CsvModel;

class CsvController extends BaseController
{
    private const DATA_FOLDER = '../app/Data/';

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
}
