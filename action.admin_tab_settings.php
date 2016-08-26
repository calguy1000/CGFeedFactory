<?php
namespace CGFeedFactory;
use \cms_siteprefs;
use \cge_param;

if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) return;
$this->SetCurrentTab('settings');

if( isset($params['reset']) ) {
    $settings = utils::reset_settings();
    $this->SetMessage($this->Lang('msg_settings_reset'));
    $this->RedirectToTab();
} else if( isset($params['submit']) ) {
    $settings = utils::load_settings();
    $settings->managing_editor = cge_param::get_string($params,'managing_editor');
    $settings->admin_email = cge_param::get_string($params,'admin_email');
    $settings->copyright = cge_param::get_string($params,'copyright');
    $settings->content_type = cge_param::get_string($params,'content_type');
    $settings->generator = cge_param::get_string($params,'generator');
    $settings->limit = max(1,cge_param::get_int($params,'limit'));
    $settings->lang = cge_param::get_string($params,'lang');
    $settings->ttl = max(1,cge_param::get_int($params,'ttl'));
    utils::save_settings($settings);
    $this->SetMessage($this->Lang('msg_settings_saved'));
    $this->RedirectToTab();
}

$settings = utils::load_settings();
$tpl = $this->CreateSmartyTemplate('admin_tab_settings.tpl');
$tpl->assign('settings',$settings);
$tpl->display();
