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

Laravel allows to resolve your service directly from your _blade_ view.
`Route::get('/', function(App\Stats $stats) {
	return view('welcome', compact('stats'));
});

Route::get('other', function(App\Stats $stats) {
	return view('other', compact('stats'));
});`
It gets too verbose to have to keep passing `App\Stats $stats` to every view that needs this service class.

One solution is to create a _view composer_:
`View::composer('stats', function($view) {
	$view->with('stats', app('App\Stats'));
});
Route::get('/', function() {
	return view('welcome');
});

Route::get('other', function() {
	return view('other');
});`

The new solution is to inject your _view composer_ directly into our view:
* .blade.php:
_Add this to your blade file_
`@inject('stats', 'App\Stats')`
* routes.php:
_remove our view composer_
`Route::get('/', function() {
	return view('welcome');
});

Route::get('other', function() {
	return view('other');
});`