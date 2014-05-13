<?php namespace Bkwld\Library\Utils;

// Dependencies
use BKWLD\Library\APIs\Youtube;
use Config;
use Route;
use Str;
use View;

// Utilities that assist in the generation of HTML
class Html {

	/**
	 * Format title based on section content
	 */
	static public function title() {

		// Get page name
		$title = View::yieldContent('title');
		
		// Get the site name
		$site = Config::get('site.name');

		// Make the title
		if ($site && $title) $title = $site . ' - ' . $title;
		else if ($site) $title = $site;
		
		// Render the tags
		return '<title>'.$title.'</title><meta property="og:title" content="'.$title.'" />';
	}

	/**
	 * Create standard meta and open graph meta tags
	 */
	static public function meta() {
		$html = '';
		
		// Merge passed meta data into site config
		$config = Config::get('site');
		$meta = View::yieldContent('meta');
		if (is_array($meta) && is_array($config)) $meta = array_merge($config, $meta);
		else if (!is_array($meta) && is_array($config)) $meta = $config;
		else if (!is_array($meta) && !is_array($config)) return;
		
		// Add description
		if (!empty($meta['description'])) {
			if (!empty($meta['og:description'])) $html .= '<meta name="og:description" content="'.$meta['og:description'].'"/>';
			else $html .= '<meta name="og:description" content="'.$meta['description'].'"/>';
			$html .= '<meta name="description" content="'.$meta['description'].'"/>';
		}
		
		// Keywords
		if (!empty($meta['keywords'])) {
			$html .= '<meta name="keywords" content="'.$meta['keywords'].'"/>';
		}
		
		// Done
		return $html;
		
	}

	/**
	 * Add page class to body tag
	 */
	static public function body() {

		// See if the class has already been defined
		$class = View::yieldContent('page');

		// "page is deprecated", use "body" instead, if it's defined
		if ($body = View::yieldContent('body')) $class = $body;

		// If no class was defined, deduce it
		if (!$class && $action = Route::currentRouteAction()) {
			
			// Strip restful prefixes and suffices
			preg_match('#(\w+)Controller@(?:get|post)?(\w+)#i', $action, $matches);
			
			// Make an action for missing methods
			if ($matches[2] == 'missingMethod') $matches[2] = implode(' ', Request::segments());
			
			//Combine
			$class = Str::snake($matches[1], '-').' '.Str::snake($matches[2], '-');
		}

		// Add any extra classes on
		$class .= ' '.View::yieldContent('append to body');

		// The ontouchstart fixes issues with active state on iOS
		// http://stackoverflow.com/a/8877902/59160
		return $class ? "<body class='$class' ontouchstart=''>" : '<body>';
	}

	/**
	 * Render an HTML tag ONLY if the contents are non-empty
	 * @param $content The text that goes inside the tag
	 * @param $tag The tag.  This can include attributes like "div class='farts'".  But 
	 * don't include the < or >
	 */
	static public function tag($content = null, $tag = 'p') {

		// Support arrays for content
		if (is_array($content)) {
			$html = '';
			foreach($content as $instance) $html .= self::tag($instance, $tag);
			return $html;
		}

		// Wrap the content in the tag
		$content = trim($content);
		if (empty($content)) return '';
		preg_match('#^\s*(\w+)#', $tag, $matches);
		return '<'.$tag.'>'.$content.'</'.$matches[1].'>';
	}
	
	/**
	 * Make a vimeo iframe embed from a URL to a video.  Options supports the following:
	 * id - The id of the iframe (required)
	 * class - The class of the iframe
	 */
	static public function vimeo($url, $width=500, $height=281, $options = null) {
		
		// Default options
		if (!$options) $options = array();
		$options = (object) array_merge(array(
			'id' => Str::random(8, 'alpha'),
			'class' => 'vimeo_player',
		), $options);
		
		// The video id is the last digits of the URL
		if (!preg_match('/(\d+)$/', $url, $matches)) return '';
		$id = $matches[0];
		
		// Return the assembled url
		return '<iframe id="'.$options->id.'" src="//player.vimeo.com/video/'.$id.'?portrait=0&badge=0&title=0&byline=0&color=d76b00&api=1&player_id='.$options->id.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		
	}
	
	/**
	 * Make a youtube iframe embed from a URL to a video.  Options supports the following:
	 * id - The id of the iframe
	 * class - The class of the iframe
	 */
	static public function youtube($url, $width=500, $height=281, $options = null) {
		
		// Default options
		if (!$options) $options = array();
		$options = (object) array_merge(array(
			'id' => Str::random(8, 'alpha'),
			'class' => 'vimeo_player',
			'showinfo' => 0,
			'autohide' => 1,
			'rel' => 0,
		), $options);
		
		// Build params
		$params = http_build_query(array(
			'showinfo' => $options->showinfo,
			'autohide' => $options->autohide,
			'playerapiid' => $options->id,
			'rel' => $options->rel,
		));
		
		// Parse the ID from the youtube url
		if (!($id = Youtube\URL::id($url))) return '';
		
		// Return the assembled url
		return '<iframe id="'.$options->id.'" class="'.$options->class.'" width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$id.'?'.$params.'" frameborder="0" allowfullscreen></iframe>';
	}

	/**
	 * Make a gravatar image from an email
	 */
	static public function gravatar($email) {
		return '//www.gravatar.com/avatar/'.md5(strtolower(trim($email)));
	}
	
	/**
	 * Check for a file in the dist directory and use it.  It expects a mapping json file
	 * to be at public/dist/mapping.json
	 * @param string $path An absolute path like "/js/main.js"
	 */
	static public $grunt_mapping;
	static public function grunt($path) {

		// We've already looked for the mapping file and it didn't exist
		if (self::$grunt_mapping === false) return $path;
		
		// Check if we've already loaded the mapping file
		$key = substr($path, 1); // The mapping doesn't have leading slashes
		if (!empty(self::$grunt_mapping)) {
			if (isset(self::$grunt_mapping->$key)) return '/'.self::$grunt_mapping->$key;
			return $path;
		}
		
		// Load the mapping.json
		$absolute = File::documentRoot().'/dist/mapping.json';
		if (!file_exists($absolute)) return $path;

		// Get the key from the newly loaded json
		self::$grunt_mapping = json_decode(file_get_contents($absolute));
		if (isset(self::$grunt_mapping->$key)) return '/'.self::$grunt_mapping->$key;

		// Though the mapping exists, the key doesn't, so return the path
		return $path;

	}

	
}
