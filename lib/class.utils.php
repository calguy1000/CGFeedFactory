<?php
namespace CGFeedFactory;
use \cms_siteprefs;

final class utils
{
    const SETTINGS_PREF = 'feed_defaults';
    private function __construct() {}

    public static function mod()
    {
        $mod = \cms_utils::get_module('CGFeedFactory');
        return $mod;
    }

    public static function reset_settings()
    {
        self::mod()->RemovePreference(self::SETTINGS_PREF);
    }

    public static function load_settings()
    {
        $tmp = self::mod()->GetPreference(self::SETTINGS_PREF);
        if( $tmp ) return unserialize($tmp);
        $obj = new feed;
        $uid = get_userid(FALSE);
        if( $uid > 0 ) {
            $user = \UserOperations::get_instance()->LoadUserByID($uid);
            $obj->managing_editor = $obj->admin_email = $user->email;
        }
        return $obj;
    }

    public static function create_feed()
    {
        return self::load_settings();
    }

    public static function save_settings(feed $settings)
    {
        self::mod()->SetPreference(self::SETTINGS_PREF,serialize($settings));
    }
}