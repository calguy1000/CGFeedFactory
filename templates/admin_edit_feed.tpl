{if $feed->id}
<h3>{$mod->Lang('edit_feed')}</h3>
{else}
<h3>{$mod->Lang('add_feed')}</h3>
{/if}

{form_start fid=$feed->id}
<div class="pageoverflow">
  <p class="pageinput">
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
     <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>

{cge_start_tabs}
{cge_tabheader name='basic' label=$mod->Lang('feed_basics')}
{cge_tabheader name='advanced' label=$mod->Lang('feed_advanced')}


{cge_tabcontent_start name='basic'}
<div class="c_full cf">
  <label class="grid_2 required">{$mod->Lang('name')};</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}name" value="{$feed->name}" maxlength="255" placeholder="{$mod->Lang('ph_feedname')}" style="width: 100%;"/>
    <br/>{$mod->Lang('info_feedname')}
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2 required">{$mod->Lang('title')};</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}title" value="{$feed->title}" size="80" maxlength="255" placeholder="{$mod->Lang('ph_feedtitle')}" style="width: 100%;"/>
    <br/>{$mod->Lang('info_feedtitle')}
  </div>
</div>
{form_end}<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('description')};</label>
  <div class="grid_9">
    {cge_wysiwyg prefix=$actionid name=description value=$feed->description cols=100 rows=5}
    <br/>{$mod->Lang('info_feeddescription')}
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2 required">{$mod->Lang('image')};</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}image" value="{$feed->image}" size="80" maxlength="255" placeholder="{$mod->Lang('ph_feedimage')}" style="width: 100%;"/>
    <br/>{$mod->Lang('info_feedimage')}
  </div>
</div>

{cge_tabcontent_start name='advanced'}
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('limit')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}limit" value="{$feed->limit}" size="3" maxlength="3"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('copyright')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}copyright" value="{$feed->copyright}" style="width: 100%;" placeholder="{$mod->Lang('optional_copyright_string')}"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('managing_editor')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}managing_editor" value="{$feed->managing_editor}" style="width: 100%;" placeholder="{$mod->Lang('email_address')}"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('admin_email')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}admin_email" value="{$feed->admin_email}" style="width: 100%;" placeholder="{$mod->Lang('email_address')}"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('language_code')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}lang" value="{$feed->lang}" size="5" maxlength="5"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('content_type')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}content_type" value="{$feed->content_type}" style="width: 100%;"/>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('timetolive')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}ttl" value="{$feed->ttl}" size="3" maxlength="3"/>
  </div>
</div>

{cge_end_tabs}
{form_end}