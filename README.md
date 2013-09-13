# BKWLD PHP Library

This is a bundle designed to work with Laravel but it tries to stay independent where possible.

## Contents

* APIs - Reusable components for working with 3rd party APIs like Twitter
* Laravel - Reusable components designed to work with Laravel
* Utils - General framework independent utilities

### Laravel 4 refactor status

My plan is to refactor things as I run across dependencies on them in other libraries.

* [ ] Api
	* [ ] Facebook
	* [ ] Instagram
	* [ ] Twitter
	* [ ] Youtube
* [ ] Laravel
	* [x] Filters
		* [x] csrf()
	* [x] Former
		* [x] assoc_array_for_radios()
	* [x] Input
		* [x] json_or_input()
		* [x] json_and_input()
		* [x] remove()
	* [x] Macros
	* [ ] Model
		* [ ] eloquent_to_array()
		* [ ] ids()
		* [ ] paginate()
		* [ ] count()
	* [x] Validator
		* [x] unique_with()
		* [x] require_just_one()
* [ ] Utils
	* [x] Collection
	* [X] Constants
	* [x] File
	* [ ] Html
	* [x] String

## Installation

1. Add to your composer.json's requires: `"bkwld/library": "~2.0"`.  Then do a regular composer install.
2. Add as a provider in your app/config/app.php's provider list: `'Bkwld\Library\LibraryServiceProvider',`
3. Add these validation rules:

	"file" => "The :attribute must be a file",
	"unique_with" => "The :attribute has already been taken",

## Usage

### API

#### Instagram

##### Getting an `access_token`

1. Register a "client" from Instagram's development portal.  The `redirect_uri` can just be the homepage (if so, make sure you add a trailing slash).
2. Make sure you have a valid /app/config/instagram.php file.
3. `php artisan instagram:oauth-url`
4. Go to the URL that is returned in your browser, signing in.  When the page redirects to your `redirect_uri`, note the `code` that is passed in the GET params.
5. `php artisan instagram:access-token CODE` where "CODE" is the code from the previous step.  The response should have your access token.

### Laravel

TODO

### Utils

TODO