{form_start}
<div class="information cf">
  {$mod->Lang('info_settings')}
</div>
<div class="pageoverflow">
   <p class="pageinput">
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
     <input type="submit" name="{$actionid}reset" value="{$mod->Lang('reset')}"/>
   </p>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('managing_editor')}:</label>
  <input class="grid_9" name="{$actionid}managing_editor" value="{$settings->managing_editor}"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('admin_email')}:</label>
  <input class="grid_9" name="{$actionid}admin_email" value="{$settings->admin_email}"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('copyright')}:</label>
  <input class="grid_9" name="{$actionid}copyright" value="{$settings->copyright}"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('content_type')}:</label>
  <input class="grid_9" name="{$actionid}content_type" value="{$settings->content_type}"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('generator')}:</label>
  <input class="grid_9" name="{$actionid}generator" value="{$settings->generator}"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('language_code')}:</label>
  <input class="grid_1" name="{$actionid}lang" value="{$settings->lang}" maxlength="5"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('limit')}:</label>
  <input class="grid_1" name="{$actionid}limit" value="{$settings->limit}" maxlength="3"/>
</div>
<div class="c_full cf">
  <label class="grid_2 text-right">{$mod->Lang('timetolive')}:</label>
  <input class="grid_1" name="{$actionid}ttl" value="{$settings->ttl}" maxlength="3"/>
</div>
{form_end}