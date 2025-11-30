<?php

namespace Practicas\Domain;

class Empresa
{
    private int $id;
    private string $nombre;
    private string $cif;
    private string $ciudad;
    private string $sector;

    public function __construct(
        int $id,
        string $nombre,
        string $cif,
        string $ciudad,
        string $sector
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cif = $cif;
        $this->ciudad = $ciudad;
        $this->sector = $sector;
    }

    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
}
