<?php

/*
* To change this template file, choose Tools | Templates
* and open the template in the einvoiceditor.
*/
 
define('API_LOG_INFO_FIRST_KEYWORD', 'API');
 
define('API_LOG_NOT_FOUND_RECORD_CODE', 404);

/*Employee work time Report*/
define('EMPLOYEE_WORK_TIME_EXCEL_FILE_PATH', 'upload/excel/');
define('EMPLOYEE_WORK_TIME_EXCEL_FILE_NAME', 'export_employee_work_time_report');
define('XLS_EXTENSION', 'xls');
define('EMPLOYEE_WORK_TIME_REPORT_GENERATE_SUCCESSFULL', 'Employee Work Time Report successfully generated.');
define('DATE_PERIOD_NULL', 'Date range is not valid, Please insert appropriate date range.');
define('USERS_NOT_AVAILABLE', 'Sorry, could not found user. Try again.');
define('LOCATION_TIMEZONE_NOT_GIVEN', 'Sorry, no data found time zone.');
define('NO_WORK_SHIFT_DATA', 'No data found.');
define('PERIOD_NOT_CALCULATED', 'Date range not calculated, please try again!');


/* Api WorkedShift START*/
define('WorkedShift_API_JSON_INVALID', 'Invalid JSON format.');
define('USER_ID', 'user_id');
define('CLOCK_IN_TIME', 'clock_in_time');
define('CLOCK_OUT_TIME', 'clock_out_time');
define('CREATED_AT', 'created_at');
define('UPDATED_AT', 'updated_at');
define('API_WORKEDSHIFT_USERID_NOT_EXIST', 'User is not associated with system.');
define('API_WORKEDSHIFT_LOCATIONID_NOT_EXIST', 'Location is not associated with system.');
define('WORKEDSHIFT_API_CREATE_ERROR', 'Sorry, could not checkIn. Try again.');
define('API_WORKEDSHIFT_CHECKOUT_NULL_CHECK', 'Sorry you already checked out at this location.');
define('API_WORKEDSHIFT_CHECKIN_NULL_CHECK', 'Sorry you already checked in at this location.');
define('API_WORKEDSHIFT_NO_DATA_FOUND', 'Sorry you are not clecked in at this location.');
define('API_LOG_BAD_REQUEST_CODE', '404');

/* Api WorkedShift END*/
