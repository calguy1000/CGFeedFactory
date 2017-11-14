<?php

namespace CGFeedFactory;

class feed
{
    private $_id;
    private $_unsorted = FALSE;

    private $_name;
    private $_title;
    private $_link;
    private $_self;
    private $_lang;
    private $_description;
    private $_generator = '{$mod->GetName()} v{$mod->GetVersion()} for CMSMS by calguy1000';
    private $_managing_editor;
    private $_copyright = "Copyright {\$smarty.now|date_format:'%Y'} {sitename}";
    private $_admin_email;
    private $_content_type = 'application/rss+xml';
    private $_image;
    private $_ttl = 60;
    private $_limit = 100;
    private $_items = [];

    public static function table_name()
    {
        return cms_db_prefix().'mod_cgff';
    }

    public static function mod()
    {
        return \cms_utils::get_module('CGFeedFactory');
    }

    public function __construct($name = null)
    {
        $this->_name = trim($name);
    }

    public function __get($key)
    {
        $tkey = '_'.$key;
        switch( $key ) {
        case 'name':
        case 'title':
        case 'link':
        case 'self':
        case 'description':
        case 'copyright':
        case 'managing_editor':
        case 'generator':
        case 'admin_email':
        case 'image':
        case 'lang':
        case 'content_type':
            return trim($this->$tkey);

        case 'id':
        case 'limit':
        case 'ttl':
            return (int) $this->$tkey;

        case 'unsorted':
            return (bool) $this->$tkey;

        case 'items':
            return $this->get_items();

        case 'image_url':
            if( !$this->image ) return;
            $config = \cms_config::get_instance();
            if( startswith( $config['root_path']) ) {
                return str_replace($config['root_path'],$config['root_url'],$this->image);
            }
            break;

        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        $tkey = '_'.$key;
        switch( $key ) {
        case 'name':
        case 'title':
        case 'link':
        case 'self':
        case 'description':
        case 'copyright':
        case 'generator':
        case 'managing_editor':
        case 'admin_email':
        case 'image':
        case 'content_type':
            $this->$tkey = trim($val);
            break;

        case 'lang':
            $this->$tkey = trim($val);
            break;

        case 'limit':
            $this->$tkey = max(0,min(10000,(int) $val));
            break;

        case 'ttl':
            $this->$tkey = max(1,min(24*60,(int) $val));
            break;

        case 'unsorted':
            $this->$tkey = \cge_utils::to_bool($val);
            break;

        default:
            throw new \LogicException("$key is not a settable member of ".__CLASS__);
        }
    }

    public function generate_alias()
    {
        $raw_alias = $alias = '__item'.(count($this->_items) + 1);
        $n = 1;
        while( $n < 102 ) {
            $fnd = false;
            foreach( $this->_items as $item ) {
                if( $item->alias == $alias ) {
                    $fnd = true;
                    break;
                }
            }
            if( !$fnd ) return $alias;
            $n++;
            $suffix = '-'.$n;
            $alias = $raw_alias.$suffix;
        }
        if( $n >= 102 ) throw new \RuntimeException('Could not generate a unique item alias');
    }

    public function add_item(feed_item $item)
    {
        if( !$item->is_valid() ) throw new \RuntimeException('Cannot add an invalid item to a feed');
        $this->_items[$item->alias] = $item;
    }

    public function can_render()
    {
        if( !$this->title ) return;
        if( !$this->link ) return;
        if( !$this->description ) return;
        return TRUE;
    }

    public function get_items()
    {
        if( !count($this->_items) ) return;

        $items = [];
        foreach( $this->_items as $item ) {
            if( $item->is_valid() ) $items[] = $item;
        }
        if( $this->unsorted ) return $items;

        $items = $this->_items;
        usort($items,function($a,$b){
                if( $a->date < $b->date ) return -1;
                if( $a->date > $b->date ) return 1;
                return 0;
            });
        return $items;
    }

    public function validate()
    {
        if( !$this->name ) throw new \RuntimeException(self::mod()->Lang('err_feedname'));
        if( !\CmsAdminUtils::is_valid_itemname($this->name) ) throw new \RuntimeException(self::mod()->Lang('err_feedname'));
        if( !$this->title ) throw new \RuntimeException(self::mod()->Lang('err_feedtitle'));

        $db = \CmsApp::get_instance()->GetDb();
        $tmp = null;
        if( !$this->id ) {
            $sql = 'SELECT id FROM '.self::table_name().' WHERE name = ?';
            $tmp = (int) $db->GetOne($sql, [ $this->name] );
        }
        else {
            $sql = 'SELECT id FROM '.self::table_name().' WHERE name = ? AND id != ?';
            $tmp = (int) $db->GetOne($sql, [ $this->name, $this->id ] );
        }
        if( $tmp ) throw new \RuntimeException(self::mod()->Lang('err_feedexists',$this->name));
    }

    public function save()
    {
        $this->validate();
        $db = \CmsApp::get_instance()->GetDb();
        if( !$this->id ) {
            $sql = 'INSERT INTO '.self::table_name().' (name,data) VALUES (?,?)';
            $db->Execute($sql,[ $this->name, serialize($this) ] );
            $this->_id = $db->Insert_ID();
        } else {
            $sql = 'UPDATE '.self::table_name().' SET name = ?, data = ? WHERE id = ?';
            $db->Execute( $sql, [ $this->name, serialize($this), $this->id ] );
        }
    }

    public function delete()
    {
        if( !$this->id ) throw new \LogicException('A '.__CLASS__.' cannot be deleted if it has not been saved');
        $db = \CmsApp::get_instance()->GetDb();
        $sql = 'DELETE FROM '.self::table_name().' WHERE id = ?';
        $db->Execute($sql, [ $this->id ] );
        $this->_id = 0;
    }

    public static function &load_by_id( $id )
    {
        $id = (int) $id;
        if( $id < 1 ) throw new \LogicException('Invalid id passed to '.__METHOD__);
        $db = \CmsApp::get_instance()->GetDb();
        $sql = 'SELECT * FROM '.self::table_name().' WHERE id = ?';
        $row = $db->GetRow($sql, [ $id ]);
        if( !is_array($row) ) throw new \RuntimeException('Could not find the feed with the specified id');
        $obj = unserialize($row['data']);
        $obj->_id = (int) $row['id'];
        return $obj;
    }

    public static function &load_by_name( $name )
    {
        $name = trim($name);
        if( !$name ) throw new \LogicException('Invalid name passed to '.__METHOD__);
        $db = \CmsApp::get_instance()->GetDb();
        $sql = 'SELECT * FROM '.self::table_name().' WHERE name = ?';
        $row = $db->GetRow($sql, [ $name ]);
        if( !is_array($row) || !count($row) ) throw new \RuntimeException('Could not find the feed with the specified name');
        $obj = unserialize($row['data']);
        $obj->_id = (int) $row['id'];
        return $obj;
    }

    /** @ignore **/
    public function correct_from_row($row)
    {
        $this->_id = (int) $row['id'];
    }
}


final class feed_item
{
    private $_alias;
    private $_title;
    private $_link;
    private $_description;
    private $_guid;
    private $_author; // email address
    private $_date; // unix timestamp

    public function __construct($alias)
    {
        $this->_alias = trim($alias);
        if( !$this->_alias ) throw new \LogicException('Every feed item must have an alias');
    }

    public function __get($key)
    {
        $tkey = '_'.$key;
        switch( $key ) {
        case 'alias':
        case 'title':
        case 'link':
        case 'description':
        case 'author':
            return trim($this->$tkey);

        case 'guid':
            $val = trim($this->$tkey);
            return $val;

        case 'url':
            return trim($this->_link);

        case 'date':
            return (int) $this->$tkey;

        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        $tkey = '_'.$key;
        switch( $key ) {
        case 'title':
        case 'link':
        case 'description':
        case 'guid':
        case 'author':
            $this->$tkey = trim($val);
            break;

        case 'url':
            $this->_link = trim($val);
            break;

        case 'date':
            if( is_int( $val ) ) {
                $this->$tkey = $val;
            } else {
                $this->$tkey = (int) strtotime($val);
            }
            break;

        default:
            throw new \LogicException("$key is not a settable member of ".__CLASS__);
        }
    }

    public function is_valid()
    {
        if( !$this->date ) return;
        IF( !$this->title ) return;
        if( !$this->link ) return;
        //if( !$this->description ) return;
        return TRUE;
    }
}
