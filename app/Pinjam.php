<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $table="peminjaman";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'tgl_pinjam', 'id_anggota', 'id_petugas', 'deadline', 'denda'
    ];
}
