<?php namespace Bkwld\Library\Laravel;

// Deps
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * This class contains the logic for HTML Macros seperated from their actual
 *  assignment as HTML Macros
 */
class Macros {
	
	/**
	 * @var ResponseFactory
	 */
	protected $factory;

	/**
	 * DI
	 */
	function __construct(ResponseFactory $factory) {
		$this->factory = $factory;
	}

	/**
	 * Assign all macros to the response factory
	 * 
	 * @return void
	 */
	public function register() {
		$this->factory->macro('title', 'Bkwld\Library\Utils\Html::title');
		$this->factory->macro('meta', 'Bkwld\Library\Utils\Html::meta');
		$this->factory->macro('body', 'Bkwld\Library\Utils\Html::body');
		$this->factory->macro('tag', 'Bkwld\Library\Utils\Html::tag');
		$this->factory->macro('vimeo', 'Bkwld\Library\Utils\Html::vimeo');
		$this->factory->macro('youtube', 'Bkwld\Library\Utils\Html::youtube');
		$this->factory->macro('gravatar', 'Bkwld\Library\Utils\Html::gravatar');
		$this->factory->macro('grunt', 'Bkwld\Library\Utils\Html::grunt');
	}
	
}