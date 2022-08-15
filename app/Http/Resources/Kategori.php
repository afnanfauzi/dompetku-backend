<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Kategori extends JsonResource
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
            'nama_kategori' => $this->nama_kategori,
            'is_active' => $this->is_active,
            'jenis_transaksi' => $this->jenis_transaksi,
            'rencana_anggaran' => $this->rencana_anggaran,
        ];
    }
}
