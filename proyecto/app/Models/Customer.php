<?php

// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Importa la biblioteca Carbon para manejo de fechas.

class Customer extends Model
{
    // Definimos la tabla asociada a este modelo en la base de datos.
    protected $table = 'customers';

    // Especifica los campos que pueden asignarse.
    protected $fillable = ['customerID', 'name', 'lastName', 'key', 'expirationDate'];

    public $timestamps = false;

    // Definimos el campo de clave primaria para el modelo.
    protected $primaryKey = 'customerID';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Calcula la fecha de expiración en función del tipo de suscripción.
     *
     * @param string $subscription Tipo de suscripción (semana, mes, año).
     * @param string|null $currentExpirationDate Fecha actual de expiración (opcional).
     * @return string Nueva fecha de expiración en formato 'Y-m-d'.
     */
    public static function calculateExpirationDate($subscription, $currentExpirationDate = null)
    {
        // Obtiene la fecha actual.
        $now = Carbon::now();

        // Determina la fecha de inicio para el cálculo (fecha de expiración actual o fecha actual).
        $expirationDate = $currentExpirationDate ? new Carbon($currentExpirationDate) : $now;

        // Si la fecha de expiración es anterior a la fecha actual, se ajusta a la fecha actual.
        if ($expirationDate->lessThan($now)) {
            $expirationDate = $now;
        }

        // Ajusta la fecha de expiración según el tipo de suscripción.
        switch ($subscription) {
            case 'week':
                return $expirationDate->addWeek()->format('Y-m-d');
            case 'month':
                return $expirationDate->addMonth()->format('Y-m-d');
            case 'year':
                return $expirationDate->addYear()->format('Y-m-d');
            default:
                return $expirationDate->format('Y-m-d');
        }
    }
}
