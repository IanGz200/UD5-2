<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Decimal\Decimal;
use PDO;

class UsuarioModel extends \Com\Daw2\Core\BaseDbModel
{
    public const ORDER_COLUMNS = ['username', 'salarioBruto', 'retencionIRPF', 'nombre_rol', 'country_name'];
    private const SELECT_FROM = "SELECT us.*, ar.nombre_rol, ac.country_name " . self::FROM;

    private const SELECT_COUNT = "SELECT COUNT(*) as total " . self::FROM;

    private const FROM =    "FROM usuario us
                            JOIN aux_rol ar ON us.id_rol = ar.id_rol
                            LEFT JOIN aux_countries ac ON us.id_country = ac.id";

    public function getUsuarios(): array
    {
        $statement = $this->pdo->query(self::SELECT_FROM);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarioFiltros(array $filtros, int $order, int $page = 1, int $pageSize = -1): array
    {
        if ($pageSize <= 0){
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        $sentidoOrder = ($order < 0) ? 'DESC' : 'ASC';
        $order = abs($order);
        $offset = self::getOffset($page, $pageSize);
        if (empty($filtros)) {
            $stmt = $this->pdo->query(self::SELECT_FROM . ' ORDER BY '.self::ORDER_COLUMNS[$order - 1]. " $sentidoOrder LIMIT $offset, $pageSize") ;
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $condiciones = $this->getCondiciones($filtros);
            $sql = self::SELECT_FROM . ' WHERE ' . implode(' AND ', $condiciones). ' ORDER BY '.self::ORDER_COLUMNS[$order - 1]. " $sentidoOrder LIMIT $offset, $pageSize";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function countUsuarioFiltros(array $filtros): int
    {
        if (empty($filtros)) {
            $stmt = $this->pdo->query(self::SELECT_COUNT) ;
            return (int)$stmt->fetchColumn(0);
        } else {
            $condiciones = $this->getCondiciones($filtros);

            $sql = self::SELECT_COUNT . ' WHERE ' . implode(' AND ', $condiciones);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros);
            return (int)$stmt->fetchColumn(0);
        }
    }

    public static function getOffset(?int $page = 0, int $pageSize = -1): int
    {
        if ($page <= 0){
            $page = 1;
        }
        if ($pageSize <= 0){
            $pageSize = $_ENV['usuarios.rows_per_page'];
        }
        return ($page - 1) * $pageSize;
    }

    private function getCondiciones(array &$filtros): array
    {
        $condiciones = [];
        if (isset($filtros['username'])) {
            $condiciones[] = 'us.username LIKE :username';
        }
        if (isset($filtros['id_rol'])) {
            $condiciones[] = 'us.id_rol = :id_rol';
        }
        if (isset($filtros['min_salar'])) {
            $condiciones[] = 'us.salarioBruto >= :min_salar';
        }
        if (isset($filtros['max_salar'])) {
            $condiciones[] = 'us.salarioBruto <= :max_salar';
        }
        if (isset($filtros['min_retencion'])) {
            $condiciones[] = 'us.retencionIRPF >= :min_retencion';
        }
        if (isset($filtros['max_retencion'])) {
            $condiciones[] = 'us.retencionIRPF <= :max_retencion';
        }
        if (isset($filtros['id_country'])) {
            $i = 1;
            $countries = [];
            foreach ($filtros['id_country'] as $idCountry) {
                $countries[':id_country' . $i++] = $idCountry;
            }
            unset($filtros['id_country']);
            $filtros = array_merge($filtros, $countries);
            $condiciones[] = 'us.id_country IN (' . implode(',', array_keys($countries)) . ')';
        }
        return $condiciones;
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
            $vars[':id_country' . $i++] = $idCountry;
        }
        $_valores = array_keys($vars);
        $query = self::SELECT_FROM . ' WHERE id_country IN (' . implode(',', $_valores) . ')';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function insertUsuario(array $usuario): bool
    {
        $stmt = $this->pdo->prepare('Insert into usuario (username, salarioBruto, retencionIRPF, activo, id_rol, id_country)
                                    values (:username, :salarioBruto, :retencionIRPF, :activo, :id_rol, :id_country)');
        /*$stmt->bindValue(':activo', $usuario['activo'], PDO::PARAM_BOOL);
        $stmt->bindValue(':username', $usuario['username'], PDO::PARAM_STR);
        $stmt->bindValue(':salarioBruto', $usuario['salarioBruto'], PDO::PARAM_STR);
        $stmt->bindValue(':retencionIRPF', $usuario['retencionIRPF'], PDO::PARAM_STR);
        $stmt->bindValue(':id_rol', $usuario['id_rol'], PDO::PARAM_INT);
        $stmt->bindValue(':id_country', $usuario['id_country'], PDO::PARAM_INT);
        return $stmt->execute();*/
        return $stmt->execute($usuario);
    }
}
