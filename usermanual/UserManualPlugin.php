<?php
namespace Craft;

class UserManualPlugin extends BasePlugin
{

	function getName()
	{
		$pluginName         = Craft::t('User Manual');
		$pluginNameOverride = $this->getSettings()->pluginNameOverride;

		return ($pluginNameOverride) ? $pluginNameOverride : $pluginName;
	}

	function getVersion()
	{
		return '1.0.0';
	}

	function getDeveloper()
	{
		return 'Hill Holliday';
	}

	function getDeveloperUrl()
	{
		return 'http://hhcc.com';
	}

	function hasCpSection()
    {
        return true;
    }

	public function addTwigExtension()
	{
		Craft::import('plugins.usermanual.twigextensions.UserManualTwigExtension');
		return new UserManualTwigExtension();
	}

	public function registerCpRoutes() {
	    return array(
	      'usermanual/(?P<userManualPath>[a-zA-Z0-9\-\_\/]+)' => 'usermanual/index'
	    );
	  }

	protected function defineSettings() {
			return array(
					'pluginNameOverride'     => AttributeType::String,
					'templateOverride'       => AttributeType::String,
					'channels' 							 => array(AttributeType::Mixed, 'default' => ''),
		);
	}

	public function getSettingsHtml(){

		$options= [[
			'label' => 'Please select',
			'value' => ''
		]];

		foreach(craft()->sections->getAllSections() as $section){
			$options[] = [
				'label' => $section['name'],
				'value' => $section['id']
			];
		}

		return craft()->templates->render('UserManual/settings',array(
			'settings' => $this->getSettings(),
			'options' => $options
		));
	}

    public function onAfterInstall()
    {
        craft()->request->redirect(UrlHelper::getCpUrl('settings/plugins/usermanual/'));
    }

}
