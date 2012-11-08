<?php

namespace VojtechDobes;

use Nette;
use Nette\InvalidArgumentException;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;


/**
 * Allows definition of multiple authentication ways with unified API
 *
 * @author Vojtěch Dobeš
 */
class MultiAuthenticator extends Nette\Object implements IAuthenticator
{

	/** @var callable[] */
	private $authenticators = array();

	/** @var callable[] */
	private $decorators = array();



	/**
	 * Registers authenticator
	 *
	 * @param  string
	 * @param  IAuthenticator|callable
	 * @param  callable|NULL
	 * @return MultiAuthenticator provides a fluent interface
	 */
	public function addAuthenticator($key, $authenticator, $decorator = NULL)
	{
		if ($authenticator instanceof IAuthenticator) {
			$this->authenticators[$key] = array($authenticator, 'authenticate');
		} elseif (is_callable($authenticator)) {
			$this->authenticators[$key] = $authenticator;
		} else {
			throw new InvalidArgumentException('Authenticator must be callable or instance of IAuthenticator.');
		}
		$this->decorators[$key] = $decorator;
		return $this;
	}



	/**
	 * Tries to authenticate via authenticator named as first argument
	 *
	 * @param  array
	 * @return IIdentity
	 */
	public function authenticate(array $args)
	{
		$key = array_shift($args);

		if (!isset($this->authenticators[$key])) {
			throw new InvalidArgumentException("Authenticator named '$key' is not registered.");
		}

		$identity = call_user_func($this->authenticators[$key], $args);
		if (isset($this->decorators[$key])) {
			$identity = call_user_func($this->decorators[$key], $identity);
		}
		return $identity;
	}

}
