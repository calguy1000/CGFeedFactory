<?php

namespace CGFeedFactory;

final class factory
{
    private static $_feeds;
    private function __construct() {}

    public static function set($name,$params)
    {
        // set an rss feed variable.
        if( !$name ) throw new \InvalidArgumentException('Cannot set data to a feed with no alias/name');
        if( !\cge_array::is_hash($params) ) throw new \InvalidArgumentException(__METHOD__.' requires an associative array');

        $feed = self::get_feed($name);
        foreach( $params as $key => $val ) {
            $feed->$key = $val;
        }
    }

    public static function add_item($name,$params)
    {
        // add an rss feed item
        if( !$name ) throw new \InvalidArgumentException('Cannot add items to a feed with no alias/name');
        if( !\cge_array::is_hash($params) ) throw new \InvalidArgumentException(__METHOD__.' requires an associative array');

        $feed = self::get_feed($name);
        $alias = \cge_param::get_string($params,'item',$feed->generate_alias());
        $item = new feed_item($alias);
        foreach( $params as $key => $val ) {
            $item->$key = $val;
        }
        try {
            $feed->add_item($item);
        }
        catch( \Exception $e ) {
            audit('','CGFeedFactory','Attempt to add an invalid item to feed '.$feed->name);
        }
    }

    public static function render($name,$params)
    {
        if( !$name ) throw new \InvalidArgumentException('Cannot render a feed with no alias/name');
        $feed = self::get_feed($name);
        $mod = \cms_utils::get_module('CGFeedFactory');
        $template = \cge_param::get_string($params,'template');

        $renderer = new RssRenderer($feed,$mod,$template);

        $handlers = ob_list_handlers(); for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
        header('Content-Type: '.$feed->content_type);
        //\CmsApp::get_instance()->set_content_type($feed->content_type);
        echo $renderer->generate();
        exit();
    }

    public static function get_feed($name)
    {
        $name = trim($name);
        if( !$name ) throw new \InvalidArgumentException('Cannot create a feed with no alias/name');
        if( !isset(self::$_feeds[$name]) ) {
            try {
                // see if we can load it first
                self::$_feeds[$name] = feed::load_by_name($name);
            }
            catch( \Exception $e ) {
                $feed = utils::create_feed();
                $feed->name = $name;
                self::$_feeds[$name] = $feed;
            }
        }
        return self::$_feeds[$name];
    }

}