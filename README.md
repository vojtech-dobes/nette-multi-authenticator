## For Nette Framework

Allows definition of multiple authentication ways with unified API (for Nette Framework)

##### License

[New BSD](http://choosealicense.com/licenses/bsd-3-clause/)

##### Dependencies

Nette 2.0 or newer

## Installation

None, really :).

## Usage

Write your authenticators, but don't make them implement `Nette\Security\IAuthenticator`. On the other hand, request `Nette\Security\User` service as dependency.

```php
class CredentialsAuthenticator
{

    /** @var Nette\Security\User */
    private $user;
    
    public function __construct(Nette\Security\User $user)
    {
        $this->user = $user;
    }

}
```

Now write your login method. Be creative!

```php
public function login($username, $password)
{
    // ... your logic
    
    $this->user->login(new Identity( ... ));
}
```

Register your authenticator as service:

```neon
services:
    - CredentialsAuthenticator
```

And you're done.

For authentication, you should use the specific authenticator:

```php
class SignPresenter extends Nette\Application\UI\Presenter
{

    /** @var CredentialsAuthenticator @inject */
    public $credentialsAuthenticator;

    // ...
    
    public function processLoginForm($form)
    {
        $values = $form->getValues();
        $this->credentialsAuthenticator->login($values->username, $values->password);
    }

}
```

The point is: use normal dependencies and wrap `Nette\Security\User` in them, not the other way around.
