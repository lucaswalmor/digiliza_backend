<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'mesa_id', 'dat_inicio', 'horario', 'cliente_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function mesa() {
        return $this->belongsTo(Mesa::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
