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

    public function getByUsername(string $username): array
    {
        $statement = $this->pdo->prepare(self::SELECT_FROM . " WHERE us.username LIKE :username");
        $statement->execute(['username' => "%$username%"]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByRol(int $idRol): array
    {
        $statement = $this->pdo->prepare(self::SELECT_FROM . " WHERE us.id_rol = :id_rol");
        $statement->execute(['id_rol' => $idRol]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySalar(?Decimal $minSalar, ?Decimal $maxSalar): array
    {
        $condiciones = [];
        $vars = [];
        if (!is_null($minSalar)) {
            $condiciones[] = "us.salarioBruto >= :minSalar";
            $vars['minSalar'] = $minSalar;
        }
        if (!is_null($maxSalar)) {
            $condiciones[] = "us.salarioBruto <= :maxSalar";
            $vars['maxSalar'] = $maxSalar;
        }
        if (!empty($condiciones)) {
            $sql = self::SELECT_FROM . " WHERE " . implode(" AND ", $condiciones);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($vars);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->getUsuarios();
        }
    }

    public function getByRetencion(?Decimal $minRetencion, ?Decimal $maxRetencion): array
    {
        $condiciones = [];
        $vars = [];
        if (!is_null($minRetencion)) {
            $condiciones[] = "us.retencionIRPF >= :minRetencion";
            $vars['minRetencion'] = $minRetencion;
        }
        if (!is_null($maxRetencion)) {
            $condiciones[] = "us.retencionIRPF <= :maxRetencion";
            $vars['maxRetencion'] = $maxRetencion;
        }
        if (!empty($condiciones)) {
            $sql = self::SELECT_FROM . " WHERE " . implode(" AND ", $condiciones);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($vars);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->getUsuarios();
        }
    }

    public function getByCountries(array $idCountries): array
    {
        $vars = [];
        $i = 1;
        foreach ($idCountries as $idCountry) {
            $vars[':id_country' . $i] = $idCountry;
        }
        array_keys()
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
