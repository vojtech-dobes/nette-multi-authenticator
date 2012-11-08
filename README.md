## For Nette Framework

Allows definition of multiple authentication ways with unified API (for Nette Framework)

##### License

New BSD

##### Dependencies

Nette 2.0.0

## Installation

1. Get the source code from Github or via Composer (`vojtech-dobes/nette-multi-authenticator`).
2. Register `VojtechDobes\MultiAuthenticator` as service in your configuration.


```neon
services:
	authenticator:
		class: VojtechDobes\MultiAuthenticator
		setup:
			- addAuthenticator( db, DatabaseAuthenticator( ) )
			- addAuthenticator( twitter, TwitterAuthenticator( ) )
			- addAuthenticator( facebook, FacebookAuthenticator( ) )
```

## Usage

```php
$user->login('database', 'marek', ***);
```

All you have to do is to register all necessary authenticators in config via `setup` field. `addAuthenticator` method accepts two arguments: first is identificator of authentication method, second is the instance. It can be also plain callback (when registering for example in `bootstrap.php`);
