<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataTransaksi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'catatan' => $this->catatan,
            'total_uang' => $this->total_uang,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'kategori_id' => $this->kategori_id,
        ];
    }
}
