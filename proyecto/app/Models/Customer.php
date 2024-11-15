<?php
// app/Models/Customer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['customerID', 'name', 'lastName', 'key', 'expirationDate'];

    public $timestamps = false;

    protected $primaryKey = 'customerID';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function calculateExpirationDate($subscription, $currentExpirationDate = null)
    {
        $now = Carbon::now();
        $expirationDate = $currentExpirationDate ? new Carbon($currentExpirationDate) : $now;

        if ($expirationDate->lessThan($now)) {
            // Si la fecha de vencimiento es anterior a la fecha actual, comienza desde la fecha actual
            $expirationDate = $now;
        }

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
