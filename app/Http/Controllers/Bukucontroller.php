<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Illuminate\Support\Facades\Validator;
class Bukucontroller extends Controller
{
    public function store(Request $req)
    {
        $validator=Validator::make($req->all(),
            [
                'judul'=>'required',
                'penerbit'=>'required',
                'pengarang'=>'required',
                'foto'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Buku::create([
            'judul'=>$req->judul,
            'penerbit'=>$req->penerbit,
            'pengarang'=>$req->pengarang,
            'foto'=>$req->foto,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Buku Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Buku Gagal Ditambahkan";
        }
        return Response()->json(compact('status','message'));
    }
    public function update($id, Request $req)
    {
        $validator=Validator::make($req->all(),
            [
                'judul'=>'required',
                'penerbit'=>'required',
                'pengarang'=>'required',
                'foto'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Buku::where('id',$id)->update([
            'judul'=>$req->judul,
            'penerbit'=>$req->penerbit,
            'pengarang'=>$req->pengarang,
            'foto'=>$req->foto,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Buku Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Buku Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }
    public function destroy($id)
    {
        $hapus=Buku::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Buku Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Buku Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }
    public function tampil()
    {
       $data_buku=Buku::get();
       $count=$data_buku->count();
       $arr_data=array();
       foreach($data_buku as $dt_bk){
           $arr_data[]=array(
               'id'=>$dt_bk->id,
               'judul'=>$dt_bk->judul,
               'penerbit'=>$dt_bk->penerbit,
               'pengarang'=>$dt_bk->pengarang,
               'foto'=>$dt_bk->foto
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }
}