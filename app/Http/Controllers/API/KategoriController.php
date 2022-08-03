<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Kategori as Kat;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Validator;

class KategoriController extends BaseController
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

        if($user->hasPermissionTo('kategori-read')){
            $kategori = Kategori::when($search, function ($query, $search) {
                return $query->where('nama_kategori', 'like', "%$search%");
            })->where('user_id', '=', $user_id)->latest()->paginate($paging);

            return $this->sendResponse($kategori, 'Categories retrieved successfully.');
            // return $this->sendResponse(Kategori::collection($kategori), 'Categories product retrieved successfully.');
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
            'nama_kategori' => 'required',
            'is_active' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('kategori-create')){

            $kategori = Kategori::create([
                'nama_kategori' => $input['nama_kategori'],
                'is_active' => $input['is_active'],
                'plot_uang' => $input['plot_uang'],
                'user_id' => $input['user_id']
             ]);
       
            return $this->sendResponse(new Kat($kategori), 'Category created successfully.');
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
        if($user->hasPermissionTo('kategori-read')){

            $kategori = Kategori::find($id);
            if (is_null($kategori)) {
                return $this->sendError('Category not found.');
            }
    
            return $this->sendResponse(new Kat($kategori), 'Category retrieved successfully.');
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
            'nama_kategori' => 'required',
            'is_active' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error.', $validator->errors());       
        }
   
        $user = Auth::user(); 
        if($user->hasPermissionTo('kategori-update')){

            $kategori = Kategori::findorfail($id);
            $kategori->nama_kategori = $input['nama_kategori'];
            $kategori->is_active = $input['is_active'];
            $kategori->plot_uang = $input['plot_uang'];
            $kategori->save();
    
            return $this->sendResponse(new Kat($kategori), 'Category updated successfully.');
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
