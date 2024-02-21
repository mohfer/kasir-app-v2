<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokHistory extends Model
{
    use HasFactory;

    protected $table = 'stok_histories';
    protected $fillable = [
        'no_faktur',
        'item_id',
        'supplier_id',
        'jumlah',
        'harga',
        'bayar',
        'kembali',
        'tanggal',
        'keterangan',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
