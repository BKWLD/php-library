<?php namespace Bkwld\Library\Utils;

/**
 * Utilties for deling with urls
 */
class URL {

	/**
	 * Remove a query parameter from a URL
	 * @param string $url 
	 * @param string $key
	 */
	public static function unsetParam($url, $key) {
		$parts = parse_url($url);
		if (empty($parts['query'])) return $url;
		parse_str($parts['query'], $params);
		unset($params[$key]);
		$parts['query'] = http_build_query($params);
		return self::buildUrl($parts);
	}

	/**
	 * Build a URL, using an array like parse_url returns
	 * @param array $parts
	 */
	public static function buildUrl($parts) {
		$url = $parts['scheme'].'://';
		if (!empty($parts['user'])) $url .= $parts[$user];
		if (!empty($parts['user']) && !empty($parts['pass'])) $url .= ':'.$parts[$pass];
		if (!empty($parts['user'])) $url .= '@';
		$url .= $parts['host'];
		if (!empty($parts['port']) && $parts['port'] != 80) $url .= ':80';
		$url .= $parts['path'];
		if (!empty($parts['query'])) $url .= '?'.$parts['query'];
		if (!empty($parts['fragment'])) $url .= '#'.$parts['fragment'];
		return $url;
	}

}