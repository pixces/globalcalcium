<?php /* Smarty version 2.6.22, created on 2011-07-07 17:38:34
         compiled from event_list.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left">Found: <b><?php echo $this->_tpl_vars['count']; ?>
 Event(s)</b></div></td>
    <td><div align="right"></div></td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td class="tblHead"><div align="left">Event Title</div></td>
    <td class="tblHead" width="200"><div align="left">Location</div></td>
	<td class="tblHead" width="150"><div align="left">Event Date</div></td>
	<td class="tblHead" width="50"><div align="left"></div></td>
  </tr>
  <tr>
    <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?>
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['event']->news_title; ?>
</b></td>
	<td class="tblList" align="left"><?php echo $this->_tpl_vars['event']->news_location; ?>
</td>
	<td class="tblList" align="left"><?php echo $this->_tpl_vars['event']->news_date; ?>
</td>
	<td class="tblList" align="left">
        <a href="?type=edit&id=<?php echo $this->_tpl_vars['event']->id; ?>
" id="<?php echo $this->_tpl_vars['event']->id; ?>
">
        	<img id="<?php echo $this->_tpl_vars['event']->id; ?>
" src="images/ico_edit.png" alt="edit" title="Edit Event" border="0"/>
        </a>
        <a href="?type=delete&id=<?php echo $this->_tpl_vars['event']->id; ?>
" id="<?php echo $this->_tpl_vars['event']->id; ?>
" onClick="return deleteproduct();">
        	<img id="<?php echo $this->_tpl_vars['event']->id; ?>
" src="images/ico_delete.png" alt="delete" title="Delete Event" border="0" />
        </a>
     </td>
  </tr>
  	<?php endforeach; endif; unset($_from); ?>
</table>
<p class="button" style="float:right; margin-top:20px;"><a href="?type=add">Add New Event</a></p>