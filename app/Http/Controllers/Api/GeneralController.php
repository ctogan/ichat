<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api;
use App\Event;
use App\Http\Resources\EventResources;
use App\Http\Resources\voucherResources;
use App\PurchaseTransaction;
use App\Reedem;
use App\ViewPurchase;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Api
{
    /**
     * @OA\Get (
     * path="/api/event",
     * summary="Event list",
     * description="show all active event",
     * tags={"event-list"},
     * @OA\Response(
     *     response=200,
     *     description="Event list"
     *   )
     * )
     */

    function get_event(){
        $response = Event::get();
        return $this->successResponse($response);
    }

    /**
     * @OA\Get (
     * path="/api/event/detail",
     * summary="Event list",
     * description="show all active event",
     * tags={"event-list"},
     *     @OA\Parameter(
     *          name="voucher_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Event list"
     *   )
     * )
     */

    function get_event_detail(Request $request){

        $event = Event::where('id',$request->voucher_id)->first();
        $response = new EventResources($event);
        return $this->successResponse($response);
    }

    /**
     * @OA\Post(
     * path="/api/event/reedem",
     * summary="reedem voucher",
     * description="insert to reedem",
     * tags={"reedem-voucher"},
     *     @OA\Parameter(
     *          name="customer_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="voucher_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="reedem voucher success"
     *   )
     * )
     */
    function reedem(Request $request){
        $now = date('Y-m-d H:i:s');
        $customer_id = $request->customer_id;
        $voucher_id = $request->voucher_id;

        $voucher = Voucher::join('events', 'vouchers.event_id', '=', 'events.id')->where('vouchers.id',$voucher_id)->first();

        $reedem = Reedem::where('customer_id',$customer_id)->where('voucher_id',$voucher_id)->where('status','!=','expired')->first();

        if($reedem){
            return $this->errorResponse(static::ERROR_EXISTING_REEDEM,static::CODE_ERROR_EXISTING_REEDEM);
        }

        $min_transaction = PurchaseTransaction::where('customer_id',$customer_id)->whereDate('transaction_at', '>', Carbon::now()->subDays($voucher->day_transaction))->first();

        if(!$min_transaction){
            return $this->errorResponse(static::ERROR_MIN_LAST_TRANSACTION,static::CODE_ERROR_MIN_LAST_TRANSACTION);
        }

        $total_transaction = ViewPurchase::where('customer_id',$customer_id)->first();

        if($total_transaction->total_spent < $voucher->min_transaction){
            return $this->errorResponse(static::ERROR_MIN_TOTAL_TRANSACTION,static::CODE_ERROR_MIN_TOTAL_TRANSACTION);
        }

        $reedem = Reedem::create([
            'customer_id'=>$customer_id,
            'voucher_id'=>$voucher_id,
            'status'=>'waiting',
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        if($reedem){
            Voucher::where([
                ['id',$voucher_id],
            ])->update([
                'is_used'=> true,
                'updated_at' => $now,
            ]);
        }
        return $this->successResponse($reedem);
    }

    /**
     * @OA\Post(
     * path="/api/event/reedem/upload",
     * summary="reedem voucher",
     * description="insert to reedem",
     * tags={"reedem-voucher"},
     *     @OA\Parameter(
     *          name="customer_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="voucher_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="image_file",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="file"
     *          )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="reedem voucher success"
     *   )
     * )
     */
    public function upload(Request $request){

        $customer_id = $request->customer_id;
        $voucher_id = $request->voucher_id;
        $file = $request->file('image_file');

        $validation = Validator::make($request->all(), [
            'image_file' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if($validation->fails()) {
            return $this->errorResponse($validation->messages(),'505');
        }

        $now = date('Y-m-d H:i:s');
        $reedem = Reedem::where('customer_id',$customer_id)->where('voucher_id',$voucher_id)->where('status','waiting')->first();
        if(!$reedem){
            return $this->errorResponse(static::ERROR_NOT_DURATION,static::CODE_ERROR_NOT_DURATION);
        }

        $reedem_time = $this->getCreatedAtAttribute($reedem->created_at);
        $reedem_time = Carbon::parse($reedem_time);
        $upload_time = Carbon::parse($now);
        $duration =  $reedem_time->diff($upload_time)->format('%I');


        if($duration > 10){

            $record = Reedem::where([
                ['id',$reedem->id],
            ])->update([
                'status'=> 'expired',
                'updated_at' => $now,
            ]);

            Voucher::where([
                ['id',$voucher_id],
            ])->update([
                'is_used'=> false,
                'updated_at' => $now,
            ]);

            return $this->errorResponse(static::ERROR_MIN_DURATION,static::CODE_ERROR_MIN_DURATION);
        }else{

            $file_name = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload'), $file_name);
            $path = public_path(). '/upload/'.$file_name;

            //send to Validate photo submission {reedem_id ; path }

            $record = Reedem::where([
                ['id',$reedem->id],
            ])->update([
                'image'=>$path,
                'updated_at' => $now,
            ]);
        }

        return $this->successResponse($record);

    }

    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i:s');
    }


    public function callback(Request $request){

        $now = date('Y-m-d H:i:s');
        $json = $request->all();
        $data = json_decode(json_encode($json),true);
        $reedem_id = $data['data']['reedem_id'];

        if($data['data']['rc'] == '00'){
            $status = 'success';
        }else{
            $status = 'failed';
        }

        $record = Reedem::where([
            ['id',$reedem_id],
        ])->update([
            'status'=>$status,
            'updated_at' => $now,
        ]);


        return response()->json(['status'=> 'success', 'code' => '200']);

    }
}
