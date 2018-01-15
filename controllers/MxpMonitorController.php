<?php namespace Craft;

class MxpMonitorController extends BaseController
{
//    protected $allowAnonymous = array('actionIndex');
    protected $allowAnonymous = true;
    
    
    private function authorise() {
        $settings = $this->getSettings();
    
        $key = craft()->request->getParam('key');
    
        if (!$settings->key || $key != $settings->key) {
           return false;
        }
        return true;
    }
    
    
    public function actionErrorLog() {
    
    }
    
    
	public function actionIndex()
	{
        if ($this->authorise() === false) {
            $this->redirect('404');
        }

        $updates = null;

        try
        {
            $updates = craft()->updates->getUpdates(true);
        }
        
        catch (EtException $e)
        {
            if ($e->getCode() == 10001)
            {
                $this->returnErrorJson($e->getMessage());
            }
        }
        
        if ($updates)
        {
            $response = $updates->getAttributes();
            $response['allowAutoUpdates'] = craft()->config->allowAutoUpdates();

            
            $this->returnJson($response);
            
        }
        else
        {
            $this->returnErrorJson(Craft::t('Could not fetch available updates at this time.'));
        }
	}

    public function getSettings() {
        if (!$plugin = craft()->plugins->getPlugin('mxpmonitor')) {
            die('Could not find the plugin');
        }
        return $plugin->getSettings();
    }
    
    public function actionUpdates() {
        
        if ($this->authorise() === false) {
            $this->redirect('404');
        } else {
            $updates = craft()->updates->getUpdates(true);
    
            $response = $updates->getAttributes();
            return $this->returnJson($response);
        }
    }
    
    public function actionSales() {
        if ($this->authorise() === false) {
            $this->redirect('404');
        } else {
         $test = $this->returnJson(craft()->mxpMonitor_import->completedOrders());
        }
    }
}
