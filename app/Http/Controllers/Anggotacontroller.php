<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use Illuminate\Support\Facades\Validator;
class AnggotaController extends Controller
{
    public function store(Request $req)
    {
        $validator=Validator::make($req->all(),
            [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Anggota::create([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Anggota Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Siswa Anggota Ditambahkan";
        }
        return Response()->json(compact('status','message'));
    }
    public function update($id, Request $req)
    {
        $validator=Validator::make($req->all(),
            [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Anggota::where('id',$id)->update([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Anggota Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Anggota Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }
    public function destroy($id)
    {
        $hapus=Anggota::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Anggota Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Anggota Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }
    public function tampil()
    {
       $data_anggota=Anggota::get();
       $count=$data_anggota->count();
       $arr_data=array();
       foreach($data_anggota as $dt_ag){
           $arr_data[]=array(
               'id'=>$dt_ag->id,
               'nama_anggota'=>$dt_ag->nama_anggota,
               'alamat'=>$dt_ag->alamat,
               'telp'=>$dt_ag->telp
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }
}