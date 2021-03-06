<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table="buku";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'judul', 'penerbit', 'pengarang', 'foto'
    ];

    public function detail_peminjaman(){
        return this()->hasMany('App\detail_peminjaman', 'id');
    }
}
