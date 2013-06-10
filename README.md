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
	* [ ] Filters
		* [ ] csrf()
	* [ ] Former
		* [ ] assoc_array_for_radios()
	* [ ] Input
		* [ ] json_or_input()
		* [ ] json_and_input()
		* [ ] remove()
	* [x] Macros
	* [ ] Model
		* [ ] eloquent_to_array()
		* [ ] ids()
		* [ ] paginate()
		* [ ] count()
	* [ ] Validator
		* [ ] unique_with()
		* [ ] require_just_one()
* [ ] Utils
	* [x] Collection
	* [X] Constants
	* [x] File
	* [ ] Html
	* [x] String

## Installation

1. Add to your composer.json's requires: `"bkwld/library": "~2.0"`.  Then do a regular composer install.
2. Add as a provider in your app/config/app.php's provider list: `'Bkwld\Library\LibraryServiceProvider',`

## Usage

### API

TODO

### Laravel

TODO

### Utils

TODO