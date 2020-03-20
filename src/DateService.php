<?php

namespace Drupal\challenge_date;

/**
 * This service is used to calculate how many days are between
 * current and given date.  
 */
class DateService {

    /**
     * Function gets the date of the event as argument. $date is the type date/time string.
     * Return value is the type of integer. 
     * If the returning value is greater than 0, that tells us how many days are left from current to following date.
     * If the returning value is equal to 0, that means that the dates are the same
     * If the returning value is less than 0, that tells us that the following date already passed and how many days ago that happened.
     */
    public function calculateDaysUntilEvent($date){
        //get current time of type Unix timestamp
        $currentTime = time();
        //convert argument to type Unix timestamp
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