<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;
    protected $table = 'readings'; 
    protected $fillable = ['sensor_id', 'valor', 'registrado_en'];
}
 