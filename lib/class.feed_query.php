<?php
namespace CGFeedFactory;

class feed_query extends \CGExtensions\query\query
{
    private $_parms;

    public function __construct($params = array())
    {
        $tmp = [ 'limit' => 100, 'offset' => 0 ];
        $params = array_merge($tmp,$params);
        $this->_parms = $params;
    }

    public function OffsetGet($key)
    {
        $key = trim($key);
        if( isset($this->_parms[$key]) ) return $this->_parms[$key];
    }

    public function OffsetSet($key,$val)
    {
        switch( $key ) {
        case 'limit':
            $this->_data[$key] = max(1,min(10000,int($val)));
            break;

        case 'offset':
            $this->_data[$key] = max(0,int($val));
            break;

        default:
            throw new \LogicException("$key is not a gettable value for ".__CLASS__);
        }
    }

    public function OffsetExists($key)
    {
        return isset($this->_parms[$key]);
    }

    public function &execute()
    {
        $obj = new feed_resultset($this);
        return $obj;
    }
}