<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Ichat API's",
 *    version="1.0.0",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected const ERROR_EXISTING_REEDEM = "Reedem already done.";
    protected const ERROR_MIN_LAST_TRANSACTION = "Customer must make a transaction at least 30 days.";
    protected const ERROR_MIN_TOTAL_TRANSACTION = "Failure to meet minimum purchase requirements ";
    protected const ERROR_MIN_DURATION = "Upload time limit is 10 minutes from voucher reedem";
    protected const ERROR_NOT_DURATION = "Reedem not found ";



    protected const CODE_ERROR_EXISTING_REEDEM = '201';
    protected const CODE_ERROR_MIN_LAST_TRANSACTION = '202';
    protected const CODE_ERROR_MIN_TOTAL_TRANSACTION = '203';
    protected const CODE_ERROR_MIN_DURATION = '204';
    protected const CODE_ERROR_NOT_DURATION = '205';


}
