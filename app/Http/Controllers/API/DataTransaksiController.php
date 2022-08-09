<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\DataTransaksi as Transaksi;
use Validator;

class DataTransaksiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 
        // $paging = request('paging');
        $tanggal = date('Y-m-d', strtotime(request('tanggal')));
        $user_id = request('user_id');
        
        if($user->hasPermissionTo('transaksi-read')){
            $transaksi = DataTransaksi::with('kategori')->whereDate("tanggal_transaksi", "=", $tanggal)->where('user_id', '=', $user_id)->get();
            $uang_masuk =  DataTransaksi::with('kategori')->whereHas('kategori', function($query){$query->where('jenis_transaksi', '=', 1);})->whereDate("tanggal_transaksi", "=", $tanggal)->where('user_id', '=', $user_id)->sum('total_uang');
            $uang_keluar =  DataTransaksi::with('kategori')->whereHas('kategori', function($query){$query->where('jenis_transaksi', '=', 0);})->whereDate("tanggal_transaksi", "=", $tanggal)->where('user_id', '=', $user_id)->sum('total_uang');
            $total_transaksi = $uang_masuk - $uang_keluar;
            $data = [
                'transaksi' => $transaksi,
                'total_transaksi' => $total_transaksi
            ];
            // return $total_transaksi;
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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'catatan' => 'required',
            'total_uang' => 'required',
            'tanggal_transaksi' => 'required',
            'kategori_id' => 'required',
            'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('transaksi-create')){

            $transaksi = DataTransaksi::create([
                'catatan' => $input['catatan'],
                'total_uang' => $input['total_uang'],
                'tanggal_transaksi' => $input['tanggal_transaksi'],
                'kategori_id' => $input['kategori_id'],
                'user_id' => $input['user_id']
             ]);
       
            return $this->sendResponse(new Transaksi($transaksi), 'Transaction created successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user(); 
        if($user->hasPermissionTo('transaksi-read')){

            $transaksi = DataTransaksi::find($id);
            if (is_null($transaksi)) {
                return $this->sendError('Transaction not found.');
            }
    
            return $this->sendResponse(new Transaksi($transaksi), 'Transaction retrieved successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'catatan' => 'required',
            'total_uang' => 'required',
            'tanggal_transaksi' => 'required',
            'kategori_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('transaksi-update')){

            $transaksi = DataTransaksi::findorfail($id);
            $transaksi->catatan = $input['catatan'];
            $transaksi->total_uang = $input['total_uang'];
            $transaksi->tanggal_transaksi = $input['tanggal_transaksi'];
            $transaksi->kategori_id = $input['kategori_id'];
            $transaksi->save();
    
            return $this->sendResponse(new Transaksi($transaksi), 'Transaction updated successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user(); 
        if($user->hasPermissionTo('transaksi-delete')){

            $transaksi = DataTransaksi::findorfail($id);
            $transaksi->delete();
        
            return $this->sendResponse(new Transaksi($transaksi), 'Transaction delete successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }

    }
}
