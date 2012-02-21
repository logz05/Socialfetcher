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