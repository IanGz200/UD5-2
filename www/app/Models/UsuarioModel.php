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

    public function getUsuariosOrderBySalarioBruto(): array
    {
        $statement = $this->pdo->query(self::SELECT_FROM . " ORDER BY salarioBruto");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuariosStandard(): array
    {
        $statement = $this->pdo->query(self::SELECT_FROM . " WHERE us.id_rol = 5");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuariosCarlos(): array
    {
        $statement = $this->pdo->query(self::SELECT_FROM . " WHERE us.username LIKE 'Carlos%'");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
