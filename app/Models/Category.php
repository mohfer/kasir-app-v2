<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $fillable = [
        'nama_kategori',
    ];

    public function item(): HasMany
    {
        return $this->HasMany(Item::class);
    }
}
