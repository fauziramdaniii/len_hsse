<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInspeksi extends Model
{
    protected $fillable = [
        'periode', 'status', 'sudah_inspeksi', 'belum_inspeksi'
    ];
}
