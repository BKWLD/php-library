<?php namespace Bkwld\Library\Laravel;

/**
 * This class contains the logic for HTML Macros seperated from their
 * actual assignment as HTML Macros, to make them more testable
 */
class Macros {
	
	/**
	 * Assign all macros to the HtmlBuilder.  Not using the static method
	 * "HTML::macro()" since, when running this through unit tests, the 
	 * facade doesn't exist.  Instead, I expect a reference to current app
	 * instance to be passed
	 * @param  \Illuminate\Foundation\Application  $app 
	 */
	public static function register($app) {
		$html = $app->make('html');
		$html->macro('vimeo', 'Bkwld\Library\Utils\Html::vimeo');
		$html->macro('youtube', 'Bkwld\Library\Utils\Html::youtube');
		$html->macro('gravatar', 'Bkwld\Library\Utils\Html::gravatar');
	}
	
}