<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CsvModel;

class CsvController extends BaseController
{
    private const DATA_FOLDER = '../app/Data/';

    public function showPoblacionPontevedra()
    {
        $data = [
            'titulo' => 'Población Pontevedra',
            'breadcrumb' => ['Csv', 'Población Pontevedra'],
            'seccion' => '/poblacion-pontevedra'
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra.csv');
        $data['registros'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function showPoblacionGruposEdad()
    {
        $data = [
            'titulo' => 'Población Grupos Edad',
            'breadcrumb' => ['Csv', 'Población Grupos Edad'],
            'seccion' => '/poblacion-grupos-edad'
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_grupos_edad.csv');
        $data['registros'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }




}