<?php

namespace App\Http\Resources;

use App\Voucher;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Collection;

class EventResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $vouchers = Voucher::where('event_id',$this->id)->where('is_used',false)->get();
        return [
            'id'=>$this->id,
            'event_name'=>$this->event_name,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'min_transaction'=>$this->min_transaction,
            'day_transaction'=>$this->day_transaction,
            'vouchers'=> voucherResources::collection($vouchers)
        ];
    }
}
