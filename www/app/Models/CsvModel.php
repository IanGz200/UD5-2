<?php

namespace Com\Daw2\Models;

class CsvModel
{
    public const COL_MUNICIPIO = 0;
    public const COL_SEXO = 1;
    public const COL_ANHO = 2;
    public function __construct(private string $filename)
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException("File $filename does not exist");
        }
    }

    public function loadData(): array
    {
        $csvfile = file($this->filename);
        $resultado = [];
        foreach ($csvfile as $line) {
            $resultado[] = str_getcsv($line, ';');
        }
        return $resultado;
    }

    /**
     * @param array $data
     * @return bool true si se inserta el registro. False otherwise.
     * @throws \ErrorException si no se tienen permisos sobre los ficheros
     */
    public function insertPoblacionPontevedra(array $data): bool
    {
        set_error_handler(function () {
            throw new \ErrorException("No se ha podido realizar la operación sobre el fichero");
        }, E_WARNING);
        $resource = fopen($this->filename, 'a');
        $resultado = fputcsv($resource, $data, ';');
        fclose($resource);
        restore_error_handler();
        return $resultado !== false;
    }

    /**
     * @param string $municipio
     * @param string $sexo
     * @param int $anho
     * @return bool
     * @throws \ErrorException si no se tienen permisos sobre los ficheros
     */
    public function existsData(string $municipio, string $sexo, int $anho): bool
    {
        set_error_handler(function () {
            throw new \ErrorException("No se ha podido realizar la operación sobre el fichero");
        }, E_WARNING);
        $datos = $this->loadData();
        restore_error_handler();
        foreach ($datos as $fila) {
            if (
                $fila[self::COL_MUNICIPIO] == $municipio &&
                $fila[self::COL_SEXO] == $sexo &&
                $fila[self::COL_ANHO] == $anho
            ) {
                return true;
            }
        }
        return false;
    }
}
