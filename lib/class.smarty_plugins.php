<?php

namespace CGFeedFactory;

final class smarty_plugins
{
    const DFLT_ALIAS = '_DFLT_';
    private static $_init;

    private function __construct() {}

    public static function init()
    {
        if( self::$_init ) return;
        self::$_init = 1;

        $smarty = \CmsApp::get_instance()->GetSmarty();
        if( !$smarty ) throw new \LogicException('Could not get smarty exception');

        $smarty->register_function('cgff_set','\CGFeedFactory\smarty_plugins::cgff_set');
        $smarty->register_function('cgff_add','\CGFeedFactory\smarty_plugins::cgff_add');
        $smarty->register_function('cgff_render','\CGFeedFactory\smarty_plugins::cgff_render');
    }

    public static function cgff_set($params,&$template)
    {
        $feed = \cge_param::get_string($params,'feed',self::DFLT_ALIAS);
        unset($params['feed']);
        return factory::set($feed,$params);
    }

    public static function cgff_add($params,&$template)
    {
        $feed = \cge_param::get_string($params,'feed',self::DFLT_ALIAS);
        unset($params['feed']);
        return factory::add_item($feed,$params);
    }

    public static function cgff_render($params,&$template)
    {
        $feedname = \cge_param::get_string($params,'feed',self::DFLT_ALIAS);
        unset($params['feed']);
        return factory::render($feedname,$params);
    }
}
