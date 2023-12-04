<?php

namespace Database\Factories;

use App\Models\AsistenciaModel;
use Carbon\Carbon;
use App\Models\EmpleadosModel;
use App\Models\HorarioModel;
use App\Models\RetrasosModelModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroAsistenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::parse('2023-05-01');
        $endDate = Carbon::parse('2023-05-31');
        $id = '4';

        // Obtén la lista de empleados de forma aleatoria
        $empleados = EmpleadosModel::inRandomOrder()->get();

        // Inicializa la fecha al comienzo
        $currentDate = $startDate;

        // Define la lógica para crear registros de asistencia secuenciales
        $definition = [
            'horario_id' => $id,
        ];

        while ($currentDate <= $endDate) {
            $horaEntrada = $this->faker->dateTimeBetween("$currentDate 08:00:00", "$currentDate 08:05:00")->format('H:i:s');
            $horaSalida = $this->faker->dateTimeBetween("$currentDate 12:00:00", "$currentDate 13:00:00")->format('H:i:s');
            $horaEntrada2 = $this->faker->dateTimeBetween("$currentDate 14:30:00", "$currentDate 14:05:00")->format('H:i:s');
            $horaSalida2 = $this->faker->dateTimeBetween("$currentDate 18:00:00", "$currentDate 18:05:00")->format('H:i:s');

            $definition['empleado_id'] = $empleados->random()->idemp;
            $definition['registro_inicio'] = $horaEntrada;
            $definition['registro_salida'] = $horaSalida;
            $definition['registro_entrada'] = $horaEntrada2;
            $definition['registro_final'] = $horaSalida2;
            $definition['fecha'] = $currentDate->format('Y-m-d');

            // Crea una instancia del modelo con la definición actual
            $this->state(function () use ($definition) {
                return $definition;
            });

            // Incrementa la fecha para la siguiente iteración
            $currentDate->addDay();
        }

        return $definition;
    }
}
