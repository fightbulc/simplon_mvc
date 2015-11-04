# Components

## Registry

Registry does what it says: it registers aspects of the component which allow to interact with it from the outside. In particular these are `events` and `routes`. A component should register at least either events or a route.

```php
<?php

namespace App\Components\Auth;

use Simplon\Mvc\Interfaces\ComponentEventsInterface;
use Simplon\Mvc\Interfaces\ComponentRegistryInterface;
use App\Components\Auth\Controllers\AuthController;
use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Routes\Route;

/**
 * Class AuthRegistry
 * @package App\Components\Auth
 */
class AuthRegistry implements ComponentRegistryInterface
{
    const COMPONENT_NAME = 'Auth';

    /**
     * @param Mvc $mvc
     *
     * @return ComponentEventsInterface
     */
    public function registerEvents(Mvc $mvc)
    {
        return new AuthEvents($mvc);
    }

    /**
     * @return Route[]
     */
    public function registerRoutes()
    {
        return [
            new Route(AuthRoutes::PATTERN_SIGN_IN, AuthController::class, 'signIn'),
            new Route(AuthRoutes::PATTERN_SIGN_OUT, AuthController::class, 'signOut'),
        ];
    }
}
```

## Events

Events allow to interact with other components. Components can either hook into `push events` or can expose `pull events` which allow to pull data in a direct way from a given component. Push events should be defined as a `const` within the event pushing component. Other components can register to this event as seen below within `registerPushes()`.

`Pull events` are used to retrieve data from another component without the need of knowing anything about it apart from the name of the `pull event name`. These events are exposed within `registerPulls()`.

It is necessary to have a look at a component's event class to see what parameters are required.

```php
<?php

namespace App\Components\Auth;

use App\Components\Auth\Data\UserDetailsData;
use App\Components\Settings\SettingsEvents;
use Simplon\Mvc\Interfaces\ComponentEventsInterface;
use Simplon\Mvc\Utils\Events\PushEvent;
use Simplon\Mvc\Utils\Events\PullEvent;

/**
 * Class AuthEvents
 * @package App\Components\Auth
 */
class AuthEvents implements ComponentEventsInterface
{
    use AuthContextTrait;

    // set available component events as const

    const PULL_USER_SESSION = 'user_session';
    const PULL_USER_DETAILS = 'user_details';

    // register listeners for other component events

    /**
     * @return PushEvent[]|null
     */
    public function registerPushes()
    {
        return [
            new PushEvent(SettingsEvents::PUSH_USER_DETAILS_UPDATE, function ($userModel)
            {
			   		// do something here
            }),
        ];
    }

    // register requests for other components

    /**
     * @return PullEvent[]
     */
    public function registerPulls()
    {
        return [
            new PullEvent(self::PULL_USER_SESSION, function ()
            {
			   		// do something here
            }),

            new PullEvent(self::PULL_USER_DETAILS, function ($userId)
            {
			   		// do something here
            }),
        ];
    }
}
```

### Examples

Imagine a `settings component` which has a form to update a user's data. First we need to pull the actual user data to populate it in the form.

#### Pull data

Since the `auth component` is taking care of all our user data we ask it for the data.

```php
$userModel = $this->getEvent()->pull(
	App\Components\Auth\AuthEvents::PULL_USER_DETAILS,
	['123ABC'] // user id
);
```

#### Push data

Imagine now that the user entered the new data in the form and all has been validated. Now the settings component wants to communicate the new data back to the auth component.

```php
$this->getEvent()->push(
	App\Components\Settings\SettingsEvents::PUSH_USER_DETAILS_UPDATE,
	[$userModel] // holds new data
);
```

## Routes

Routes should hold the available patterns for a given component as well as static methods which build an individual route.

```php
<?php

namespace App\Components\Auth;

use Simplon\Mvc\Utils\Routes\RouteBuilder;

/**
 * Class AuthRoutes
 * @package App\Components\Auth
 */
class AuthRoutes extends RouteBuilder
{
    // set available route patterns as const

    const PATTERN_SIGN_IN = '/signin';
    const PATTERN_SIGN_OUT = '/signout';
    const PATTERN_USER_DETAILS = '/{locale}/user-details';

    // use methods to build routes

    /**
     * @return string
     */
    public static function toSignIn()
    {
        return self::buildUri(self::PATTERN_SIGN_IN);
    }

    /**
     * @return string
     */
    public static function toSignOut()
    {
        return self::buildUri(self::PATTERN_SIGN_OUT);
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public static function toUserDetails($locale)
    {
        return self::buildUri(self::PATTERN_USER_DETAILS, ['locale' => $locale]);
    }
}
```

## ContextTrait

Each component should own a `component context trait` which holds instances of required classes. It also inherits from the actual `app context` which in turn inherits its data from the `core context`. A component's context trait helps to expose a components `locale` or `config` data which are merged with the actual `app data`. See the example below.

```php
<?php

namespace App\Components\Auth;

use App\Components\Auth\Storages\UserSessionStorage;
use App\Components\Auth\Storages\UsersStorage;
use App\AppContextTrait;
use Simplon\Error\Exceptions\ServerException;
use Simplon\Locale\Locale;
use Simplon\Mvc\Utils\Config;

/**
 * Class AuthContextTrait
 * @package App\Components\Auth
 */
trait AuthContextTrait
{
    use AppContextTrait;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this
            ->getMvc()
            ->mergeComponentConfig(AuthRegistry::COMPONENT_NAME)
            ->getConfig();
    }

    /**
     * @return Locale
     * @throws ServerException
     */
    public function getLocale()
    {
        return $this
            ->getMvc()
            ->mergeComponentLocale(AuthRegistry::COMPONENT_NAME);
    }

    /**
     * @return UsersStorage
     */
    public function getUsersStorage()
    {
        return new UsersStorage(
            $this->getCrudManager()
        );
    }

    /**
     * @return UserSessionStorage
     */
    public function getUserSessionStorage()
    {
        return new UserSessionStorage(
            $this->getSessionStorage()
        );
    }
    
    // more methods here ...
}
```