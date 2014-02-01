<?php /* Smarty version 2.6.22, created on 2011-05-07 23:18:15
         compiled from link_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'link_list.html', 67, false),)), $this); ?>
<div id="link_list" style="float:left; width:690px; margin-right:20px;">

<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left">Found: <b><?php echo $this->_tpl_vars['total_category']; ?>
 Links </b></div></td>
    <td><div align="right"></div></td>
  </tr>
</table>
</div>
<?php if ($this->_tpl_vars['linkList']): ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td class="tblHead"><div align="left">Link Name</div></td>

    <td class="tblHead"></td>
  </tr>
  <tr>
    <?php $_from = $this->_tpl_vars['linkList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
	<td class="tblList" align="left"><b>
	<!--	<?php if (( $this->_tpl_vars['link']['type_flag'] ) == 0): ?>  <?php else: ?> - Secondary - <?php endif; ?> -->
		<?php if (( $this->_tpl_vars['link']['parent_flag'] == 0 )): ?>
			
			<?php echo $this->_tpl_vars['link']['link_name']; ?>
	<!-- Displaying the main links -->
		<?php else: ?>
			-- <?php echo $this->_tpl_vars['link']['link_name']; ?>
	<!-- Displaying the sub links -->
		<?php endif; ?>
	</b></td>
    <td class="tblList" align="left">
        <a href="?type=edit&link_id=<?php echo $this->_tpl_vars['link']['linkId']; ?>
" id="<?php echo $this->_tpl_vars['link']['linkId']; ?>
"><img id="<?php echo $this->_tpl_vars['link']['linkId']; ?>
" src="images/ico_edit.png" alt="edit" border="0" /></a>
        <a href="?type=delete&link_id=<?php echo $this->_tpl_vars['link']['linkId']; ?>
" id="<?php echo $this->_tpl_vars['link']['linkId']; ?>
" onClick="return deletelink('<?php echo $this->_tpl_vars['link']['link_name']; ?>
');"><img id="<?php echo $this->_tpl_vars['link']['linkId']; ?>
" src="images/ico_delte.png"  alt="delete" border="0" /></a>
     </td>
  </tr>
  	<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>
</div>


<div id="link_form">
<fieldset>
<legend><?php echo $this->_tpl_vars['formName']; ?>
&nbsp;Link</legend>
<p class="formDetail">Use the form below to add/edit link details. All fields are mandatory to be filled.</p>
<div id="form">
<form name="add" method="post" action="">
<input type="hidden" name="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="linkId" value="<?php echo $this->_tpl_vars['linkdetail']->link_id; ?>
" />
  <table cellpadding="2" cellspacing="0">
    <tr>
      <td valign="top"><div align="left"><label>Link Name:</label></div></td>	  
      </tr>
    <tr>
      <td valign="top">
          <div align="left">
            <input type="text" name="linkName" id="linkName" value="<?php echo $this->_tpl_vars['linkDet']->link_name; ?>
" class="frm" />
          </div></td>
      </tr>
    <tr>
      <td valign="top"><div align="left"><label>Parent Link:</label></div></td>
      </tr>
    <tr>
      <td valign="top"><div align="left">
        <select name="parentLink" id="parentLink" class="frm" onChange="return showOrHide();" />
          <option value="0">-- Main Link --</option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['pLinks'],'selected' => $this->_tpl_vars['linkDet']->link_parent), $this);?>

        </select>
      </div></td>
      </tr>
    <tr>
      <td valign="top"><div align="left"><label>Link Type:</label></div></td>
      </tr>
    <tr>
      <td valign="top"><div align="left">
        <input name="rd_linktype" type="radio" id ="rd_primary" value="0" <?php echo $this->_tpl_vars['linkTypeP']; ?>
 style="width:15px;" />
        Primary
        <input name="rd_linktype" type="radio" id ="rd_secondary" value="1" <?php echo $this->_tpl_vars['linkTypeS']; ?>
 style="width:15px;" />
        Secondary</div></td>
      </tr>
	  <tr>
      <td valign="top"><div align="left"><label>Order:</label></div></td>	  
      </tr>
	<tr>
      <td valign="top"><div align="left">
        <input type="text" name="orderLink" id="orderLink" value="<?php echo $this->_tpl_vars['linkDet']->link_order; ?>
" size="4" maxlength="2" <?php echo $this->_tpl_vars['disabled']; ?>
>
      </tr>
    <tr>
      <td valign="top">
        <div align="center">
          <input type="submit" name="submit" value="<?php echo $this->_tpl_vars['formName']; ?>
&nbsp;Link" style="width:100px;" onClick="return validateForm();" />
          </div>
	  </td>
      </tr>
  </table>
</form>
</div>
</fieldset>
</div>
<div class="clearfloat"></div>