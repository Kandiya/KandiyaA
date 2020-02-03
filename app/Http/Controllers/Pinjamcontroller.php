<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pinjam;
use App\Buku;
use App\Detail_pinjam;
use JWTAuth;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class PinjamController extends Controller
{

  public function index(){
      $peminjaman=DB::table('peminjaman')
      ->join('anggota','anggota.id','=','peminjaman.id_anggota')
      ->join('petugas','petugas.id','=','peminjaman.id_petugas')
      ->select('peminjaman.id','peminjaman.id_anggota','anggota.nama_anggota','peminjaman.tgl_pinjam','peminjaman.deadline','peminjaman.denda')
      ->get();

      $data=array();
      foreach ($peminjaman as $dt_pj){
        $ok=Detail_pinjam::where('id_pinjam',$dt_pj->id)->get();
        $arr_detail=array();
        foreach ($ok as $ok) {
          $arr_detail[]=array(
          'id_pinjam' =>$ok->id_pinjam,
          'id_buku' => $ok->id_buku,
          'qty' => $ok->qty
          );
        }

        $data[]=array(
          'id' => $dt_pj->id,
          'id_anggota' => $dt_pj->id_anggota,
          'nama_anggota' => $dt_pj->nama_anggota,
          'tgl_pinjam' => $dt_pj->tgl_pinjam,
          'deadline' => $dt_pj->deadline,
          'denda' => $dt_pj->denda,
          'detail_pinjam' => $arr_detail
        );
      }
      return response()->json(compact("data"));
       
      }
      
    

    public function store(Request $request){
      $validator=Validator::make($request->all(),
        [
          'id_anggota'=>'required',
          'id_petugas'=>'required',
          'tgl_pinjam'=>'required',
          'deadline'=>'required',
          'denda'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Pinjam::create([
        'id_anggota'=>$request->id_anggota,
        'id_petugas'=>$request->id_petugas,
        'tgl_pinjam'=>$request->tgl_pinjam,
        'deadline'=>$request->deadline,
        'denda'=>$request->denda
      ]);
      $status=1;
      $message="Peminjaman Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    }

    public function update($id,Request $request){
      $validator=Validator::make($request->all(),
        [
          'id_anggota'=>'required',
          'id_petugas'=>'required',
          'tgl_pinjam'=>'required',
          'deadline'=>'required',
          'denda'=>'required'
        ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $ubah=Pinjam::where('id',$id)->update([
      'id_anggota'=>$request->id_anggota,
      'id_petugas'=>$request->id_petugas,
      'tgl_pinjam'=>$request->tgl_pinjam,
      'deadline'=>$request->deadline,
      'denda'=>$request->denda
    ]);
    $status=1;
    $message="Peminjaman Berhasil Diubah";
    if($ubah){
      return Response()->json(compact('status','message'));
    }else {
      return Response()->json(['status'=>0]);
    }
  }

  public function tampil_pinjam(){
    $data=DB::table('peminjaman')
    ->join('anggota','anggota.id','=','peminjaman.id_anggota')
    ->join('petugas','petugas.id','=','peminjaman.id_petugas')
    ->select('peminjaman.id','anggota.nama_anggota','anggota.alamat','anggota.telp','petugas.nama_petugas','peminjaman.tgl_pinjam','peminjaman.deadline','peminjaman.denda')
    ->get();
    $count=$data->count();
    $status=1;
    $message="Peminjaman Berhasil ditampilkan";
    return response()->json(compact('data','status','message','count'));
  }

  public function destroy($id){
    $hapus=Pinjam::where('id',$id)->delete();
    $status=1;
    $message="Peminjaman Berhasil Dihapus";
    if($hapus){
      return Response()->json(compact('status','message'));
    }else {
      return Response()->json(['status'=>0]);
    }
  }






  //detail_pinjam

  public function simpan(Request $request){
    $validator=Validator::make($request->all(),
      [
        'id_pinjam'=>'required',
        'id_buku'=>'required',
        'qty'=>'required'
      ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $simpan=Detail_pinjam::create([
      'id_pinjam'=>$request->id_pinjam,
      'id_buku'=>$request->id_buku,
      'qty'=>$request->qty
    ]);
    $status=1;
    $message="Detail Peminjaman Berhasil Ditambahkan";
    if($simpan){
      return Response()->json(compact('status','message'));
    }else {
      return Response()->json(['status'=>0]);
    }
  }


  public function ubah($id,Request $request){
    $validator=Validator::make($request->all(),
      [
        'id_pinjam'=>'required',
        'id_buku'=>'required',
        'qty'=>'required'
      ]
  );

  if($validator->fails()){
    return Response()->json($validator->errors());
  }

  $ubah=Detail_pinjam::where('id',$id)->update([
    'id_pinjam'=>$request->id_pinjam,
    'id_buku'=>$request->id_buku,
    'qty'=>$request->qty
  ]);
  $status=1;
  $message="Detail Peminjaman Berhasil Diubah";
  if($ubah){
    return Response()->json(compact('status','message'));
  }else {
    return Response()->json(['status'=>0]);
  }
}


public function hapus($id){
  $hapus=Detail_pinjam::where('id',$id)->delete();
  $status=1;
  $message="Detail Peminjaman Berhasil Dihapus";
  if($hapus){
    return Response()->json(compact('status','message'));
  }else {
    return Response()->json(['status'=>0]);
  }
}


  



}