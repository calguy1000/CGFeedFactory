<?php
namespace CGFeedFactory;

if (!isset($gCms)) exit;
$db = $this->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = [ 'mysql' => 'ENGINE=MyISAM' ];

$sqlarray = $dict->DropTableSQL(feed::table_name());
$dict->ExecuteSQLArray($sqlarray);

try {
    $types = \CmsLayoutTemplateType::load_all_by_originator($this->GetName());
    if( is_array($types) && count($types) ) {
        foreach( $types as $type ) {
            $templates = $type->get_template_list();
            if( is_array($templates) && count($templates) ) {
                foreach( $templates as $template ) {
                    $template->delete();
                }
            }
            $type->delete();
        }
    }
}
catch( Exception $e ) {
    // log it
    audit('',$this->GetName(),'Uninstall Error: '.$e->GetMessage());
}
