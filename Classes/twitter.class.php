<?php
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

	public function getTweets($limit=15)
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
