<?php

namespace App\Libraries\Utils;

use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;
use Exception;
use App\Location;
use Carbon\Carbon;

class Utils {
  /* START:create utcDateToserverTimezoneDateConverting, BY:###*/

  /**
  * utcDateToserverTimezoneDateConverting method :: get string UTC date as input and convert it into based on server's TimeZone and format it
  *
  * @param  Request  $stringdate which contain string UTC date
  * @return Response which contain formated date which is convert based on server timezone
  * @return Response which contain exception error if run any
  */
  public static function utcDateToserverTimezoneDateConverting($stringdate) {
    // Log::info('Admin::Utils::utcDateToserverTimezoneDateConverting::START');
    try {
      if (null != $stringdate && '' != $stringdate) {
        $date = new DateTime($stringdate);
        //$date->setTimezone(new DateTimeZone(DATE_TIME_ZONE));
        //$formateddate = $date->format('F j, Y, g:i A(\U\T\CP)(e)');
        $formateddate = $date->format('F j, Y (e)');
        // Log::info('Admin::Utils::utcDateToserverTimezoneDateConverting::END');
        return $formateddate;
      } else {
        Log::error('Admin::Utils::utcDateToserverTimezoneDateConverting::The argument cannot be null');
        throw new Exception('The argument cannot be null!!');
      }
    } catch (Exception $ex) {
      Log::error('Admin::Utils::utcDateToserverTimezoneDateConverting' . $ex);
      throw new Exception($ex);
    }
  }


  /* START:create utcDateToserverTimezoneDateConverting, DATE:24/09/2018, BY:###*/

  /**
  * utcDateToTimezoneDateConverting method :: get string UTC date as input and convert it into gives time zone based on locationId or timezone
  *
  * @param  Request  $locationId to get timezone for conversion
  * @return Response $timeZone timezone for conversion
  * @return Response $date which contain string UTC date
  */
  public static function utcDateToTimezoneDateConverting($locationId,$timeZone,$date) {
    // Log::info('Admin::Utils::utcDateToTimezoneDateConverting::START');
    try {
      if (null != $date && '' != $date) {
        if(null != $locationId && '' != $locationId){
          $timeZone = Location::select('time_zone')->withTrashed()->find($locationId);
          if(null!=$timeZone && ''!=$timeZone){
            if(null != $timeZone['time_zone'] && '' != $timeZone['time_zone']){
              $formateddate = \Carbon\Carbon::parse($date)->timezone($timeZone['time_zone']);
              // Log::info('Admin::Utils::utcDateToTimezoneDateConverting::END');
              return $formateddate;
            }
            else {
              Log::error('Admin::Utils::utcDateToTimezoneDateConverting::The argument cannot be null');
              throw new Exception('The argument cannot be null!!');
            }
          }
          else {
            Log::error('Admin::Utils::utcDateToTimezoneDateConverting::The argument cannot be null');
            throw new Exception('The argument cannot be null!!');
          }
        }else if(null != $timeZone && '' != $timeZone){
          $formateddate = \Carbon\Carbon::parse($date)->timezone($timeZone);
          // Log::info('Admin::Utils::utcDateToTimezoneDateConverting::END');
          return $formateddate;
        }
        else {
          Log::error('Admin::Utils::utcDateToTimezoneDateConverting::The argument cannot be null');
          throw new Exception('The argument cannot be null!!');
        }
      } else {
        Log::error('Admin::Utils::utcDateToTimezoneDateConverting::The argument cannot be null');
        throw new Exception('The argument cannot be null!!');
      }
    } catch (Exception $ex) {
      Log::error('Admin::Utils::utcDateToTimezoneDateConverting' . $ex);
      throw new Exception($ex);
    }
  }

  /* END */

  /**
  * utcDateToserverTimezoneDateConverting method :: get string UTC date as input and convert it into based on server's TimeZone and format it
  *
  * @param  Request  $stringdate which contain string UTC date
  * @param  Request  $locationID which contain ld of location for time zone
  * @return Response which contain formated date which is convert based on server timezone
  * @return Response which contain exception error if run any
  */
  public static function serverTimezoneDateToUtcDateConverting($locationID, $stringdate) {
    // Log::info('Admin::Utils::serverTimezoneDateToUtcDateConverting::START');
    try {
      if (null != $stringdate && '' != $stringdate && null != $locationID && '' != $locationID) {
        $timeZoneOfLoc = Location::select('time_zone')->find($locationID);
        if(null != $timeZoneOfLoc && '' != $timeZoneOfLoc) {
          if(null != $timeZoneOfLoc['time_zone'] && '' != $timeZoneOfLoc['time_zone']) {
            $timeZone = $timeZoneOfLoc['time_zone'];
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stringdate, $timeZone);
            $formateddate = $date->setTimezone('UTC');
            // Log::info('Admin::Utils::serverTimezoneDateToUtcDateConverting::END');
            return $formateddate;
          }
        }
      } else {
        Log::error('Admin::Utils::serverTimezoneDateToUtcDateConverting::The argument cannot be null');
        throw new Exception('The argument cannot be null!!');
      }
    } catch (Exception $ex) {
      Log::error('Admin::Utils::serverTimezoneDateToUtcDateConverting' . $ex);
      throw new Exception($ex);
    }
  }
}
