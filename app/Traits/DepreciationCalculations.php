<?php

namespace App\Traits;

use DateTime;

trait DepreciationCalculations
{
    public function diasDesdeDiciembre()
    {
        $fechaUltimoDiciembre = $this->fechaUltimoDiciembre();
        return floor((now()->timestamp - $fechaUltimoDiciembre->timestamp) / (60 * 60 * 24));
    }

    public function depreciacionAnual($costoInicial, $vidaUtil)
    {
        return $costoInicial / $vidaUtil;
    }

    public function depreciacionDiaria($costoInicial, $vidaUtil)
    {
        return $costoInicial / $vidaUtil / 365;
    }

    public function diasTranscurridos($fechaInicial)
    {
        if ($fechaInicial) {
            return floor(now()->diffInDays($fechaInicial));
        } else {
            return 0;
        }
    }

    public function depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial)
    {
        if ($fechaInicial) {
            return $this->depreciacionDiaria($costoInicial, $vidaUtil) * $this->diasTranscurridos($fechaInicial);
        } else {
            return null;
        }
    }

    public function valorActual($costoInicial, $vidaUtil, $fechaInicial)
    {
        $depreciacionAcumulada = $this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial);

        $resultado = $costoInicial - $depreciacionAcumulada;

        if ($resultado < 0) {
            return 1;
        }

        return $resultado; // Devuelve el resultado si es mayor o igual a 0
    }

    public function fechaUltimoDiciembre()
    {
        return now()->subYear()->month(12)->day(31);
    }

    public function vidaRestante($fechaInicial, $vidaUtil)
    {
        $fechaActual = new DateTime();
        $fechaInicial = new DateTime($fechaInicial);

        $diferenciaAnios = $fechaActual->diff($fechaInicial)->y;

        // Calcular la vida restante
        $vidaRestante = $vidaUtil - $diferenciaAnios;

        // Asegurarse de que la vida restante no sea negativa
        $vidaRestante = max(0, $vidaRestante);

        return $vidaRestante;
    }

    public function fechaDepreciacion($fechaInicial)
    {
        $fechaUltimoDiciembre = $this->fechaUltimoDiciembre();

        $fechaInicialCarbon = \Carbon\Carbon::parse($fechaInicial);
        $fechaUltimoDiciembreCarbon = \Carbon\Carbon::parse($fechaUltimoDiciembre);

        if ($fechaInicialCarbon->gt($fechaUltimoDiciembreCarbon)) {
            return null;
        } else {
            return $fechaUltimoDiciembre;
        }
    }


    public function factorActual($costoInicial, $vidaUtil)
    {
        return $costoInicial / $vidaUtil / 365;
    }

    public function depreciacionAcumuladaGestion($costoInicial, $vidaUtil)
    {
        return $this->depreciacionDiaria($costoInicial, $vidaUtil) * $this->diasDesdeDiciembre();
    }

    public function depreciacionAcumuladaInicial($costoInicial, $vidaUtil, $fechaInicial)
    {
        if ($fechaInicial <= $this->fechaUltimoDiciembre()) {
            return $this->depreciacionDiaria($costoInicial, $vidaUtil) * $this->fechaUltimoCorte($fechaInicial);
        }
        return 0;
    }

    public function fechaUltimoCorte($fechaInicial)
    {
        return floor(($this->fechaUltimoDiciembre()->timestamp - $fechaInicial->timestamp) / (60 * 60 * 24));
    }
}
