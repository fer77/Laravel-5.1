## 1
**Overview**
* Code _MUST_ follow a “coding style guide” **PSR [PSR-1]**.
* Code _MUST_ use 4 spaces for indenting, not tabs.
* There _MUST NOT_ be a hard limit on line length; the soft limit MUST be 120 characters; lines _SHOULD_ be 80 characters or less.
* There _MUST_ be one blank line after the namespace declaration, and there _MUST_ be one blank line after the block of use declarations.
* Opening braces for classes _MUST_ go on the next line, and closing braces _MUST_ go on the next line after the body.
* Opening braces for methods _MUST_ go on the next line, and closing braces _MUST_ go on the next line after the body.
* Visibility _MUST_ be declared on all properties and methods; abstract and final _MUST_ be declared before the visibility; static _MUST_ be declared after the visibility.
* Control structure keywords _MUST_ have one space after them; method and function calls _MUST NOT_.
* Opening braces for control structures _MUST_ go on the same line, and closing braces _MUST_ go on the next line after the body.
* Opening parentheses for control structures _MUST NOT_ have a space after them, and closing parentheses for control structures _MUST NOT_ have a space before.

## 2

Laravel resolves your services directly from your _blade_ view.
```php
Route::get('/', function(App\Stats $stats) {
	return view('welcome', compact('stats'));
});
```

```php
Route::get('other', function(App\Stats $stats) {
	return view('other', compact('stats'));
});
```
This, however, gets too verbose. Having to keep passing `App\Stats $stats` to every view that needs this _service class_.

One solution is to create a _view composer_:
```php
View::composer('stats', function($view) {
	$view->with('stats', app('App\Stats'));
});
```
```php
Route::get('/', function() {
	return view('welcome');
});
```

```php
Route::get('other', function() {
	return view('other');
});
```

The new solution is to inject your _view composer_ directly into our view:


* .blade.php:

_Add this to your blade file_

`@inject('stats', 'App\Stats')`


* routes.php:

_remove our view composer and_

```php
Route::get('/', function() {
	return view('welcome');
});
```

```php
Route::get('other', function() {
	return view('other');
});
```

## 3

**Elixir** now compiles and concatenates seperate .css/.js files.

```javascript
elixir(function(mix) {
	mix.less(['app.less', 'other.less']);
});
```

now makes one _app.css_ file.

**Elixir** also provides _ECMS6_ support.

```javascript
elixir(function(mix) {
	mix.scripts(['one.js', 'two.js']);
});
```

now makes one _all.js_ file.  It can also be placed somewhere else:

```javascript
elixir(function(mix) {
	mix.scripts(['one.js', 'two.js'
	], 'public/foo/bar.js');
});
```

Will save it to `public/foo/bar.js`.  **Elixir** will also run your _ECMS6_ through the _Babel_ compiler.

```javascript
elixir(function(mix) {
	mix.babel(['one.js', 'two.js'
	]);
});
```

Just switch _scripts_ with _babel_.

## 4

Most of the integrated API has now been integrated into Laravel 5.1.
Remember tha in `composer.json` there are third party libraries we have acces to:


1. _faker_: generates dummy data.

2. _mockery_: for mocking classes. 

```json
"require-dev": {
        "fzaninotto/faker": "~1.4",
        "mockery/mockery": "0.9.*",
        "phpunit/phpunit": "~5.7"
    },
```

This will run _phpunit_ when a test or file within the app directory is changed.

`/Feature/ExampleTest.php` For larger features.
`Unit/ExampleTest.php` lower level features.

run `vendor/bin/phpunit tests/Feature/ExampleTest.php`

Each of these represent functionality that we can import into our test.
```php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
```

## 5

The **Faker** library gives us a random name, email, address...(reffer to faker documentation).

`factory` magic function, dynamic in the arguments you pass to it:
`php artisan tinker`:
`factory('App\User')->make();` creates a factory for a user without persisting data to the database.
Each user will be random each time `factory('App\User', 5)->make();`.
If we want to persist these random users `factory('App\User', 5)->create();`

We add this to our `DatabaseSeeder.php`

```php
use App\User;

public function run()
    {
    	User::truncate();
        factory(User::class, 50)->create();
    }
```

## 6

`php artisan make:console <name>` is `php artisan make:command <name>` in Laravel 5.4

This command can be and it will prepopulate the file: `php artisan make:command ShowGreeting --command="laracasts:greeting {name}"`

## 7

`make:event` creates a new event class, `event:generate` generates the missing events and listeners based on registration of the new event class.

```php
...
protected $listen = [
	'App\Events\RegisterUser' => [
	...
	],
];
...
```

## 8 

For middleware parameters add a colon and a comma seperated list of parameters  `'... admin:JaneDoe,param1,param2' ...`  These will then be passed through to your 'handle' method in your middleware  `... public function handle($request, Closure $next, $adminName, $param1, $param2) ...`

## 9 

`php artisan route:list` Shows a list of the app's registered routes (routes.php).

We can group routes:

```php
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', function () {
	    return view('welcome');
	});
});
```

And namespace them as well:

```php
Route::group(['prefix' => 'admin', 'as' => 'Admin.'], function() {
	Route::get('/', function () {
	    return view('welcome');
	});
});
```

## 11

**Thtottle Logins** records everytime a user fails an attempt to loging, keeping a counter.  After too many tries it locks an account temporarily.
The controller that handles this is already included in Laravel 5.1, but the views can be found in the documentation, simple copy paste of the routes or a php artisan command in 5.4 will add them.

## 12

`app/Providers/EventServiceProvider.php`  contains an array of events that we want to listen for.

```php
protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];
```

Then run `php artisan event:generate` to scan the previous array and and generate an Events/<ClassName> and a Listener.

If you want a single listener to handle multiple events do this:

```php
protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener@<methodname>',
        ],
    ];
```

To broadcast these events client-side:

1. `config/broadcasting.php`
2. Add `BROADCAST_DRIVER`
3. `implements ShouldBroadcast` to our `UserHasRegistered` class.

_remember that Laravel serialies thigs so we can interact with them_

## 13

Within the `AuthServiceProvider` we can define rules and restrictions for certain actions, like updating posts.
Within the `PostsController` we can reference the `Gate` facade and allow or deny tasks defined in the `AuthServiceProvider`.
In the view if authorisation needs to be performed use blades's `@can` or `@cannot`.

## 14

