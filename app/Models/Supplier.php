<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'telp'
    ];

    public function stock_history(): HasMany
    {
        return $this->hasMany(StokHistory::class);
    }
}
