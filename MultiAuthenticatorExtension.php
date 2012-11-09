<?php

namespace VojtechDobes;

use Nette;
use Nette\Config\CompilerExtension;
use Nette\DI;


/**
 * @author Vojtěch Dobeš
 */
class MultiAuthenticatorExtension extends CompilerExtension
{

	/** @var array */
	private $defaults = array();



	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();

		$authenticator = $container->addDefinition('authenticator')
			->setClass('VojtechDobes\MultiAuthenticator');

		foreach ($this->getConfig($this->defaults) as $method => $implementation) {
			if ($implementation instanceof \stdClass) {
				$implementation = new DI\Statement(
					$implementation->value,
					$implementation->args ?: array()
				);
			}
			$authenticator->addSetup('addAuthenticator', array(
				$method,
				$implementation,
			));
		}
	}

}
