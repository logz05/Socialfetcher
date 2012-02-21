<?php
/*  
    Copyright 2012  Erik Johansson  (email : erik.johansson87@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class Twitter
{
	private $xml;

	public function __construct( $q )
    {
        $this->searchURL = 'http://search.twitter.com/search.atom?lang=en&q=';
		$this->xml = simplexml_load_file( $this->searchURL . urlencode($q) );
        
        $this->realNamePattern = '/\((.*?)\)/';
        $this->intervalNames = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
        $this->intervalSeconds = array( 1, 60, 3600, 86400, 604800, 2630880, 31570560);        
	}

    public function getUser($username, $limit = 10)
    {
        $jsonurl = "http://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&screen_name=" . $username;
        $jsonobject = json_decode(file_get_contents($jsonurl));
        $tweets = array();        
        $counter = 0;
		foreach( $jsonobject as $item )
        {            
            if( $counter < $limit):    
                $t = new Tweet();
                $t->author_name = $item->user->name;
                $t->author_image = $item->user->profile_image_url;
                $t->tweet = str_replace('<a href=', '<a target="_blank" href=', $item->text);
                $t->timestamp = $this->getTime($item->created_at);

                array_push($tweets, $t);
                $counter++;
            endif;
		}                
    }
    
	public function getSearch($limit=15)
    {
		$tweets = array();
        $counter = 0;
		foreach( $this->xml->entry as $item )
        {
            if( $counter < $limit):
                preg_match($this->realNamePattern, $item->author->name, $matches);
                $name = $matches[1];
    
                $t = new Tweet();
                $t->author_link = $item->author->uri;
                $t->author_name = $name;
                $t->author_image = $item->link[1]->attributes()->href;
                $t->tweet = str_replace('<a href=', '<a target="_blank" href=', $item->content);
                $t->timestamp = $this->getTime($item->published);
                
                array_push($tweets, $t);
                $counter++;
            endif;
		}

		return $tweets;
	}
    
    public function getTime($timestamp)
    {
        $time = 'just now';
        $secondsPassed = time() - strtotime($timestamp);
        if ($secondsPassed>0)
        {
            for($j = count($this->intervalSeconds)-1; ($j >= 0); $j--)
            {
                $crtIntervalName = $this->intervalNames[$j];
                $crtInterval = $this->intervalSeconds[$j];
     
                if ($secondsPassed >= $crtInterval)
                {
                    $value = floor($secondsPassed / $crtInterval);
                    if ($value > 1)
                        $crtIntervalName .= 's';
       
                    return $value . ' ' . $crtIntervalName . ' ago';
       
                    break;
                }
            }
        }        
    }
}
class Tweet
{
    public $author_link;
    public $author_name;
    public $author_image;
    public $tweet;
    public $timestamp;
}
