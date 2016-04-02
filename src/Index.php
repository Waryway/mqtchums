<?php
namespace mqtchums;
require_once  '..'. DIRECTORY_SEPARATOR . 'vendor'. DIRECTORY_SEPARATOR . 'autoload.php';

\mqtchums\config\Configuration::WEBSITE_NAME;

class Index
{

	use \WarywayWebsiteTemplate\traits\Page;
	
	protected function Configure()
	{
		$this->setPageName('MQTCHUMS');
	}
	
	
	protected function RenderBodyContent()
	{		
		return 'Welcome to MQTCHUMS.org!';
	}
}
new Index();
?>