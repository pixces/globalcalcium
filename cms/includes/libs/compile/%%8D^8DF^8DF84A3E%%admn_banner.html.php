<?php /* Smarty version 2.6.22, created on 2009-06-11 16:12:19
         compiled from admn_banner.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'admn_banner.html', 15, false),)), $this); ?>
<div id="left_section">
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<?php if ($this->_tpl_vars['banner_list']): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="tblHead" width="100">Banner Image</td>
    <td class="tblHead">Comments</td>
    <td class="tblHead" width="50">&nbsp;</td>
  </tr>
<?php $_from = $this->_tpl_vars['banner_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['banner']):
?>  
  <tr id="row_<?php echo $this->_tpl_vars['banner']->banner_id; ?>
">
    <td class="tblList"><img src="../banners/<?php echo $this->_tpl_vars['banner']->banner_image; ?>
" alt="<?php echo $this->_tpl_vars['banner']->banner_image; ?>
" title="<?php echo $this->_tpl_vars['banner']->banner_image; ?>
" height="30" /></td>
    <td class="tblList"><?php echo ((is_array($_tmp=$this->_tpl_vars['banner']->banner_comment)) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
</td>
    <td class="tblList">
    	<a href="javascript:void(0)" onclick="banner_edit(this.id)" id="<?php echo $this->_tpl_vars['banner']->banner_id; ?>
"><img src="images/ico_edit.png" alt="Edit Banner" width="16" height="16" border="0" /></a>
        <a href="javascript:void(0)" onclick="banner_delete(this.id)" id="<?php echo $this->_tpl_vars['banner']->banner_id; ?>
"><img src="images/ico_delte.png" alt="Delete Banner" width="16" height="16" border="0" /></a>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>  
</table>
<?php else: ?>
<p>No Banners found.</p>
<?php endif; ?>

</div>
<div id="right_section">
<fieldset>
<legend>Add/Update Banners</legend>
<form method="post" action="banner_ajax.php?opt=1" name="banner_form" id="banner_form" enctype="multipart/form-data">
<input type="hidden" name="mm_action" id="mm_action" value="doBanner" />
<input type="hidden" name="ban_id" id="ban_id" value="" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>Upload Banner Image</label></td>
  </tr>
  <tr>
    <td><input name="ban_img" id="ban_img" type="file" value="" /></td>
  </tr>
  <tr>
    <td>
		<label>Add Comments</label><br />
		<span class="frmInstruction">HTML tags can be used to provide rich appearnce.</span>
    </td>
  </tr>
  <tr>
    <td><textarea name="comments" id="comments" cols="" rows="7" style="width:250px;"></textarea></td>
  </tr>
  <tr>
    <td><input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
</table>
</form>
<hr size="1" noshade="noshade"  />
<div><label>Switch Banner Rotaion</label></div>
<div>
	<input name="banners_opt" id="banners_opt" type="radio" value="1" onclick="set_ban_rotation(this.value)" <?php echo $this->_tpl_vars['ban_on']; ?>
 />ON 
    <input name="banners_opt" id="banners_opt" type="radio" value="0" onclick="set_ban_rotation(this.value)" <?php echo $this->_tpl_vars['ban_off']; ?>
 />Off
 </div>
<div class="frmInstruction">ON: banners will change automatically after a fix interval. OFF: banners will only change on page refresh.</div>
</fieldset>
</div>