{strip}<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>{$tmp=$feed->title|cms_escape|default:'RSS Feed'}{eval var=$tmp}</title>
    <link>{$tmp=$feed->link|default:"{root_url}"}{eval var=$tmp}</link>
    <description><![CDATA[{$tmp=$feed->description|cms_escape|default:"Latest news at {sitename}"}{eval var=$tmp}]]></description>
    <copyright>{$tmp=$feed->copyright|default:"Copyright {$smarty.now|date_format:'%Y'} {sitename}"}{eval var=$tmp}</copyright>
    {if $feed->lang}<language>{$feed->lang}</language>{/if}
    {if $feed->managing_editor && is_email($feed->managing_editor)}<managingEditor>{$feed->managing_editor}</managingEditor>{/if}
    {if $feed->admin_email && is_email($feed->admin_email)}<webMaster>{$feed->managing_editor}</webMaster>{/if}
    <generator>{$tmp=$feed->generator|default:"{$mod->GetName()}-{$mod->Getversion()} for CMSMS by calguy1000"}{eval var=$tmp}</generator>
    <ttl>{$feed->ttl|default:60}</ttl>
    <lastBuildDate>{$smarty.now|rfc_date}</lastBuildDate>
    {if $feed->image_url}
       {* image_url is expected to be a full URL *}
       <image>
         <title>{$feed->title|cms_escape|default:'RSS Feed'}</title>
         <url>{$feed->image_url}</url>
         <link>{$feed->link|default:"{root_url}"}</link>
       </image>
    {/if}
    {foreach $feed->items as $item}
      {if $item@index >= $feed->limit}{continue}{/if}
      <item>
        <title>{$item->title|cms_escape}</title>
	<link>{$item->link}</link>
	<description><![CDATA[{$item->description|cms_escape}]]></description>
	{if $item->author && is_email($item->author)}<author>{$item->author}</author>{/if}
	{if $item->date}<pubDate>{$item->date|rfc_date}</pubDate>{/if}
	{if $item->guid}
  	  <guid>{$item->guid}</guid>
	{else}
  	  <guid isPermaLink="true">{$item->link}</guid>
	{/if}
      </item>
    {/foreach}
  </channel>
</rss>{/strip}