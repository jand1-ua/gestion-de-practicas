<?php

namespace Practicas\Domain;

class Alumno
{
    private int $id;
    private string $nombre;
    private string $email;
    private string $grado;
    private int $curso;

    public function __construct(
        int $id,
        string $nombre,
        string $email,
        string $grado,
        int $curso
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->grado = $grado;
        $this->curso = $curso;
    }

    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
}
