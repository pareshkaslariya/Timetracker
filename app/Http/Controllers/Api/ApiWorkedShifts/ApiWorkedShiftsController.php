<?php

namespace App\Http\Controllers\Api\ApiWorkedShifts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;
use App\User;
use APIResponseManager;
use Carbon\Carbon;
use App\Libraries\Utils\Utils;
use App\UserWorkedTimeTable;

class ApiWorkedShiftsController extends Controller
{
  /**
  * @author Meet Parikh
  *
  * Method name: checkIn
  * This method is used for create new checkIn from API.
  *
  * @param  {integer} user_id - The id of the user.
  * @param  {string} time_zone - The timezone of the user.
  * @return checkIn detail,Response code,message.
  * @exception throw if any error occur when create till from API.
  */
  public function checkIn(Request $request) {
    Log::info(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $input = $request->all();
        if (is_null($input) || empty($input)) {
          Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::' . WorkedShift_API_JSON_INVALID);
          return Response()->json(APIResponseManager::getError(WorkedShift_API_JSON_INVALID, API_LOG_BAD_REQUEST_CODE));
        } else {
          $validation = UserWorkedTimeTable::apiValidateCheck($input);
          if ($validation != null && $validation != "" && $validation->fails()) {
            $logMessages = $validation->messages()->all();
            $message = implode("<br> ", $logMessages);
            $messages['validationMessages'] = $logMessages;
            Log::warning(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::' . $message);
            return Response()->json(APIResponseManager::getError($messages['validationMessages'], API_LOG_BAD_REQUEST_CODE));
          }
          $user = User::find($input['user_id']);
          if(null == $user || '' == $user ){
            Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::' . API_WORKEDSHIFT_USERID_NOT_EXIST);
            return Response()->json(APIResponseManager::getError(API_WORKEDSHIFT_USERID_NOT_EXIST, API_LOG_NOT_FOUND_RECORD_CODE));
          }
          $checkindata = UserWorkedTimeTable::where('user_id',$input['user_id'])->where('clock_out_time', NULL)->first();
          if(null != $checkindata || '' != $checkindata){
            Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::' . API_WORKEDSHIFT_CHECKIN_NULL_CHECK);
            return Response()->json(APIResponseManager::getError(API_WORKEDSHIFT_CHECKIN_NULL_CHECK, API_LOG_NOT_FOUND_RECORD_CODE));
          } else{
            $data['user_id'] = $input['user_id'];
            $data['time_zone'] = $input['time_zone'] = 'America/Phoenix';
            $data['clock_id'] = Carbon::now()->timezone('America/Phoenix')->format('Y-m-d H:i:s');
            $data['clock_out'] = null;
            $checkIn = UserWorkedTimeTable::create($data);
            if ($checkIn != null && $checkIn != "") {
              $checkIn = UserWorkedTimeTable::find($checkIn['id'])->makeVisible([CREATED_AT, UPDATED_AT]);
              $checkIn[CLOCK_IN_TIME]= Utils::utcDateToTimezoneDateConverting(null, $input['time_zone'],$checkIn[CLOCK_IN_TIME])->format('Y-m-d H:i:s');
              $checkIn['created_at']= Utils::utcDateToTimezoneDateConverting(null, $input['time_zone'],$checkIn[CREATED_AT]);
              $checkIn['updated_at']= Utils::utcDateToTimezoneDateConverting(null, $input['time_zone'],$checkIn[UPDATED_AT]);
              Log::info(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::End');
              return APIResponseManager::getResult($checkIn);
            } else {
              Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::' . WORKEDSHIFT_API_CREATE_ERROR);
              return Response()->json(APIResponseManager::getError(WORKEDSHIFT_API_CREATE_ERROR, API_LOG_INTERNAL_SERVER_ERROR_CODE));
            }
          }
        }
      } catch (Exception $ex) {
        Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkIn::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author Meet Parikh
  *
  * Method name: checkOut
  * This method is used for create new checkOut from API.
  *
  * @param  {integer} user_id - The id of the user.
  * @param  {decimal} location_id - The location_id of the location.
  * @return checkOut detail,Response code,message.
  * @exception throw if any error occur when create till from API.
  */
  public function checkOut(Request $request) {
    Log::info(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $input = $request->all();
        if (is_null($input) || empty($input)) {
          Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . WorkedShift_API_JSON_INVALID);
          return Response()->json(APIResponseManager::getError(WorkedShift_API_JSON_INVALID, API_LOG_BAD_REQUEST_CODE));
        } else {
          $validation = UserWorkedTimeTable::apiValidateCheck($input);
          if ($validation != null && $validation != "" && $validation->fails()) {
            $logMessages = $validation->messages()->all();
            $message = implode("<br> ", $logMessages);
            $messages['validationMessages'] = $logMessages;
            Log::warning(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . $message);
            return Response()->json(APIResponseManager::getError($messages['validationMessages'], API_LOG_BAD_REQUEST_CODE));
          }
          $user = User::find($input['user_id']);
          // $location = Location::where('name', '<>', 'EXTRA ITEM LOCATION')->find($input[LOCATION_ID]);
          if(null == $user || '' == $user ){
            Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . API_WORKEDSHIFT_USERID_NOT_EXIST);
            return Response()->json(APIResponseManager::getError(API_WORKEDSHIFT_USERID_NOT_EXIST, API_LOG_NOT_FOUND_RECORD_CODE));
          }
          // if(null == $location || '' == $location || count($location) <=0){
          //   Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . API_WORKEDSHIFT_LOCATIONID_NOT_EXIST);
          //   return Response()->json(APIResponseManager::getError(API_WORKEDSHIFT_LOCATIONID_NOT_EXIST, API_LOG_NOT_FOUND_RECORD_CODE));
          // }
          $checkindata = UserWorkedTimeTable::where('user_id',$input['user_id'])
          ->where('time_zone', $input['time_zone'])
          ->whereNotNull('clock_in_time')
          ->whereNull('clock_out_time')
          ->first();
          if(null == $checkindata || '' == $checkindata){
            Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . API_WORKEDSHIFT_CHECKOUT_NULL_CHECK);
            return Response()->json(APIResponseManager::getError(API_WORKEDSHIFT_CHECKOUT_NULL_CHECK, API_LOG_NOT_FOUND_RECORD_CODE));
          } else{
            $data['clock_out_time'] = Carbon::now()->timezone($input['time_zone'])->format('Y-m-d H:i:s');
            $checkIn = UserWorkedTimeTable::where('id', $checkindata->id)->update($data);
            if ($checkIn != null && $checkIn != "") {
              $checkIn = UserWorkedTimeTable::find($checkindata->id)->makeVisible(['created_at', 'updated_at']);
              $checkIn['created_at']= Utils::utcDateToTimezoneDateConverting(null, $input['time_zone'],$checkIn['created_at']);
              $checkIn['updated_at']= Utils::utcDateToTimezoneDateConverting(null,  $input['time_zone'],$checkIn['updated_at']);
              Log::info(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::End');
              return APIResponseManager::getResult($checkIn);
            } else {
              Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::' . WORKEDSHIFT_API_CREATE_ERROR);
              return Response()->json(APIResponseManager::getError(WORKEDSHIFT_API_CREATE_ERROR, API_LOG_INTERNAL_SERVER_ERROR_CODE));
            }
          }
        }
      } catch (Exception $ex) {
        Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiWorkedShiftsController::checkOut::');
        throw new Exception($ex);
      }
    });
    return $result;
  }
}
