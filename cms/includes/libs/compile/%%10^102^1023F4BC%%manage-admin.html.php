<?php /* Smarty version 2.6.22, created on 2009-07-02 23:01:26
         compiled from manage-admin.html */ ?>
<div id="left_section">
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<?php if ($this->_tpl_vars['adminList']): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="tblHead">Admin Name</td>
    <td class="tblHead">Admin Email</td>
    <td class="tblHead">Admin Username</td>
    <td class="tblHead">Admin Status</td>
    <td class="tblHead" width="50"></td>        
  </tr>
<?php $_from = $this->_tpl_vars['adminList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin']):
?>  
  <tr id="row_<?php echo $this->_tpl_vars['admin']->id; ?>
">
    <td class="tblList"><?php echo $this->_tpl_vars['admin']->first_name; ?>
&nbsp;<?php echo $this->_tpl_vars['admin']->last_name; ?>
</td>
    <td class="tblList"><?php echo $this->_tpl_vars['admin']->admin_email; ?>
</td>
    <td class="tblList"><?php echo $this->_tpl_vars['admin']->username; ?>
</td>
    <td class="tblList"><?php echo $this->_tpl_vars['admin']->admin_status; ?>
</td>        
    <td class="tblList">
    	<a href="?type=edit&id=<?php echo $this->_tpl_vars['admin']->id; ?>
" id="<?php echo $this->_tpl_vars['admin']->id; ?>
"><img src="images/ico_edit.png" alt="Edit Banner" width="16" height="16" border="0" /></a>
        <a href="?type=delete&id=<?php echo $this->_tpl_vars['admin']->id; ?>
" id="<?php echo $this->_tpl_vars['admin']->id; ?>
" onClick="return deleteAdmin();"><img src="images/ico_delte.png" alt="Delete Banner" width="16" height="16" border="0" /></a>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>  
</table>
<?php else: ?>
<p>No Sub Admin Found.</p>
<?php endif; ?>

</div>
<div id="right_section">
<fieldset>
<legend><?php echo $this->_tpl_vars['formName']; ?>
 Sub-Admin</legend>
<form method="post" action="" name="admin_form" id="admin_form">
<input type="hidden" name="mm_action" id="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['adminDet']->id; ?>
" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>Admin Name</label></td>
  </tr>
  <tr>
    <td><input name="fname" type="text" id="fname" maxlength="50" style="width:105px;" value="<?php echo $this->_tpl_vars['adminDet']->first_name; ?>
"/>
	
    <input name="lname" type="text" id="lname" maxlength="100" style="width:120px;" value="<?php echo $this->_tpl_vars['adminDet']->last_name; ?>
"/></td>
  </tr>
  <tr>
    <td>
		<label>Email Address</label><br />
        <span class="frmInstruction">A valid email id. All correspondences will be redirected to this email address.</span>
    </td>
  </tr>
  <tr>
    <td><input name="email" type="text" style="width:230px;" id="email" value="<?php echo $this->_tpl_vars['adminDet']->admin_email; ?>
"/></td>
  </tr>
  <tr>
    <td>
		<label>Admin Username</label><br />
        <span class="frmInstruction">Password will randomly generated and sent to the be sent Email above.</span>
    </td>
  </tr>
  <tr>
    <td><input name="username" type="text" style="width:230px;" id="username" value="<?php echo $this->_tpl_vars['adminDet']->username; ?>
"/></td>
  </tr>
  <tr>
    <td><label>Admin Status</label><br /></td>
  </tr>
  <tr>
    <td>
	<input name="admin_status" id="admin_status" type="radio" value="1" checked="checked" />Activate 
    <input name="admin_status" id="admin_status" type="radio" value="0" />Suspend
    </td>
  </tr>   
  <tr>
    <td>
		<label>Set Admin Permissions</label><br />
    </td>
  </tr>
  <tr>
    <td>
	    <input type="checkbox" name="permission[]" id="permission" value="man_link" <?php echo $this->_tpl_vars['man_link']; ?>
/>Manage Site Links<br />
        <input type="checkbox" name="permission[]" id="permission" value="man_content" <?php echo $this->_tpl_vars['man_content']; ?>
/>Manage Site Content<br />
        <input type="checkbox" name="permission[]" id="permission" value="man_portfolio" <?php echo $this->_tpl_vars['man_portfolio']; ?>
/>Manage Portfolio<br />
        <input type="checkbox" name="permission[]" id="permission" value="man_newsletter" <?php echo $this->_tpl_vars['man_newsletter']; ?>
/>Manage Newsletters<br />    
        <input type="checkbox" name="permission[]" id="permission" value="man_admin" <?php echo $this->_tpl_vars['man_admin']; ?>
/>Manage Admin
    </td>
  </tr>    
  <tr>
    <td><input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
</table>
</form>
</fieldset>
</div>