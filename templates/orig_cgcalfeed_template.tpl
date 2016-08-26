{*
  This is a template suitable for use as a news module summary template that will build an RSS feed from news items, using CGFeedFactory.
  Note: This template is created entirely dynamically.  and only uses the default settings from CGFeedFactory.

  To use this template.
  1.  Create a new blank content page, the template is irrelevant.  But a template as simple as possible is appropriate.
  2.  Disable the WYSIWYG editor on this new page, and give it an alias like calendar_rss
  3.  Optionally specify a page URL like calendar.rss (assumes pretty URL's are enabled)
  4.  Add {CGCalendar display=list listtemplate='CGCal Feed'} -- change the template name as appropriate, could also use pastlist as well.
  5.  Save the page.

  To create an autodiscovery link
  1.  Edit the appropriate page template
  2.  add this tag to the head section of your template text:
      <link rel="alternate" type="application/rss+xml" href="{cms_selflink href="calendar_rss"/>
      See step 2 above where the page alias was specified.
*}

{* note the feed parameter is not specific here... though it does have to be consistent to build a valid feed *}
{cgff_set feed='cgcal1' limit=3 title='CGCalendar Events'}
{cgff_set feed='cgcal1' description='The most recent CGCalendar events'}
{cgff_set feed='cgcal1' link="{root_url}"}
{foreach $events as $key => $event}
  {cgff_add feed='cgcal1' title=$event.event_title description=$event.event_details date=$event.event_date_start link=$event.url}
{/foreach}
{cgff_render feed='cgcal1'}