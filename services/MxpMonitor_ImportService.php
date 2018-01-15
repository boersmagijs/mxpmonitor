<?php

namespace Craft;

class MxpMonitor_ImportService extends BaseApplicationComponent {
    
    
    // orders block
    public function completedOrders() {
        $plugin = craft()->plugins->getPlugin('commerce', false);
        
        if ($plugin) {
            return $this->countOrders();
        } else {return 'Geen commerce';}
    }
    
    
    private function countOrders() {
        
        $today = date('Y-m-d',strtotime(new DateTime('today')));
        $yesterday = date('Y-m-d',strtotime(new DateTime('yesterday')));
        
        $fromDate = '> ' . $yesterday . ' 00:00:00';
        $toDate = '<' . $today . ' 23:59:59';
        
        $criteria = craft()->elements->getCriteria('Commerce_Order');
        $criteria->completed = true;
        $criteria->dateOrdered = array( 'AND', 'NOT NULL', $fromDate, $toDate );
        $criteria->limit = null;
        $results = $criteria->find();
        
        $soldItems = count($results);
        
        return $soldItems;
    }
    
}