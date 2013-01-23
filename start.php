<?php

// Add all classes to the Laravel autoloader
Autoloader::namespaces(array(
    'BKWLD' => Bundle::path('bkwld'),
));

// Load simple, non-class based Laravel utilitis
require_once(Bundle::path('bkwld').'Laravel/helpers.php');
require_once(Bundle::path('bkwld').'Laravel/validators.php');

// Make the constants class easier to use
class_alias('\BKWLD\Utils\Constants', 'Constants');