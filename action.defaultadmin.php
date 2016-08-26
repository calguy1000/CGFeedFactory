<?php
namespace CGFeedFactory;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) return;

echo $this->StartTabHeaders();
echo $this->SetTabHeader('feeds',$this->Lang('tab_feeds'));
echo $this->SetTabHeader('settings',$this->Lang('tab_settings'));
echo $this->EndTabHeaders();

echo $this->StartTabContent();
echo $this->StartTab('feeds',$params);
include_once(__DIR__.'/action.admin_tab_feeds.php');
echo $this->EndTab();
echo $this->StartTab('settings',$params);
include_once(__DIR__.'/action.admin_tab_settings.php');
echo $this->EndTab();
echo $this->EndTabContent();
