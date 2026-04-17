<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'judul_pengaduan',
        'deskripsi_masalah',
        'lokasi_kejadian',
        'foto_bukti',
        'status_laporan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
