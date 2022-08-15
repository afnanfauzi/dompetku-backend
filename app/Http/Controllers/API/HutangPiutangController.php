<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HutangPiutang;
use App\Http\Resources\HutangPiutang as HP;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;

class HutangPiutangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 
        $mitra = request('mitra_id');
        $user_id = request('user_id');
        // return $mitra;
        
        if($user->hasPermissionTo('hutang-piutang-read')){

            if($mitra != null){
                $hutangpiutang = HutangPiutang::with('mitra')->where('user_id', '=', $user_id)->where("mitra_id", "=", $mitra)->get();
                $hutang =  HutangPiutang::with('mitra')->where('jenis', '=', 0)->where('user_id', '=', $user_id)->where("mitra_id", "=", $mitra)->sum('total_uang');
                $piutang =  HutangPiutang::with('mitra')->where('jenis', '=', 1)->where('user_id', '=', $user_id)->where("mitra_id", "=", $mitra)->sum('total_uang');
                $selisih = $hutang - $piutang;
            }
            else{
                $hutangpiutang = HutangPiutang::with('mitra')->where('user_id', '=', $user_id)->get();
                $hutang =  HutangPiutang::with('mitra')->where('jenis', '=', 0)->where('user_id', '=', $user_id)->sum('total_uang');
                $piutang =  HutangPiutang::with('mitra')->where('jenis', '=', 1)->where('user_id', '=', $user_id)->sum('total_uang');
                $selisih = $hutang - $piutang;
            }

            $data = [
                'hutangpiutang' => $hutangpiutang,
                'hutang' => $hutang,
                'piutang' => $piutang,
                'selisih' => $selisih,
            ];
            
            return $this->sendResponse($data, 'Hutang piutang retrieved successfully.');
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
            'tanggal_transaksi' => 'required',
            'total_uang' => 'required',
            'catatan' => 'required',
            'jenis' => 'required',
            'mitra_id' => 'required',
            'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('hutang-piutang-create')){

            $hutangpiutang = HutangPiutang::create([
                'tanggal_transaksi' => $input['tanggal_transaksi'],
                'total_uang' => $input['total_uang'],
                'catatan' => $input['catatan'],
                'jenis' => $input['jenis'],
                'mitra_id' => $input['mitra_id'],
                'user_id' => $input['user_id']
             ]);
       
            return $this->sendResponse(new HP($hutangpiutang), 'Hutang piutang created successfully.');
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
        if($user->hasPermissionTo('hutang-piutang-read')){

            $hutangpiutang = HutangPiutang::find($id);
            if (is_null($hutangpiutang)) {
                return $this->sendError('Hutang piutang not found.');
            }
    
            return $this->sendResponse(new HP($hutangpiutang), 'Hutang piutang retrieved successfully.');
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
            'tanggal_transaksi' => 'required',
            'total_uang' => 'required',
            'catatan' => 'required',
            'jenis' => 'required',
            'mitra_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('hutang-piutang-update')){

            $hutangpiutang = HutangPiutang::findorfail($id);
            $hutangpiutang->tanggal_transaksi = $input['tanggal_transaksi'];
            $hutangpiutang->total_uang = $input['total_uang'];
            $hutangpiutang->catatan = $input['catatan'];
            $hutangpiutang->mitra_id = $input['mitra_id'];
            $hutangpiutang->jenis = $input['jenis'];
            $hutangpiutang->save();
    
            return $this->sendResponse(new HP($hutangpiutang), 'Hutang piutang updated successfully.');
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
        if($user->hasPermissionTo('hutang-piutang-delete')){

            $hutangpiutang = HutangPiutang::findorfail($id);
            $hutangpiutang->delete();
        
            return $this->sendResponse(new HP($hutangpiutang), 'Hutang piutang delete successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }
}
