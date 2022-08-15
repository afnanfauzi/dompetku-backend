<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Http\Resources\Mitra as Mitras;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;

class MitraController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 
        $paging = request('paging');
        $search = request('search');
        $user_id = request('user_id');

        if($user->hasPermissionTo('mitra-read')){
            $mitra = Mitra::when($search, function ($query, $search) {
                return $query->where('nama_mitra', 'like', "%$search%");
            })->where('user_id', '=', $user_id)->latest()->paginate($paging);

            $mitra_aktif = Mitra::when($search, function ($query, $search) {
                return $query->where('nama_mitra', 'like', "%$search%");
            })->where('user_id', '=', $user_id)->where('is_active', '=', 1)->latest()->paginate($paging);

            $data = [
                "mitra" =>$mitra,
                "mitra_aktif" => $mitra_aktif,
            ];

            return $this->sendResponse($data, 'Mitra retrieved successfully.');
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
            'nama_mitra' => 'required',
            'is_active' => 'required',
            'user_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('mitra-create')){

            $mitra = Mitra::create([
                'nama_mitra' => $input['nama_mitra'],
                'is_active' => $input['is_active'],
                'no_hp' => $input['no_hp'],
                'user_id' => $input['user_id'],
             ]);
       
            return $this->sendResponse(new Mitras($mitra), 'Mitra created successfully.');
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
        if($user->hasPermissionTo('mitra-read')){

            $mitra = Mitra::find($id);
            if (is_null($mitra)) {
                return $this->sendError('Mitra not found.');
            }
    
            return $this->sendResponse(new Mitras($mitra), 'Mitra retrieved successfully.');
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
            'nama_mitra' => 'required',
            'is_active' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('mitra-update')){

            $mitra = Mitra::findorfail($id);
            $mitra->nama_mitra = $input['nama_mitra'];
            $mitra->is_active = $input['is_active'];
            $mitra->no_hp = $input['no_hp'];
            $mitra->save();
    
            return $this->sendResponse(new Mitras($mitra), 'Mitra updated successfully.');
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
        //
    }
}
