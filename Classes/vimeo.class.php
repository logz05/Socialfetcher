<?php
class vimeo
{
    
    /**
     * Get videos for the specified user.
     * @return array Arrary of videoItem's
     */
    function getVideos($username, $limit = 10)
    {
        $output = array();
        $url = "http://vimeo.com/api/v2/" . $username . "/videos.xml";
        
        // get the response
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->video) && $i < $limit; ++$i)
            {
                $currentVideo = $xml->video[$i];
                $vid = new videoItem;
                $vid->id = $currentVideo->id;
                $vid->title = $currentVideo->title;
                $vid->url = $currentVideo->url;
                $vid->flashplayer = "http://player.vimeo.com/video/" . $currentVideo->id;
                $vid->timestamp = $currentVideo->upload_date;
                $vid->smallThumbnail = $currentVideo->thumbnail_small;
                $vid->mediumThumbnail = $currentVideo->thumbnail_medium;
                $vid->largeThumbnail = $currentVideo->thumbnail_large;
                $vid->width = $currentVideo->width;
                $vid->height = $currentVideo->height;
                
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
     * Get albums that the user has created.
     * @return array Array of Albums
     */
    function getAlbums($username)
    {
        $output = array();
        $url = "http://vimeo.com/api/v2/" . $username . "/albums.xml";
        
        //get the response        
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->album); ++$i)
            {
                $currentAlbum = $xml->album[$i];
                $a = new vimeoAlbum;
                $a->id = $currentAlbum->id;
                $a->title = $currentAlbum->title;
                $a->description = $currentAlbum->description;
                $a->nrOfVideos = $currentAlbum->total_videos;
                
                array_push($output, $a);
            }
        }
        else
        {
            //error
        }        
        return $output;          
    }
    /**
     * Get videos in the specified album
     * @return array Array of videoItem's
     */
    function getVideosFromAlbum($albumID)
    {
        $output = array();
        $url = "http://vimeo.com/api/v2/album/" . $albumID . "/videos.xml";
        
        // get the response
        $response = file_get_contents($url);
        
        if ($response !== false)
        {
            $xml = simplexml_load_string($response);
            for ($i = 0; $i < count($xml->video); ++$i)
            {
                $currentVideo = $xml->video[$i];
                $vid = new videoItem;
                $vid->id = $currentVideo->id;
                $vid->title = $currentVideo->title;
                $vid->url = $currentVideo->url;
                $vid->flashplayer = "http://player.vimeo.com/video/" . $currentVideo->id;
                $vid->timestamp = $currentVideo->upload_date;
                $vid->smallThumbnail = $currentVideo->thumbnail_small;
                $vid->mediumThumbnail = $currentVideo->thumbnail_medium;
                $vid->largeThumbnail = $currentVideo->thumbnail_large;
                $vid->width = $currentVideo->width;
                $vid->height = $currentVideo->height;
                
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
class videoItem
{
    public $id;
    public $title;
    public $url;
    public $flashplayer;
    public $timestamp;
    public $smallThumbnail;
    public $mediumThumbnail;
    public $largeThumbnail;
    public $width;
    public $height;
}
class vimeoAlbum
{
    public $id;
    public $title;
    public $description;
    public $nrOfVideos;
}
?>