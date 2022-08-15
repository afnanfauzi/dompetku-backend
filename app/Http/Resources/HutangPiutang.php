<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HutangPiutang extends JsonResource
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
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'total_uang' => $this->total_uang,
            'catatan' => $this->catatan,
            'jenis' => $this->jenis,
            'mitra_id' => $this->mitra_id,
        ];
    }
}
