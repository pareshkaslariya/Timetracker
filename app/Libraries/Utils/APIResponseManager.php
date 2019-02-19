<?php

namespace App\Libraries\Utils;

/**
 * @author : Meet parikh
 * Created on : #### ####
 * Create class for return response to api
 *
 */
class APIResponseManager
{

    /**
     * @author : Meet parikh
     * Created on : #### ####
     *
     * Create static variable.
     */
    public static $errorResponse = array();
    public static $successResponse = array();

    /**
     * @author : Meet parikh
     * Created on : #### ####
     *
     * Method name: getError
     * @param1 {string} message - The error massage of response.
     * @param2 {int} code - The error code of response.
     * @return error object.
     */
    public static function getError($message, $code)
    {
        self::$errorResponse['error']['message'] = $message;
        self::$errorResponse['error']['code'] = $code;
        return self::$errorResponse;
    }

    /**
     * @author : Meet parikh
     * Created on : #### ####
     *
     * Method name: getResult
     * @param1 {string} $data - The object of response.
     * @return success object.
     */
    public static function getResult($data, $code = null)
    {
        if ($code === null) {
            self::$successResponse = $data;
        } else {
            self::$successResponse['Success']['message'] = $data;
            self::$successResponse['Success']['code'] = $code;
        }
        return self::$successResponse;
    }

}
