<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataTransaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 
        $user_id = request('user_id');
        $tanggal_awal = date('Y-m-d', strtotime(request('tanggal_awal')));
        $tanggal_akhir = date('Y-m-d', strtotime(request('tanggal_akhir')));
        // $user_id = '1';
        // $tanggal_awal = date('Y-m-d', strtotime('2022-08-01'));
        // $tanggal_akhir = date('Y-m-d', strtotime('2022-08-08'));
        
        
        if($user->hasPermissionTo('dashboard-read')){
            $transaksi = DataTransaksi::select('kategori_id', DataTransaksi::raw('SUM(total_uang) as total_uang'))->groupBy('kategori_id')->whereBetween('tanggal_transaksi', array($tanggal_awal,$tanggal_akhir))->where('user_id', '=', $user_id)->get();
            // $kategori = Kategori::where('user_id', '=', $user_id)->orderby('nama_kategori', 'asc')->get();
            $kategori_dashboard = Kategori::where('user_id', '=', $user_id)->where('is_active', '=', 1)->where('jenis_transaksi', '=', 0)->orderby('nama_kategori', 'asc')->get();

            $list = [];
            $push = [];
            foreach($transaksi as $trans){
                foreach($kategori_dashboard as $kat){
                    if($kat->id == $trans['kategori_id']){
                        $push [] = [
                            'nama_kategori' => $kat->nama_kategori,
                            'kategori_id' => $kat->id,
                            'rencana_anggaran' => $kat['rencana_anggaran'],
                            'anggaran_digunakan' => $trans['total_uang'],
                            'anggaran_sisa' => $kat['rencana_anggaran'] -  $trans['total_uang'],
                        ];
                    }
                    // else{
                    //     $push = [];
                    // }
                }
            }

            array_push($list, $push);
            
            $data = [
                'list_anggaran' => $list
            ];
            // return $data;
            return $this->sendResponse($data, 'Transaction retrieved successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
