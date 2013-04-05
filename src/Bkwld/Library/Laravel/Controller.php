<?php namespace BKWLD\Library\Laravel;

class Controller {
	
	/**
	 * Create a new instance of a controller using it's routing name.  
	 * This takes into account a bundle in the route.
	 * $controller - i.e. 'admin.projects'
	 */
	static public function resolve_with_bundle($controller) {
		list($bundle_name, $controller_path) = preg_match('#(.+)::(.+)#', $controller, $matches) ? 
			array($matches[1], $matches[2]) : 
			array(DEFAULT_BUNDLE, $controller);
		return \Laravel\Routing\Controller::resolve($bundle_name, $controller_path);
	}
	
}