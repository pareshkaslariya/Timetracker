<?php

namespace App\Http\Controllers\Api;

use APIResponseManager;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            try {
                $validation = User::apiValidateRegister($request->all());
                if ($validation != null && $validation != "" && $validation->fails()) {
                    $logMessages = $validation->messages()->all();
                    $message = implode("<br> ", $logMessages);
                    $messages['validationMessages'] = $logMessages;
                    Log::warning(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::' . $message);
                    return Response()->json(APIResponseManager::getError($messages['validationMessages'], API_LOG_BAD_REQUEST_CODE));
                }

                $request['password'] = \Hash::make($request['password']);
                $user = User::create($request->toArray());

                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];

                // return response($response, 200);
                return APIResponseManager::getResult($response);

            } catch (Exception $ex) {
                // Log::error(API_LOG_INFO_FIRST_KEYWORD . '::ApiRegisterController::register::');
                throw new Exception($ex);
            }
        });
        return $result;
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (\Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                // return response($response, 200);
                return APIResponseManager::getResult($response);
            } else {
                $response = "Password missmatch";
                // return response($response, 422);
                return Response()->json(APIResponseManager::getError($response, API_LOG_BAD_REQUEST_CODE));

            }

        } else {
            $response = 'User does not exist';
            // return response($response, 422);
            return Response()->json(APIResponseManager::getError($response, API_LOG_BAD_REQUEST_CODE));

        }

    }

    public function logout(Request $request)
    {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        // return response($response, 200);
        return APIResponseManager::getResult($response);

    }
}
