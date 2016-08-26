{*
  This is a template suitable for use as a news module summary template that will build an RSS feed from news items, using CGFeedFactory.
  Note: This template does not call the {cgff_set} plugins, and assumes that a feed entitled 'latest_news' is already created in the database.

  To use this template.
  1.  Create a new blank content page, the template is irrelevant.  But a template as simple as possible is appropriate.
  2.  Disable the WYSIWYG editor on this new page, and give it an alias like news_rss
  3.  Optionally specify a page URL like news.rss (assumes pretty URL's are enabled)
  4.  Add {News summarytemplate='News Feed'} -- change the template name as appropriate
  5.  Save the page.

  To create an autodiscovery link
  1.  Edit the appropriate page template
  2.  add this tag to the head section of your template text:
      <link rel="alternate" type="application/rss+xml" href="{cms_selflink href="news_rss"/>
      See step 2 above where the page alias was specified.
*}

{* do the work *}
{foreach $items as $entry}
  {$txt=$entry->summary|default:$entry->content}
  {cgff_add feed='latest_news' title=$entry->title link=$entry->moreurl description=$txt date=$entry->postdate}
{/foreach}
{cgff_render feed='latest_news'}
