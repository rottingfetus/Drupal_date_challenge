<?php

namespace Drupal\challenge_date;

class DateService {

    public function calculateDaysUntilEvent($date){
        //get current time
        $currentTime = time();
        //convert argument
        $eventTime = strtotime($date);
        //calculate time difference
        $timeDiff = $eventTime - $currentTime;
        //round it up so we get number of days
        $timeDiff = round($timeDiff / (3600 * 24));

        //check if the time difference is 0, to make sure that event is happening on the same day
        if($timeDiff == 0){
            if(date("Y-m-d", $currentTime) != date("Y-m-d",$eventTime)){
                $timeDiff = 1;
            }
        }
        return $timeDiff;
    }
}