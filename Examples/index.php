<?php
require_once("../Classes/twitter.class.php");
require_once("../Classes/flickr.class.php");
require_once("../Classes/youtube.class.php");
require_once("../Classes/vimeo.class.php");
?>
<html>
    <head>
        <title>Social Fetcher Example Page</title>
    </head>
    <body>
        <h2>Twitter</h2>
        <div class="twitter">
            <?php
                $twitter = new Twitter();            
                $tweets = $twitter->getSearch("#wpse", 3);
                /* @var $tweet Tweet */
                foreach($tweets as $tweet):
                ?>
                    <div>
                        <div class="avatar">
                            <a href="<?php echo $tweet->author_link ?>" target="_blank"><img src="<?php echo $tweet->author_image ?>"/></a>
                        </div>
                        <div class="message">
                            <span class="author"><a href="<?php echo $tweet->author_link ?>" target="_blank"><?php echo $tweet->author_name ?></a></span>:
                            <?php echo $tweet->tweet ?>
                            <span class="time"> - <?php echo $tweet->timestamp ?></span>
                        </div>
                    </div>
                <?php
                endforeach;
            ?>
        </div>
        <hr>
        <h2>Flickr</h2>
        <div class="flickr">
            <?php
                $flickr = new FlickrImages( 'http://api.flickr.com/services/feeds/photos_public.gne?id=24591392@N02&lang=en-us&format=rss_200' );                
                $title = $flickr->getTitle();
                $url = $flickr->getProfileLink();
                $images = $flickr->getImages(3);                
                echo '<h3 id="title"><a target="_blank" href="' . $url . '">' . $title . '</a></h3>';
                /* @var $img FlickrImage */
                foreach( $images as $img ):                
                ?>
                	<div>
                        <h3><a href="<?php echo $img->link ?>"><?php echo $img->title ?></a></h3>
                        <div class="img_container"><?php echo $img->thumb ?></div>
                	</div>
                <?php
                endforeach;
            ?>
        </div>
        <hr>
        <h2>Youtube</h2>
        <div class="youtube">
            <?php
                $videofetch = new Youtube();
                $arr = $videofetch->getVideos("chaanet", 1, 3);
                /* @var $item youtubeItem */
                foreach ($arr as $item):
                ?>
                    <h2><?php echo $item->title ?></h2>
                    <iframe src="<?php echo $item->flashPlayer ?>" height="<?php echo $item->height ?>" width="<?php echo $item->width ?>"></iframe>                    
                <?php
                endforeach;                
            ?>
        </div>
        <hr>
        <h2>Vimeo</h2>
        <div class="vimeo">
            <?php
                $videoFetch = new vimeo();
                $arr = $videoFetch->getVideos("brad", 3);
                /* @var $item videoItem */
                foreach ($arr as $item):
                ?>                    
                    <h2><?php echo $item->title ?></h2>
                    <iframe src="<?php echo $item->flashplayer ?>" height="<?php echo $item->height ?>" width="<?php echo $item->width ?>"></iframe>                       
                <?php
                endforeach;
            ?>
        </div>
    </body>
</html>