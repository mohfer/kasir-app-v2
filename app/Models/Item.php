<?php

namespace App\Models;

use App\Models\Category;
use App\Models\StokHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = "items";
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'category_id',
        'harga_beli',
        'harga_jual_awal',
        'diskon',
        'harga_jual_akhir',
        'foto',
        'stock_id',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }

    public function stock_history(): HasMany
    {
        return $this->hasMany(StokHistory::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
