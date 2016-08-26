<?php
namespace CGFeedFactory;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) return;

$query = new feed_query();
$rs = $query->Execute();

$tpl = $this->CreateSmartyTemplate('admin_tab_feeds.tpl');
$tpl->assign('feeds',$rs->FetchAll());
$tpl->display();
