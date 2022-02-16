<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class voucherResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'voucher_code'=>$this->voucher_code
        ];
    }
}
