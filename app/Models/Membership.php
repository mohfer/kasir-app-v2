<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';
    protected $fillable = [
        'kode_member',
        'nama',
        'email',
        'telp',
        'diskon',
        'tgl_berlangganan',
        'aktif',
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
