<?php

namespace Drupal\challenge_date\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\challenge_date\DateService;

/**
 * Provides a 'Challenge date' Block.
 * @Block(
 *   id = "challenge_date_block",
 *   admin_label = @Translation("Challenge date block"),
 *   category = @Translation("Challenge date block"),
 * )
 */

class ChallengeDateBlock extends BlockBase {

    public function build(){

        $node = \Drupal::routeMatch()->getParameter('node');
        $output = $node->getType();
        if($node->getType() == "event") {
            
            // get datetime value from node
            $date = $node->field_event_date->value;

            // call service method to calculate difference in days
            $days = \Drupal::service('challenge_date.date_service')->calculateDaysUntilEvent($date);
            
            // check the result of method and handle the data
            if($days >= 1){
                $output = $days . " days left until event starts.";
            }
            else if($days == 0){
                $output = "This event is happening today.";
            }
            else{
                $output = "This event already passed.";
            }
        }else {
            // display error
            $output = "This block is intended only for events.";
        }
    
          return array(
            // output
            '#markup' => $output,
            // prevent block caching
            '#cache' => [
              'max-age' => 0,
              ],
          );
    }
}