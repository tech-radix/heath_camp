<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docter extends Model
{
    use HasFactory;
    protected $table = "docters";
    protected $primarykey ="doctor_id";
}
