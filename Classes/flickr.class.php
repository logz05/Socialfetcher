<?php
class FlickrImages
{
	private $xml;

	public function __construct( $rss_url )
	{
		$this->xml = simplexml_load_file( $rss_url );
	}

	public function getTitle()
	{
		return $this->xml->channel->title;
	}

	public function getProfileLink()
	{
		return $this->xml->channel->link;
	}

	public function getImages($limit = 15)
	{
		$images = array();
		$regx = "/<img(.+)\/>/";

		$counter = 0;	
		foreach( $this->xml->channel->item as $item )
		{
			if($counter < $limit):
				preg_match( $regx, $item->description, $matches );
				
				$img = new FlickrImage();
				$img->title = $item->title;
				$img->link = $item->link;
				$img->thumb = $matches[0];
				
				array_push($images, $img);
				$counter++;
			endif;
		}

		return $images;
	}
}
class FlickrImage
{
	public $title;
	public $link;
	public $thumb;
}