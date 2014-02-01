<?php /* Smarty version 2.6.22, created on 2009-07-07 23:53:22
         compiled from portfolio.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<?php if ($this->_tpl_vars['portfolList']): ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="tblHead" width="100">Portfolio Title</td>
	<td class="tblHead" width="100">Image Alt Name</td>
	<td class="tblHead" width="100">Reference Link</td>
    <td class="tblHead">Comments</td>
	<td class="tblHead">Category</td>
    <td class="tblHead" width="50">&nbsp;</td>
  </tr>
<?php $_from = $this->_tpl_vars['portfolList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['portfolio']):
?>  
  <tr id="row_<?php echo $this->_tpl_vars['portfolio']->img_id; ?>
">
    <td class="tblList" align="left"><a href="#" class="preview" id="../upload/portfolio/<?php echo $this->_tpl_vars['portfolio']->img_path; ?>
"><?php echo $this->_tpl_vars['portfolio']->img_title; ?>
</a></td>
	<td class="tblList" align="left"><?php echo $this->_tpl_vars['portfolio']->img_alt; ?>
</td>
	<td class="tblList" align="left"><?php echo $this->_tpl_vars['portfolio']->img_ext_link; ?>
</td>
    <td class="tblList" align="left"><?php echo $this->_tpl_vars['portfolio']->img_detail; ?>
</td>
	<td class="tblList" align="left"><?php echo $this->_tpl_vars['portfolio']->link_name; ?>
</td>
    <td class="tblList">
    	<a href="?type=edit&id=<?php echo $this->_tpl_vars['portfolio']->img_id; ?>
" id="<?php echo $this->_tpl_vars['portfolio']->img_id; ?>
"><img src="images/ico_edit.png" alt="Edit Portfolio" width="16" height="16" border="0" /></a>
        <a href="javascript:void(0)" onclick="portf_delete(this.id)" id="<?php echo $this->_tpl_vars['portfolio']->img_id; ?>
"><img src="images/ico_delte.png" alt="Delete Portfolio" width="16" height="16" border="0" /></a>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>  
</table>
<?php else: ?>
<p></p>
<?php endif; ?>
<p class="button" style="float:right; margin-top:20px;"><a href="?type=add">Add Portfolio</a></p>
</div>
<div id="edit_nav"></div>