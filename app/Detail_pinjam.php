<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_pinjam extends Model
{
    protected $table="detail";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'id_pinjam', 'id_buku', 'qty'
    ];

    public function buku(){
        return this()->hasMany('App\Buku', 'id_buku');
    }
}
 