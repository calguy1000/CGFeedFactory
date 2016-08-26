<?php
namespace CGFeedFactory;
use \cge_param;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) return;

$get_int_empty = function($params,$fld) {
    $tmp = \cge_param::get_string($params,$fld);
    if( $tmp ) $tmp = max(1,(int) $tmp);
    return $tmp;
};

try {
    if( cge_param::exists($params,'cancel') ) {
        $this->SetMessage($this->Lang('msg_cancelled'));
        $this->RedirectToTab();
    }

    $fid = \cge_param::get_int($params,'fid');
    $feed = utils::create_feed();
    if( $fid ) $feed = feed::load_by_id($fid);

    if( cge_param::exists($params,'submit') ) {
        try {
            $feed->name = cge_param::get_string($params,'name');
            $feed->title = cge_param::get_string($params,'title');
            $feed->description = cge_param::get_string($params,'description');
            $feed->image = cge_param::get_string($params,'image');
            $feed->limit = $get_int_empty($params,'limit');
            $feed->copyright = cge_param::get_string($params,'copyright');
            $feed->managing_editor = cge_param::get_string($params,'managing_editor');
            $feed->admin_email = cge_param::get_string($params,'admin_email');
            $feed->lang = cge_param::get_string($params,'lang');
            $feed->content_type = cge_param::get_string($params,'content_type');
            $feed->ttl = $get_int_empty($params,'ttl');

            $feed->save();
            $this->SetMessage($this->Lang('msg_feedsaved'));
            $this->RedirectToTab();
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_edit_feed.tpl');
    $tpl->assign('feed',$feed);
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}