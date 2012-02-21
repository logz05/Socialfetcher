A small simple sample of classes for fetching content from Twitter, Flickr, Youtube and Vimeo.

## Usage Twitter
    $twitter = new Twitter();            
    $tweets_from_search = $twitter->getSearch("search_string", 3);
    $tweets_from_user = $twitter->getUser("username");
    
## Usage Flickr
    $flickr = new FlickrImages("http://flickr.rss.url");                
    $images = $flickr->getImages(3);
    
## Usage Youtube
    $youtube = new Youtube();
    $videos_from_user = $youtube->getVideos("username", 1, 3);
    $favorites_from_user = $youtube->getFavorites("username");
    $videos_from_search = $youtube->search("search_string");
    
## Usage Vimeo
    $vimeo = new vimeo();
    $videos_from_user = $vimeo->getVideos("username", 3);
    $albums_for_user = $vimeo->getAlbums("username");
    $videos_from_album = $vimeo->getVideosFromAlbum("album_id");
    
For further usage, check the example or the code itself.

## License
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