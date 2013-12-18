# BKWLD PHP Library

This is a bundle designed to work with Laravel 4.0 - 4.1, but it tries to stay independent where possible.

## Contents

* APIs - Reusable components for working with 3rd party APIs like Twitter
* Laravel - Reusable components designed to work with Laravel
* Utils - General framework independent utilities

## Installation

1. Add to your composer.json's requires: `"bkwld/library": "~2.0"`.  Then do a regular composer install.
2. Add as a provider in your app/config/app.php's provider list: `'Bkwld\Library\LibraryServiceProvider',`
3. Add these validation rules:

	"file" => "The :attribute must be a file",
	"unique_with" => "The :attribute has already been taken",

## Usage

### API

#### Getting access token

You would hard code an access token into your site for cases like fetching your own Instagram feed.

- [Instagram access token helper](/oauth/instagram/access_token)

### Laravel

TODO

### Utils

TODO