<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertandingan extends Model
{
    use HasFactory;

    protected $table = 'pertandingan';

    protected $fillable = [
        'user_id', 
        'tim_1', 
        'tim_2', 
        'gol_tim_1', 
        'gol_tim_2', 
        'pencetak_gol_tim_1', 
        'pencetak_gol_tim_2', 
        'home_away', 
        'tanggal_pertandingan',
    ];
}
