<?php

namespace App\Http\Controllers\Api\ApiRegisterController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;
use App\User;
use APIResponseManager;
use Carbon\Carbon;
use App\Libraries\Utils\Utils;

class ApiRegisterController extends Controller
{
  /**
  * @author Meet Parikh
  *
  * Method name: Register
  * This method is used for create new register from API.
  *
  * @param  {integer} user_id - The id of the user.
  * @param  {decimal} location_id - The location_id of the location.
  * @return register detail,Response code,message.
  * @exception throw if any error occur when create till from API.
  */
  public function register(Request $request) {
    // Log::info(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $input = $request->all();
        if (is_null($input) || empty($input)) {
          // Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::' . WorkedShift_API_JSON_INVALID);
          return Response()->json(APIResponseManager::getError(WorkedShift_API_JSON_INVALID, API_LOG_BAD_REQUEST_CODE));
        } else {
          $validation = User::apiValidateRegister($input);
          if ($validation != null && $validation != "" && $validation->fails()) {
            $logMessages = $validation->messages()->all();
            $message = implode("<br> ", $logMessages);
            $messages['validationMessages'] = $logMessages;
            // Log::warning(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::' . $message);
            return Response()->json(APIResponseManager::getError($messages['validationMessages'], API_LOG_BAD_REQUEST_CODE));
          }
		  
		    $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
		
		    return APIResponseManager::getResult($success);

		
          }
        }
       catch (Exception $ex) {
        // Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

}
