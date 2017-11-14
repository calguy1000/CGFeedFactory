<?php

namespace CGFeedFactory;

class RssRenderer
{
    private $_feed;
    private $_mod;
    private $_template = 'rss.tpl';

    public function __construct(feed $feed,\CGFeedFactory $mod,$template = null)
    {
        if( ! $feed->can_render() ) throw new \InvalidArgumentException('A problem with the feed prevents it from being rendered.');
        $this->_feed = $feed;
        $this->_mod = $mod;
        $template = trim($template);
        if( $template ) $this->_template = $template;
    }

    public function generate()
    {
        $tpl = $this->_mod->CreateSmartyTemplate($this->_template);
        $tpl->assign('feed',$this->_feed);
        $tpl->assign('mod',$this->_mod);
        return $tpl->fetch();
    }

} // end of class