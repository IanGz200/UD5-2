<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Decimal\Decimal;
use PDO;

class UsuarioModel extends \Com\Daw2\Core\BaseDbModel
{
    private const SELECT_FROM = "SELECT us.*, ar.nombre_rol, ac.country_name
                                    FROM usuario us
                                    JOIN aux_rol ar ON us.id_rol = ar.id_rol
                                    LEFT JOIN aux_countries ac ON us.id_country = ac.id";
    public function getUsuarios(): array
    {
        $statement = $this->pdo->query(self::SELECT_FROM);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
