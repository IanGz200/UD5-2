<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxCountries extends BaseDbModel
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM `aux_countries` ORDER BY `country_name` ASC");
        return $stmt->fetchAll();
    }

}