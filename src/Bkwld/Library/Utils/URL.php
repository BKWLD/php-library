<?php namespace Bkwld\Library\Utils;

/**
 * Utilties for deling with urls
 */
class URL {

	/**
	 * Return a target="_blank" only if a url is external
	 *
	 * @param string $url
	 * @param string $host
	 * @return string
	 */
	public static function autoTarget($url, $host = null) {

		// If URL doesn't begin with http, then just return it
		if (!preg_match('#^http#', $url)) return '_self';

		// Determine the current host
		if (!$host && function_exists('app')) $host = app('request')->getHost();
		else if (!$host) $host = $_SERVER['SERVER_NAME'];

		// If the host is in the URL, self, otherwise blank
		if (preg_match('#'.preg_quote($host).'#', $url)) return '_self';
		else return '_blank';
	}

	/**
	 * Remove a query parameter from a URL
	 * @param string $url 
	 * @param string $key
	 * @return string The URL without the query parameter
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
	 * @return string
	 */
	public static function buildUrl($parts) {
		$url = $parts['scheme'].'://';
		if (!empty($parts['user'])) $url .= $parts[$user];
		if (!empty($parts['user']) && !empty($parts['pass'])) $url .= ':'.$parts[$pass];
		if (!empty($parts['user'])) $url .= '@';
		$url .= $parts['host'];
		if (!empty($parts['port']) && $parts['port'] != 80) $url .= ':80';
		if (!empty($parts['path'])) $url .= $parts['path'];
		if (!empty($parts['query'])) $url .= '?'.$parts['query'];
		if (!empty($parts['fragment'])) $url .= '#'.$parts['fragment'];
		return $url;
	}
	
	/**
	 * Stripping the current domain (and protocol) from a URL
	 * 
	 * @param string $url
	 * @param string $host
	 * @return string
	 */
	public static function urlToAbsolutePath($url, $host = null) {
		if (!$host && function_exists('app')) $host = app('request')->getHost();
		else if (!$host) $host = $_SERVER['SERVER_NAME'];
		return preg_replace('#^[^/]*//(www\.)?'.str_replace('www.', '', preg_quote($host)).'#', '', $url);
	}

}