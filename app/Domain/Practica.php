<?php

namespace App\Domain;
use DateTime;

class Practica
{
    private int $id;
    private Alumno $alumno;
    private Empresa $empresa;
    private Tutor $tutor;
    private DateTime $fechaInicio;
    private DateTime $fechaFin;

    public function __construct(
        int $id,
        Alumno $alumno,
        Empresa $empresa,
        Tutor $tutor,
        DateTime $fechaInicio,
        DateTime $fechaFin
    ) {
        $this->id = $id;
        $this->alumno = $alumno;
        $this->empresa = $empresa;
        $this->tutor = $tutor;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function getId(): int { return $this->id; }
    public function getAlumno(): Alumno { return $this->alumno; }
    public function getEmpresa(): Empresa { return $this->empresa; }
    public function getTutor(): Tutor { return $this->tutor; }

    public function getDuracionEnDias(): int
    {
        $intervalo = $this->fechaInicio->diff($this->fechaFin);
        return $intervalo->days;
    }

    public function getEstado(?DateTime $referencia = null): string
    {
        $ref = $referencia ?? new DateTime();

        if ($ref < $this->fechaInicio) {
            return 'pendiente';
        }

        if ($ref > $this->fechaFin) {
            return 'finalizada';
        }

        return 'en curso';
    }
}
