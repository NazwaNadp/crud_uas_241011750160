<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'dessert_id',
        'nama_pemesan',
        'no_hp',
        'jumlah',
        'catatan',
        'total_harga',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
        ];
    }

    public function dessert()
    {
        return $this->belongsTo(Dessert::class, 'dessert_id', 'id_dessert');
    }

    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'pending'     => '<span class="badge bg-warning text-dark">Pending</span>',
            'diproses'    => '<span class="badge bg-info text-dark">Diproses</span>',
            'selesai'     => '<span class="badge bg-success">Selesai</span>',
            'dibatalkan'  => '<span class="badge bg-danger">Dibatalkan</span>',
            default       => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
