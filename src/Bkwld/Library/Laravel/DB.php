<?php namespace Bkwld\Library\Laravel;

// Deps
use DateTime;
use DB as LaravelDB;

class DB {

	/**
	 * Sync up the MySQL timezone with the App timezone.  This assumes
	 * the timezone has already been applied, like if this is run from
	 * app/start/global.php
	 * http://stackoverflow.com/a/14659312/59160
	 *
	 * @return void
	 */
	static public function syncTimezone() {
		$n = new DateTime();
		$h = $n->getOffset()/3600;
		$i = 60*($h-floor($h));
		$offset = sprintf('%+d:%02d', $h, $i);
		LaravelDB::statement("SET time_zone='$offset'");
	}
}
