<?php

namespace VojtechDobes;

use Nette;
use Nette\DI;

if (!class_exists('Nette\DI\CompilerExtension')) {
	class_alias('Nette\Config\CompilerExtension', 'Nette\DI\CompilerExtension');
}


/**
 * @author Vojtěch Dobeš
 */
class MultiAuthenticatorExtension extends Nette\DI\CompilerExtension
{

	/** @var array */
	private $defaults = array();



	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();

		$authenticator = $container->addDefinition('authenticator')
			->setClass('VojtechDobes\MultiAuthenticator');

		foreach ($this->getConfig($this->defaults) as $method => $implementation) {
			$this->compiler->parseServices($this->containerBuilder, array(
				'services' => array(
					$this->prefix($method) => $implementation,
				),
			));
			$container->getDefinition($this->prefix($method))
				->setAutowired(FALSE);
			$authenticator->addSetup('addAuthenticator', array(
				$method,
				$this->prefix('@' . $method),
			));
		}
	}

}
