<?php

// Add all classes to the Laravel autoloader
Autoloader::namespaces(array(
    'BKWLD' => Bundle::path('bkwld'),
));

// Add specific dependencies to the Autoloader
Autoloader::map(array(
	'TwitterOAuth' => Bundle::path('bkwld').'/APIs/Twitter/twitteroauth/twitteroauth/twitteroauth.php'
));

// Load simple, non-class based Laravel utilitis
require_once(Bundle::path('bkwld').'Laravel/helpers.php');
require_once(Bundle::path('bkwld').'Laravel/Validator.php');

// Make the constants class easier to use
class_alias('\BKWLD\Utils\Constants', 'Constants');