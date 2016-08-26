<div class="pageoptions">
  <a href="{cms_action_url action='admin_edit_feed'}">{admin_icon icon='newobject.gif' alt=''} {$mod->Lang('add_feed')}</a>
</div>

{if count($feeds)}
  <table class="pagetable">
    <thead>
      <tr>
        <th>{$mod->Lang('id')}</th>
        <th>{$mod->Lang('name')}</th>
        <th>{$mod->Lang('title')}</th>
	<th class="pageicon">{* edit *}</th>
	<th class="pageicon">{* delete *}</th>
      </tr>
    </thead>
    <tbody>
    {foreach $feeds as $feed}
      {cms_action_url action='admin_edit_feed' fid=$feed->id assign='edit_url'}
      <tr class="{cycle values='row1,row2'}">
        <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$feed->id}</a></td>
        <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$feed->name}</a></td>
        <td>{$feed->title|summarize}</td>
	<td><a href="{$edit_url}">{admin_icon icon='edit.gif' title=$mod->Lang('edit')}</td>
	<td><a href="{cms_action_url action=admin_delete_feed fid=$feed->id}">{admin_icon icon='delete.gif' title=$mod->Lang('delete')}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{/if}