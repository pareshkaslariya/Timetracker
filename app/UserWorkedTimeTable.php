<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class UserWorkedTimeTable extends Model
{
    
    protected $fillable = [
        'user_id', 'time_zone',
    ];


      /**
  * @author : ### ###
  *
  * Method name: apiValidateCheck
  * Define for validate role data.
  *
  * @param  {array} data - The data is array of work shift
  * @return  array object of validate work shift
  */
  public static function apiValidateCheck($data) {
    $rule = array(
      'user_id'=>'required|numeric',
      'time_zone' => 'required',
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'numeric' => ':attribute must be a number.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'user_id' =>ucfirst('user_id'),
      'time_zone'=>ucfirst('time_zone'),
    ));
    return $data;
  }
}
