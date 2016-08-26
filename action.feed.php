<?php
if( !isset($gCms) ) exit;

$feed_name = \cge_param::get_string($params,'feed');
$feed = \CGFeedFactory\factory::load($feed_name);
if( !is_object($feed) ) throw new \CmsError404Exception('Feed '.$feed_name.' not found');

$renderer = new \CGFeedFactory\rss_renderer($feed);
$renderer->render();
