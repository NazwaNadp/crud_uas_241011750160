<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dessert extends Model
{
    use HasFactory;

    protected $table = 'desserts';

    protected $primaryKey = 'id_dessert';

    /**
     *
     * @var list<string>
     */
    protected $fillable = [
        'gambar',
        'nama_dessert',
        'komposisi',
        'harga',
        'kategori',
    ];

    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }
}
