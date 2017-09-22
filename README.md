CGFeedFactory for CMS Made Simple
=================================

> Copyright (c) 2016 Robert Campbell <calguy1000@gmail.com>

What does this do?
------------------
This is a small utility module that provides smarty plugins to allow creating RSS Feeds from data within your CMS Made Simple powered website.

Features
--------
1. Supports images
2. Completely customizable via the standard CMSMS method for modifying system templates.
3. Provides smarty plugins to add items to feeds
4. Provides an admin panel to enter default values for many of the feed fields
5. Provides an admin interface to allow defining the basic information for feeds.
6. Includes numerous sample templates for building different types of feeds.
7. Create a single feed from multiple different modules.

Your First Feed
---------------
1. Create a new content page using the Content Manager
2. Select the "Minimal" Template, turn off the wysiwyg editor, and set the page alias to something like "news_rss"
   **Note:** _It does not really matter what template you choose, but a simple template with minimal markup iss usually suitable as later methods will kill any output and override the output mime type. 
3. Optionally, if using pretty urls, set the page url for this feed to something line "news.rss".

    **Note:** _Some feed readers will recognize the .rssextension._

4. In the content area for the new content page add.

    `{News summarytemplate='News Feed'}`

    **Note:** The CGFeedMFeedFactory module created a new template called "News Feed" when it was installed.
5. Save the page.

Smarty Plugins
--------------
### ```{cgff_set [feed=string] [argument=value]*}``` - Set one or more aguments into a feed.

> **Note:** A feed must have at a minimum a link, a title, and a description.

**Arguments**
* feed - (optional string).  The name of the feed.  If the feed already exists in the database it will be loaded into memoryy and the arguments provided in the tag will be used to override the values saved in the database.  If the feed does not already exist in the database, then a new feed object will be created in memory.  If no feed argument is supplied then a hard coded name is used as a default.
* title - (optional string).  Set, or override the title for the feed
* link - (optional string).  Set, or override the URL for this feed.
* description - (optional string).  Set, or override the description for this feed
* lang - (optional string).  Set, or override the language code for this feed
* generator - (optional string).  Set, or override the generator for the feed.
* copyright - (optional string).  Set, or override the copyright for the feed.
* managing_editor - (optional string).  Set, or override the email address of the managing editor for the feed.
* admin_email - (optional string).  Set, or override the email address of the webmaster for the feed.
* image - (optional string).  Set, or override the URL to an image for the feed
* unseorted - (optional bool).  Set, or override the sorting flag for the feed.  By default feed items are sorted.
* ttl - (optional int).  The time-to-live for this feed.  A minimum value of 1 is required.
* limit - (optional int).  The maximum number of entries for this feed.  A minimum value of 1 is required

**i.e:**

    {cgff_set feed='myfeed' link="{root_url}" title="Latest News"}

### ```{cgff_add [feed=string] [argument=value]*}``` - Add an item to a feed
> **Note:** Each feed item requires a title, a link, a description, and a date

**Arguments:**
* feed - (optional string).  The name of the feed.  If the feed already exists in the database it will be loaded into memoryy and the arguments provided in the tag will be used to override the values saved in the database.  If the feed does not already exist in the database, then a new feed object will be created in memory.  If no feed argument is supplied then a hard coded name is used as a default.
* title - (required string).  the title for the item.
* link - (required string).  the URL for this item.
* description - (required string).  the description for this item
* date - (required mixed).  the date for this item.  This can either be a unix timestamp or a DATETIME value from the database, or any other string that can be converted to a unix timestamp easily via php.  On output this value is formatted as an rfc date.
* author - (optional string).  An email address for the author of the itemm.
* guid - (optional string).  An optional unique identifier for the item.

**i.e.:**
```
{cgff_add feed='myfeed' link=$entry->detail_url title=$entry->title description=$entry->content date=$entry->lastModified}
```

### `{cgff_render [feed=string] [template=string]}` - Render the RSS Feed
> **Note:** This method will clear any content already output, and change the content type of the page to that specified for the feed.  Afterwards, it will exit execution of the php script.

**Arguments:**
* feed - (optional string).  The name of the feed to render.   If this parameter is not specified, then a hardcoded name will be used (__DFLT).  The feed must already exist in memory in order to be rendered.
* template - (optional string).  Specify the name of a non-default template.  Specify any valid smarty resource, i.e: cms_template::stuff to use a DesignManager template named stuff.  If the template name ends with .tpl then a file template in the module directory, or module_custom/CGFeedFactory/templates directory is assumed.

Support
-------
* The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:
* A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgextensions">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.
* Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.
* The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.
* Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.
