<?php

namespace App\Traits;

use DateTime;

trait DepreciationCalculations
{
    public function diasDesdeDiciembre()
    {
        $fechaUltimoDiciembre = $this->fechaUltimoDiciembre();
        return floor(
            (time() - $fechaUltimoDiciembre->getTimestamp()) / (60 * 60 * 24)
        );
    }

    public function diasTranscurridos($fechaInicial)
    {
        if ($fechaInicial) {
            return floor((time() - strtotime($fechaInicial)) / (60 * 60 * 24));
        } else {
            return 0;
        }
    }

    public function fechaUltimoCorte($fechaInicial)
    {
        return floor(
            ($this->fechaUltimoDiciembre()->getTimestamp() - strtotime($fechaInicial)) / (60 * 60 * 24)
        );
    }

    public function fechaUltimoDiciembre()
    {
        return new DateTime(date('Y') - 1 . '-12-31');
    }

    public function factorActual($ufInicial, $ufActual)
    {
        return $ufActual / $ufInicial;
    }

    public function coeficienteDep($vidaUtil)
    {
        return (1 / $vidaUtil) * 100;
    }

    public function costoInicialActualizado($costoInicial, $ufInicial, $ufActual)
    {
        return $costoInicial * $this->factorActual($ufInicial, $ufActual);
    }

    public function depreciacionDiaria($costoInicial, $vidaUtil, $ufInicial, $ufActual)
    {
        $factor = $this->factorActual($ufInicial, $ufActual);
        $depreciacionDiaria = $costoInicial / $vidaUtil / 365;
        return $depreciacionDiaria * $factor;
    }

    public function depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual)
    {
        if ($vidaUtil == 0) {
            return 0;
        }

        return $this->depreciacionDiaria($costoInicial, $vidaUtil, $ufInicial, $ufActual) * $this->diasTranscurridos($fechaInicial);
    }

    public function depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual)
    {
        if ($vidaUtil == 0) {
            return 0;
        }

        return $this->depreciacionDiaria($costoInicial, $vidaUtil, $ufInicial, $ufActual) * $this->diasDesdeDiciembre();
    }

    public function depreciacionAcumuladaInicial($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual)
    {
        if ($vidaUtil == 0) {
            return 0;
        }

        if ($fechaInicial <= $this->fechaUltimoDiciembre()) {
            return $this->depreciacionDiaria($costoInicial, $vidaUtil, $ufInicial, $ufActual) * $this->fechaUltimoCorte($fechaInicial);
        }

        return 0;
    }

    public function valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual)
    {
        if ($vidaUtil == 0) {
            return $this->costoInicialActualizado($costoInicial, $ufInicial, $ufActual);
        }

        $resultado = $costoInicial - $this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual);

        if ($resultado < 0) {
            return 1;
        }

        return $resultado;
    }
}
