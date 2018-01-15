<?php namespace Craft;

class MxpMonitorPlugin extends BasePlugin
{
	public function getName()
	{
		return 'Mediaxplain Monitor';
	}

	public function getVersion()
	{
		return '1.0.2';
	}

	public function getDeveloper()
	{
		return 'Mediaxplain';
	}

	public function getDeveloperUrl()
	{
		return 'http://mediaxplain.nl';
	}

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/boersmagijs/mxpmonitor/master/releases.json';
    }

	public function registerSiteRoutes()
	{
		return array(
			'mxp/monitor' => array('action' => 'mxpMonitor/index'),
            'mxp/monitor/updates' => array('action' => 'mxpMonitor/updates'),
            'mxp/monitor/sales' => array('action' => 'mxpMonitor/sales'),
		);
	}

    /**
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'key' => array(
                AttributeType::String,
                'required' => true
            ),
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render('mxpmonitor/_settings', array(
            'settings' => $this->getSettings()
        ));
    }
}
