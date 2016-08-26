<?php
namespace CGFeedFactory;
use \cge_param;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) return;

try {
    $fid = \cge_param::get_int($params,'fid');
    if( $fid < 1 ) throw new \InvalidArgumentException('Invalid Feed ID passed to action');
    $feed = feed::load_by_id($fid);
    $feed->delete();
    $this->SetMessage($this->Lang('msg_feeddeleted'));
    $this->RedirectToTab();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}