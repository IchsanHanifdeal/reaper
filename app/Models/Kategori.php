<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $fillable = ['kode_kategori', 'nama_kategori'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_kategori', 'id_kategori');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_kategori');
    }
}
