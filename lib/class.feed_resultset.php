<?php
namespace CGFeedFactory;

class feed_resultset extends \CGExtensions\query\resultset
{
    public function __construct(feed_query $query)
    {
        $this->_filter = $query;
    }

    protected function _query()
    {
        if( $this->_rs ) return;

        $sql = 'SELECT SQL_CALC_FOUND_ROWS id,name,data FROM '.feed::table_name().' ORDER BY name ASC';
        $db = \cms_utils::get_db();
        $this->_rs = $db->SelectLimit($sql,$this->_filter['limit'],$this->_filter['offset']);
        $this->_totalmatching = (int) $db->GetOne('SELECT FOUND_ROWS()');
    }

    public function &get_object()
    {
        $ret = null;
        if( !$this->_rs ) return $ret;

        $obj = unserialize($this->fields['data']);
        $obj->correct_from_row($this->fields);
        return $obj;
    }
}