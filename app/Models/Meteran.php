<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meteran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pelanggan_id', 'periode', 'awal', 'akhir', 'pemakaian', 'is_generate_bill', 'created_at', 'updated_at'
    ];


    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
