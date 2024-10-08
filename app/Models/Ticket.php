<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Ticket",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="seat", type="string"),
 *     @OA\Property(property="status", type="string", enum={"active", "canceled"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['flight_id', 'passenger_name','passport','seat'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
