<h1 id="cgfeedfactoryforcmsmadesimple">CGFeedFactory for CMS Made Simple</h1>

<blockquote>
  <p>Copyright (c) 2016 Robert Campbell <a href="&#x6d;&#97;&#x69;&#x6c;&#116;o:&#99;&#x61;&#108;&#x67;&#x75;&#x79;&#49;&#x30;&#48;&#x30;&#64;g&#109;&#97;&#x69;&#x6c;.&#x63;&#111;&#x6d;">&#99;&#x61;&#108;&#x67;&#x75;&#x79;&#49;&#x30;&#48;&#x30;&#64;g&#109;&#97;&#x69;&#x6c;.&#x63;&#111;&#x6d;</a></p>
</blockquote>

<h2 id="whatdoesthisdo">What does this do?</h2>

<p>This is a small utility module that provides smarty plugins to allow creating RSS Feeds from data within your CMS Made Simple powered website.</p>

<h2 id="features">Features</h2>

<ol>
<li>Supports images</li>

<li>Completely customizable via the standard CMSMS method for modifying system templates.</li>

<li>Provides smarty plugins to add items to feeds</li>

<li>Provides an admin panel to enter default values for many of the feed fields</li>

<li>Provides an admin interface to allow defining the basic information for feeds.</li>

<li>Includes numerous sample templates for building different types of feeds.</li>

<li>Create a single feed from multiple different modules.</li>
</ol>

<h2 id="yourfirstfeed">Your First Feed</h2>

<ol>
<li><p>Create a new content page using the Content Manager</p></li>

<li><p>Select the "Minimal" Template, turn off the wysiwyg editor, and set the page alias to something like "news_rss"
<strong>Note:</strong> _It does not really matter what template you choose, but a simple template with minimal markup iss usually suitable as later methods will kill any output and override the output mime type. </p></li>

<li><p>Optionally, if using pretty urls, set the page url for this feed to something line "news.rss".</p>

<p><strong>Note:</strong> <em>Some feed readers will recognize the .rssextension.</em></p></li>

<li><p>In the content area for the new content page add.</p>

<p><code>{News summarytemplate='News Feed'}</code></p>

<p><strong>Note:</strong> The CGFeedMFeedFactory module created a new template called "News Feed" when it was installed.</p></li>

<li><p>Save the page.</p></li>
</ol>

<h2 id="smartyplugins">Smarty Plugins</h2>

<h3 id="cgff_setfeedstringargumentvaluesetoneormoreagumentsintoafeed"><code>{cgff_set [feed=string] [argument=value]*}</code> - Set one or more aguments into a feed.</h3>

<blockquote>
  <p><strong>Note:</strong> A feed must have at a minimum a link, a title, and a description.</p>
</blockquote>

<p><strong>Arguments</strong></p>

<ul>
<li>feed - (optional string).  The name of the feed.  If the feed already exists in the database it will be loaded into memoryy and the arguments provided in the tag will be used to override the values saved in the database.  If the feed does not already exist in the database, then a new feed object will be created in memory.  If no feed argument is supplied then a hard coded name is used as a default.</li>

<li>title - (optional string).  Set, or override the title for the feed</li>

<li>link - (optional string).  Set, or override the URL for this feed.</li>

<li>description - (optional string).  Set, or override the description for this feed</li>

<li>lang - (optional string).  Set, or override the language code for this feed</li>

<li>generator - (optional string).  Set, or override the generator for the feed.</li>

<li>copyright - (optional string).  Set, or override the copyright for the feed.</li>

<li>managing_editor - (optional string).  Set, or override the email address of the managing editor for the feed.</li>

<li>admin_email - (optional string).  Set, or override the email address of the webmaster for the feed.</li>

<li>image - (optional string).  Set, or override the URL to an image for the feed</li>

<li>unseorted - (optional bool).  Set, or override the sorting flag for the feed.  By default feed items are sorted.</li>

<li>ttl - (optional int).  The time-to-live for this feed.  A minimum value of 1 is required.</li>

<li>limit - (optional int).  The maximum number of entries for this feed.  A minimum value of 1 is required</li>
</ul>

<p><strong>i.e:</strong></p>

<pre><code>{cgff_set feed='myfeed' link="{root_url}" title="Latest News"}
</code></pre>

<h3 id="cgff_addfeedstringargumentvalueaddanitemtoafeed"><code>{cgff_add [feed=string] [argument=value]*}</code> - Add an item to a feed</h3>

<blockquote>
  <p><strong>Note:</strong> Each feed item requires a title, a link, a description, and a date</p>
</blockquote>

<p><strong>Arguments:</strong></p>

<ul>
<li>feed - (optional string).  The name of the feed.  If the feed already exists in the database it will be loaded into memoryy and the arguments provided in the tag will be used to override the values saved in the database.  If the feed does not already exist in the database, then a new feed object will be created in memory.  If no feed argument is supplied then a hard coded name is used as a default.</li>

<li>title - (required string).  the title for the item.</li>

<li>link - (required string).  the URL for this item.</li>

<li>description - (required string).  the description for this item</li>

<li>date - (required mixed).  the date for this item.  This can either be a unix timestamp or a DATETIME value from the database, or any other string that can be converted to a unix timestamp easily via php.  On output this value is formatted as an rfc date.</li>

<li>author - (optional string).  An email address for the author of the itemm.</li>

<li>guid - (optional string).  An optional unique identifier for the item.</li>
</ul>

<p><strong>i.e.:</strong></p>

<pre><code>{cgff_add feed='myfeed' link=$entry-&gt;detail_url title=$entry-&gt;title description=$entry-&gt;content date=$entry-&gt;lastModified}
</code></pre>

<h3 id="cgff_renderfeedstringtemplatestringrendertherssfeed"><code>{cgff_render [feed=string] [template=string]}</code> - Render the RSS Feed</h3>

<blockquote>
  <p><strong>Note:</strong> This method will clear any content already output, and change the content type of the page to that specified for the feed.  Afterwards, it will exit execution of the php script.</p>
</blockquote>

<p><strong>Arguments:</strong></p>

<ul>
<li>feed - (optional string).  The name of the feed to render.   If this parameter is not specified, then a hardcoded name will be used (__DFLT).  The feed must already exist in memory in order to be rendered.</li>

<li>template - (optional string).  Specify the name of a non-default template.  If the name ends with .tpl then a file template in the module directory, or module_custom/CGFeedFactory/templates directory is assumed.</li>
</ul>

<h2 id="support">Support</h2>

<ul>
<li>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</li>

<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgextensions">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>

<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>

<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>

<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>
