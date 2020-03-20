<?php

namespace Drupal\challenge_date\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\challenge_date\DateService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Routing\CurrentRouteMatch;
/**
 * Provides a 'Challenge date' Block.
 * @Block(
 *   id = "challenge_date_block",
 *   admin_label = @Translation("Challenge date block"),
 *   category = @Translation("Challenge date block"),
 * )
 */

class ChallengeDateBlock extends BlockBase implements ContainerFactoryPluginInterface{

    
    protected $serviceDate;
    protected $routeMatch;
    
    public function __construct(array $configuration, $plugin_id, $plugin_definition, DateService $serviceDate, CurrentRouteMatch $route_match) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->serviceDate = $serviceDate;
        $this->routeMatch = $route_match;
    }
    
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('challenge_date.date_service'),
          $container->get('current_route_match')
        );
    }
    public function build(){

        $output = "";
        if($node = $this->routeMatch->getParameter('node')){
            if($node->getType() == "event") {
            
            // get datetime value from node
            $date = $node->field_event_date->value;

            // call service method to calculate difference in days         
            $days = $this->serviceDate->calculateDaysUntilEvent($date);

            // check the result of method and handle the data
            if($days >= 1){
                $output = $days . t(' days left until event starts.');
            }
            else if($days == 0){
                $output = t('This event is happening today.');
            }
            else{
                $output = t('This event already passed.');
            }
            }else {
            // display error
            $output = t('This block is intended only for events.');
            }
        }
        else{
            $output = t('This block is intended only for events.');
        }
    
          return array(
            // output
            '#markup' => $output,          
          );
    }
    //overriding method to set cache to 0
    public function getCacheMaxAge() {
        return 0;
    }
}