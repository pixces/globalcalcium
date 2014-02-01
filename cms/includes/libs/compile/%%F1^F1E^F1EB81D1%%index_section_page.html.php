<?php /* Smarty version 2.6.22, created on 2009-06-11 16:21:58
         compiled from index_section_page.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'index_section_page.html', 28, false),)), $this); ?>
<div id="left_section">
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<?php if ($this->_tpl_vars['section_list']): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="tblHead" width="200">Section Title</td>
	<td class="tblHead">Image URL</td>
	<td class="tblHead" width="125">Link URL</td>
    <td class="tblHead" width="50">&nbsp;</td>
  </tr>
<?php $_from = $this->_tpl_vars['section_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sec']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['sec']['id']; ?>
">
    <td class="tblList"><strong><?php echo $this->_tpl_vars['sec']['name']; ?>
</strong></td>
    <td class="tblList"><?php echo $this->_tpl_vars['sec']['image']; ?>
</td>
    <td class="tblList"><?php echo $this->_tpl_vars['sec']['href']; ?>
</td>
    <td class="tblList">
    	<a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['sec']['id']; ?>
" onClick="editIndexSection(this.id)"><img src="images/ico_edit.png" alt="Edit Banner" width="16" height="16" border="0" /></a>
        <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['sec']['id']; ?>
" onClick="deleteIndexSection(this.id)"><img src="images/ico_delte.png" alt="Delete Banner" width="16" height="16" border="0" /></a>
    </td>
  </tr>
 <?php if ($this->_tpl_vars['sec']['sub']): ?> 
  <tr>
    <td colspan="5" style="padding-left:25px">
    	<table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
          <?php $_from = $this->_tpl_vars['sec']['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub']):
?>
          <tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#f4fae2,#FFF"), $this);?>
" id="row_<?php echo $this->_tpl_vars['sub']['id']; ?>
">
            <td class="tblList">
            	<strong><?php echo $this->_tpl_vars['sub']['name']; ?>
</strong><br /><?php echo $this->_tpl_vars['sub']['image']; ?>
 / <?php echo $this->_tpl_vars['sub']['href']; ?>

			</td>
            <td class="tblList" width="50">
                <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['sub']['id']; ?>
" onClick="editIndexSection(this.id)"><img src="images/ico_edit.png" alt="Edit Banner" width="16" height="16" border="0" /></a>
                <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['sub']['id']; ?>
" onClick="deleteIndexSection(this.id)"><img src="images/ico_delte.png" alt="Delete Banner" width="16" height="16" border="0" /></a>
            </td>
          </tr>
         <?php endforeach; endif; unset($_from); ?>
        </table>
    </td>
    </tr>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?> 
</table>

<?php else: ?>

<p>No Section found.</p>

<?php endif; ?>

</div>
<div id="right_section">
<fieldset>
<legend>Add/Update Section</legend>
<form method="post" action="home_ajax.php?opt=1" name="home_form" id="home_form">
<input type="hidden" name="mm_action" id="mm_action" value="doSection" />
<input type="hidden" name="sec_id" id="sec_id" value="" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr><td><label>Section Name:</label></td></tr>
  <tr><td><input type="text" name="sec_name" id="sec_name" style="width:250px;" /></td></tr>
  <tr><td><label>Section Content:</label></td></tr>
  <tr><td><textarea name="sec_data" id="sec_data" cols="" rows="7" style="width:250px;"></textarea></td></tr>
  <tr><td><label>Group this under:</label></td></tr>
  <tr><td id="combo_id"><?php echo $this->_tpl_vars['section_combo']; ?>
</td></tr>
  <tr><td><label>Image URL:</label></td></tr>
  <tr><td><input type="text" name="sec_image" id="sec_image" style="width:250px;" /></td></tr>
  <tr><td><label>Link URL:</label></td></tr>
  <tr><td><input type="text" name="sec_URL" id="sec_URL" style="width:250px;" /></td></tr>
  <tr><td><input type="submit" name="button" id="button" value="Submit" /></td></tr>
</table>
</form>
</fieldset>
</div>