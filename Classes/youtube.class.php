<?php
class Youtube
{
    /**
     * Get videos for the specified user.
     * @return array Arrary of videoItem's
     */
    function getVideos($username, $startindex = 1, $maxresult = 10)
    {
        $output = array();
        $url = "http://gdata.youtube.com/feeds/api/users/" . $username . "/uploads?start-index=" . $startindex . "&max-results=" . $maxresult . "&v=2";
        
        // get the response
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->entry); ++$i)
            {
                $currentVideo = $xml->entry[$i];
                                
                $vid = new youtubeItem;
                $vid->id = $currentVideo->id;
                $vid->title = $currentVideo->title;
                $vid->url = $currentVideo->link["href"];
                $vid->timestamp = $currentVideo->published;
                $vid->flashPlayer = $currentVideo->content["src"];
                // get nodes in media: namespace for media information
                $media = $currentVideo->children('http://search.yahoo.com/mrss/');
                
                $attrs = $media->group->thumbnail[0]->attributes();
                $vid->smallThumbnail = $attrs['url'];
                $attrs = $media->group->thumbnail[1]->attributes();
                $vid->largeThumbnail = $attrs['url'];
                $vid->width = $attrs['width'];
                $vid->height = $attrs['height'];
                
                array_push($output, $vid);                
            }
        }
        else
        {
            //error
        }
        return $output;          
    }
    /**
     * Get favorite videos for the specified user.
     * @return array Arrary of videoItem's
     */
    function getFavorites($username, $startindex = 1, $maxresult = 10)
    {
        $output = array();
        $url = "http://gdata.youtube.com/feeds/api/users/" . $username . "/favorites?start-index=" . $startindex . "&max-results=" . $maxresult . "&v=2";
        
        // get the response
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->entry); ++$i)
            {
                $currentVideo = $xml->entry[$i];
                                
                $vid = new youtubeItem;
                $vid->id = $currentVideo->id;
                $vid->title = $currentVideo->title;
                $vid->url = $currentVideo->link["href"];
                $vid->timestamp = $currentVideo->published;
                $vid->flashPlayer = $currentVideo->content["src"];
                // get nodes in media: namespace for media information
                $media = $currentVideo->children('http://search.yahoo.com/mrss/');
                
                $attrs = $media->group->thumbnail[0]->attributes();
                $vid->smallThumbnail = $attrs['url'];
                $attrs = $media->group->thumbnail[1]->attributes();
                $vid->largeThumbnail = $attrs['url'];
                $vid->width = $attrs['width'];
                $vid->height = $attrs['height'];
                
                array_push($output, $vid);                
            }
        }
        else
        {
            //error
        }
        return $output;          
    }
    /**
     * Get searchresult for the given query
     * @return array Array of videoItem's
     */
    function search($query, $startindex = 1, $maxresult = 10)
    {
        $output = array();
        $url = "http://gdata.youtube.com/feeds/api/videos?q=" . $query . "&start-index=" . $startindex . "&max-results=" . $maxresult . "&v=2";
        
        // get the response
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->entry); ++$i)
            {
                $currentVideo = $xml->entry[$i];
                                
                $vid = new youtubeItem;
                $vid->id = $currentVideo->id;
                $vid->title = $currentVideo->title;
                $vid->url = $currentVideo->link["href"];
                $vid->timestamp = $currentVideo->published;
                $vid->flashPlayer = $currentVideo->content["src"];
                // get nodes in media: namespace for media information
                $media = $currentVideo->children('http://search.yahoo.com/mrss/');
                
                $attrs = $media->group->thumbnail[0]->attributes();
                $vid->smallThumbnail = $attrs['url'];
                $attrs = $media->group->thumbnail[1]->attributes();
                $vid->largeThumbnail = $attrs['url'];
                $vid->width = $attrs['width'];
                $vid->height = $attrs['height'];
                
                array_push($output, $vid);                
            }
        }
        else
        {
            //error
        }
        return $output;           
    }
}
class youtubeItem
{
    public $id;
    public $title;
    public $url;
    public $timestamp;
    public $flashPlayer;
    public $smallThumbnail;
    public $largeThumbnail;
    public $width;
    public $height;
}
?>