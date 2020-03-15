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

        return $timeDiff;
    }
}