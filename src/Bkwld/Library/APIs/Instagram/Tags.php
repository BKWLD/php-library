<?php namespace Bkwld\Library\APIs\Instagram;

// Dependencies
use Cache;
use Log;
use Config;
use Request;
use Exception;

class Tags {
	
	// Configuration
	const CACHE_ID = 'min-tag-id-for-';
	const MAX_PAGES_PARSED = 10; // How many pages back in time to get per request
	
	/**
	 * Search for the provided tag and return the results via JSON
	 */
	static public function rollingSearch($tag) {
		
		// Find out when the last image we added was posted
		$min_tag_id = Cache::get(self::CACHE_ID.$tag, 0);
		
		// Form the starting URL
		$url = 'https://api.instagram.com/v1/tags/'
			.urlencode($tag)
			.'/media/recent?client_id='
			.Config::get('instagram.client_id')
			.'&min_tag_id='
			.$min_tag_id;
		
		// Fetch the recent photos from instagram
		$query = new self;
		$min_tag_id = $query->fetchPage($url);
		$results = $query->results();
		unset($query);
		
		// Log the "min_tag_id" which is used as the starting place of future requests to get
		// only newer photos since the last time.  Though it may not be set if there were no
		// results
		if ($min_tag_id) Cache::forever(self::CACHE_ID.$tag, $min_tag_id);
		
		// Return all the matches
		return $results;
		
	}
	
	/**
	 * Act on a specific incoming tag
	 */
	private $pages_returned = 0;
	private function fetchPage($url) {
		
		// Ask instagram for all images since then.
		Log::debug('Executing: '.$url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (!($response = curl_exec($ch))) throw new Exception('Tag/media/recent could not be executed');
		curl_close($ch);
		
		// If there are none, you're done
		$response = json_decode($response);
		if (empty($response->meta->code)) throw new Exception('No meta code: '.print_r($response,true));
		if ($response->meta->code != 200) throw new Exception('Instagram error:'.$response->meta->error_message);
		if (empty($response->data)) return;
		
		// Store the results
		$this->results = array_merge($this->results, $response->data);
		
		// Fetch more if it there is a next url.  But only up to a certain amount.  This essentially
		// steps back in time to fetch older results.
		$this->pages_returned++;
		if ($this->pages_returned < self::MAX_PAGES_PARSED 
			&& isset($response->pagination) 
			&& !empty($response->pagination->next_url)) {
			$this->fetchPage($response->pagination->next_url);
		}
		
		// Return the new min tag-id.  There will always be a min_tag_id returned:
		// https://groups.google.com/forum/?fromgroups=#!topic/instagram-api-developers/lGJvmwWF45E
		// (well, as long as there are any results, there will be)
		$min_tag_id = $response->pagination->min_tag_id;
		unset($response);
		return $min_tag_id;
	}
	
	/**
	 * Store the results
	 */
	private $results = array();
	public function results() { return $this->results; }
	
}


/*
2013-01-21 07:09:19 INFO - stdClass Object
(
    [attribution] => 
    [tags] => Array
        (
            [0] => tagstagramers
            [1] => ola
            [2] => onda
            [3] => natura
            [4] => streetart
            [5] => wilderness
            [6] => foodporn
            [7] => yolo
            [8] => all_shots
            [9] => 100likes
            [10] => water
            [11] => nihallhoran
            [12] => likes
            [13] => irox_water
            [14] => ripple
            [15] => tagstagram
            [16] => est
            [17] => cloudporn
            [18] => seascape
            [19] => iphonephotography
            [20] => ripples
            [21] => ocean
            [22] => amazing
            [23] => summit
            [24] => architecture
            [25] => gorgeous
            [26] => peak
            [27] => landscape_lovers
            [28] => landscapes
            [29] => nice
        )

    [location] => 
    [comments] => stdClass Object
        (
            [count] => 0
            [data] => Array
                (
                )

        )

    [filter] => Valencia
    [created_time] => 1358598983
    [link] => http://instagr.am/p/UqmJvxEgF-/
    [likes] => stdClass Object
        (
            [count] => 21
            [data] => Array
                (
                    [0] => stdClass Object
                        (
                            [username] => eleonorlq
                            [profile_picture] => http://images.instagram.com/profiles/profile_5849093_75sq_1356791719.jpg
                            [id] => 5849093
                            [full_name] => Eleonor Lagerkvist
                        )

                    [1] => stdClass Object
                        (
                            [username] => kylelevatino
                            [profile_picture] => http://images.instagram.com/profiles/profile_178553320_75sq_1358134225.jpg
                            [id] => 178553320
                            [full_name] => Kyle Levatino
                        )

        )

    [images] => stdClass Object
        (
            [low_resolution] => stdClass Object
                (
                    [url] => http://distilleryimage2.s3.amazonaws.com/d59aed54623411e2a12822000a9f18f6_6.jpg
                    [width] => 306
                    [height] => 306
                )

            [thumbnail] => stdClass Object
                (
                    [url] => http://distilleryimage2.s3.amazonaws.com/d59aed54623411e2a12822000a9f18f6_5.jpg
                    [width] => 150
                    [height] => 150
                )

            [standard_resolution] => stdClass Object
                (
                    [url] => http://distilleryimage2.s3.amazonaws.com/d59aed54623411e2a12822000a9f18f6_7.jpg
                    [width] => 612
                    [height] => 612
                )

        )

    [caption] => stdClass Object
        (
            [created_time] => 1358780957
            [text] => #yolo #foodporn #landscape_lovers #gorgeous #amazing #est #nihallhoran #peak #landscapes #summit #wilderness #ripple #ripples #natura #ocean #onda #ola #seascape #irox_water #water #nice #architecture #100likes #all_shots #iphonephotography #cloudporn #likes #tagstagram #tagstagramers #streetart
            [from] => stdClass Object
                (
                    [username] => cemrelydia
                    [profile_picture] => http://images.instagram.com/profiles/profile_17961151_75sq_1358442693.jpg
                    [id] => 17961151
                    [full_name] => Lydia Cemre Ozsisman
                )

            [id] => 373804224671252689
        )

    [type] => image
    [id] => 372277714743329150_17961151
    [user] => stdClass Object
        (
            [username] => cemrelydia
            [website] => 
            [profile_picture] => http://images.instagram.com/profiles/profile_17961151_75sq_1358442693.jpg
            [full_name] => Lydia Cemre Ozsisman
            [bio] => 
            [id] => 17961151
        )

)
*/