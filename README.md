## For Nette Framework

Allows definition of multiple authentication ways with unified API (for Nette Framework)

##### License

New BSD

##### Dependencies

Nette 2.0 or newer

## Installation

1. Get the source code from Github or via Composer (`vojtech-dobes/nette-multi-authenticator`).
2. Register `VojtechDobes\MultiAuthenticatorExtension` as DI extension.
    1. In Nette 2.0, in your bootstrap:
    ```php
    $configurator->onCompile[] = function ($configurator, $compiler) {
        $compiler->addExtension('authentication', new VojtechDobes\MultiAuthenticatorExtension);
    };
    ```

    2. In Nette 2,1, in your configuration file in `extensions` section:
    ```neon
    authentication: VojtechDobes\MultiAuthenticatorExtension
    ```

Then you should register your authenticators:

```neon
authentication:
	db: DatabaseAuthenticator( @dibi )
	twitter: TwitterAuthenticator( )
	facebook: @facebookAuthenticator
```

In extension's section of config file, all you have to do is listing of possible authentication methods with corresponding implementation. You can use these formats:

- `@service`
- `ClassName( arguments, ... )`

You can also register plain callbacks as authentication methods as well - for example in `app/bootstrap.php`.

```php
$container->authenticator->addAuthenticator('debug', function ($username, $password) {
	if ($username === 'test' && $password === ***) {
		return new Nette\Security\Identity('debug');
	}
});
```

## Usage

For authentication, you use `$user` as always, with the only difference: you have to pass authentication method's name as first argument:

```php
$user->login('db', 'marek', ***);
```

```php
$user->login('debug', 'test', ***);
```

Etc.
