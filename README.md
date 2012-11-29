# BKWLD PHP Library

This is a bundle designed to work with Laravel.  It contains shared utility functions.  And probably more in the future.

## Contents

* Utils - General framework independent utilities
* Laravel - Reusable components designed to work with Laravel
* Underscore - A copy of [Underscore.php](http://brianhaveri.github.com/Underscore.php/).  Note, I had to namespace it to BKWLD and you can only use it [non-statically](https://github.com/brianhaveri/Underscore.php/issues/4) so it's utility is somewhat compromised.  Calls look like this: `BKWLD\__($tasks)->filter(function($task) { return preg_match('#\w+\.php#', $task); });`. 