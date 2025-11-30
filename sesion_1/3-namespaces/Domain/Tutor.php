<?php

namespace Practicas\Domain;

class Tutor
{
    private int $id;
    private string $nombre;
    private string $email;
    private string $telefono;
    private Empresa $empresa;

    public function __construct(
        int $id,
        string $nombre,
        string $email,
        string $telefono,
        Empresa $empresa
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->empresa = $empresa;
    }

    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getEmpresa(): Empresa { return $this->empresa; }
}
