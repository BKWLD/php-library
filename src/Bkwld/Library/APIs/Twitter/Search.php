<?php namespace Bkwld\Library\APIs\Twitter;

// Dependencies
use Cache;
use Log;
use Exception;

class Search {
	
	// Configuration
	const CACHE_ID = 'since-id-for-';
	const MAX_PAGES_PARSED = 5; // How many pages back in time to get per request
	private static $connection;
	
	/**
	 * Run a search query
	 */
	public static function rolling_search($keyword) {
		
		// Find out when the last tweet we found was
		$since_id = Cache::get(self::CACHE_ID.$keyword, 0);
		
		// Setup connection
		self::$connection = Connect::OAuth();
		
		// Run query and garbage collect
		$params = http_build_query(array(
			'q' => $keyword,
			'result_type' => 'recent',
			'count' => 100,
			'include_entities' => 1,
			'since_id' => $since_id,
		));
		$query = new self;
		$since_id = $query->fetch_page('?'.$params);
		$results = $query->results();
		unset($query);
		
		// Log the new since_id
		if ($since_id) Cache::forever(self::CACHE_ID.$keyword, $since_id);
		
		// Return the result
		return $results;
		
	}
	
	/**
	 * Get a page of results
	 */
	private $pages_returned = 0;
	private function fetch_page($params) {
		
		// Run the query
		Log::info('Executing: search/tweets.json'.$params);
		$response = self::$connection->get('search/tweets.json'.$params);
		
		// Check for errors
		if (!empty($response->errors)) throw new Exception('Twitter error: '.$response->errors[0]->message);
		if (empty($response->statuses)) return; // No results, we're done
		
		// Store the results
		$this->results = array_merge($this->results, $response->statuses);
		
		// Get more pages of results
		$this->pages_returned++;
		if ($this->pages_returned < self::MAX_PAGES_PARSED
			&& !empty($response->search_metadata->next_results)) {
			$this->fetch_page($response->search_metadata->next_results); // Includes a "?"
		}
		
		// Return the new since_id and garbage collect
		$since_id = $response->search_metadata->max_id;
		unset($response);
		return $since_id;
		
	}
	
	/**
	 * Store the results
	 */
	private $results = array();
	public function results() { return $this->results; }
	
}

/*
2013-01-21 11:47:50 INFO - stdClass Object
(
    [statuses] => Array
        (
            [0] => stdClass Object
                (
                    [metadata] => stdClass Object
                        (
                            [result_type] => recent
                            [iso_language_code] => en
                        )

                    [created_at] => Mon Jan 21 19:47:34 +0000 2013
                    [id] => 293444749849935873
                    [id_str] => 293444749849935873
                    [text] => Yolo or yoyo — suicide silence // you only live once http://t.co/n3gyhoTP
                    [source] => <a href="http://ask.fm/" rel="nofollow">Ask.fm</a>
                    [truncated] => 
                    [in_reply_to_status_id] => 
                    [in_reply_to_status_id_str] => 
                    [in_reply_to_user_id] => 
                    [in_reply_to_user_id_str] => 
                    [in_reply_to_screen_name] => 
                    [user] => stdClass Object
                        (
                            [id] => 498957515
                            [id_str] => 498957515
                            [name] => Lucas.
                            [screen_name] => probablylucas
                            [location] => Norwich, England.
                            [description] => Lower Than Atlantis, Enter Shikari, The First, The Wonder Years, Don Broco, Blink-182, Deaf Havana, Decade, Of Mice & Men.
I am 16.
                            [url] => http://t.co/HVnzR3Pl
                            [entities] => stdClass Object
                                (
                                    [url] => stdClass Object
                                        (
                                            [urls] => Array
                                                (
                                                    [0] => stdClass Object
                                                        (
                                                            [url] => http://t.co/HVnzR3Pl
                                                            [expanded_url] => http://backstays-and-halyards.tumblr.com/
                                                            [display_url] => backstays-and-halyards.tumblr.com
                                                            [indices] => Array
                                                                (
                                                                    [0] => 0
                                                                    [1] => 20
                                                                )

                                                        )

                                                )

                                        )

                                    [description] => stdClass Object
                                        (
                                            [urls] => Array
                                                (
                                                )

                                        )

                                )

                            [protected] => 
                            [followers_count] => 1292
                            [friends_count] => 498
                            [listed_count] => 0
                            [created_at] => Tue Feb 21 16:20:18 +0000 2012
                            [favourites_count] => 2412
                            [utc_offset] => 0
                            [time_zone] => Casablanca
                            [geo_enabled] => 1
                            [verified] => 
                            [statuses_count] => 15728
                            [lang] => en
                            [contributors_enabled] => 
                            [is_translator] => 
                            [profile_background_color] => FFFFFF
                            [profile_background_image_url] => http://a0.twimg.com/profile_background_images/655382309/xsl96hfsqkhxzu50mrdv.png
                            [profile_background_image_url_https] => https://si0.twimg.com/profile_background_images/655382309/xsl96hfsqkhxzu50mrdv.png
                            [profile_background_tile] => 1
                            [profile_image_url] => http://a0.twimg.com/profile_images/3103662198/c07c09f9aada8cab33589beaf6eaca67_normal.jpeg
                            [profile_image_url_https] => https://si0.twimg.com/profile_images/3103662198/c07c09f9aada8cab33589beaf6eaca67_normal.jpeg
                            [profile_banner_url] => https://si0.twimg.com/profile_banners/498957515/1357509461
                            [profile_link_color] => 000000
                            [profile_sidebar_border_color] => FFFFFF
                            [profile_sidebar_fill_color] => FFFFFF
                            [profile_text_color] => 000000
                            [profile_use_background_image] => 1
                            [default_profile] => 
                            [default_profile_image] => 
                            [following] => 
                            [follow_request_sent] => 
                            [notifications] => 
                        )

                    [geo] => 
                    [coordinates] => 
                    [place] => 
                    [contributors] => 
                    [retweet_count] => 0
                    [favorited] => 
                    [retweeted] => 
                    [possibly_sensitive] => 
                )

        )

    [search_metadata] => stdClass Object
        (
            [completed_in] => 0.046
            [max_id] => 293444749849935873
            [max_id_str] => 293444749849935873
            [query] => yolo
            [refresh_url] => ?since_id=293444749849935873&q=yolo&result_type=recent
            [count] => 100
            [since_id] => 0
            [since_id_str] => 0
        )

)

*/