<?php

namespace Com\Daw2\Models;

class CsvModel
{
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
}
