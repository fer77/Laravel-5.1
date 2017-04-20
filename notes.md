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

**Elixir** now compiles and concatenates seperate .css .js files.

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