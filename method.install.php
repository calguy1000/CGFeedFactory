<?php
namespace CGFeedFactory;

if (!isset($gCms)) exit;
$db = $this->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE=MyISAM');

$flds = "
    id I KEY AUTO NOTNULL,
    name C(255) KEY NOTNULL,
    data X2
";
$sqlarray = $dict->CreateTableSQL(feed::table_name(), $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// setup a feed template type
$tpl_type = new \CmsLayoutTemplateType;
$tpl_type->set_originator($this->GetName());
$tpl_type->set_name('Feed template');
$tpl_type->set_dflt_flag(FALSE); // there is no default for this type
$tpl_type->set_lang_callback('CGFeedFactory::type_lang_callback');
$tpl_type->save();

// load a sample template or something.
$uid = get_userid();
$fn = __DIR__.'/templates/orig_newsfeed_template.tpl';
$tpl = new \CmsLayoutTemplate();
$tpl->set_name('News Feed');
$tpl->set_owner($uid);
$tpl->set_content(file_get_contents($fn));
$tpl->set_type($tpl_type);
$tpl->save();

// create a sample feed... only need one.
$feed = utils::create_feed();
$feed->name = 'latest_news';
$feed->title = 'Happenings at {sitename}';
$feed->description = 'The latest and greatest information about what is happening at {sitename}';
$feed->link = $config['root_url'];
$feed->limit = 30;
$feed->save();