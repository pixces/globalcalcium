<?php /* Smarty version 2.6.22, created on 2009-07-07 23:57:35
         compiled from portfolio_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'portfolio_add.html', 29, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form method="post" action="" name="portf_form" id="portf_form" enctype="multipart/form-data">
<input type="hidden" name="mm_action" id="mm_action" value="<?php echo $this->_tpl_vars['formAction']; ?>
" />
<input type="hidden" name="portf_id" id="portf_id" value="<?php echo $this->_tpl_vars['portfDtls']->img_id; ?>
" />
<table width="52%" height="236" border="0" cellpadding="2" cellspacing="2">
<tr>
    <td width="140" valign="top" align="left"><label>Image Title</label></td>
    <td width="324"><input name="portf_title" type="text" id="portf_title" style="width:250px;" value="<?php echo $this->_tpl_vars['portfDtls']->img_title; ?>
"/></td>
  </tr>
  <tr>
    <td width="140" valign="top" align="left"><label>Image Alt Name</label></td>
    <td width="324"><input name="portf_alt" type="text" id="portf_alt" style="width:250px;" size="100" value="<?php echo $this->_tpl_vars['portfDtls']->img_alt; ?>
"/></td>
  </tr>
  <tr>
    <td width="140" valign="top" align="left"><label>External Reference Link</label></td>
    <td width="324"><input name="ext_link" type="text" id="ext_link" style="width:250px;" size="250" value="<?php echo $this->_tpl_vars['portfDtls']->img_ext_link; ?>
"/></td>
  </tr>
  <tr>
    <td width="140" valign="top" align="left"><label>Select Portfolio Image</label></td>
    <td width="324"><input name="portf_img" type="file" id="portf_img" style="width:250px;"/></td>
  </tr>
  <tr>
    <td width="140" valign="top" align="left"><label>Select Portfolio category</label></td>
    <td width="324">
		 <select name="portf_categ" id="portf_categ" style="width:250px;">
         	<option value="">-- Select Category --</option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['subLinkList'],'selected' => $this->_tpl_vars['portfDtls']->img_cat_id), $this);?>

		</select>
	</td>
  </tr>
  <tr>
    <td width="140" valign="center" align="left"><label>Add Short Description</label></td>
    <td><textarea name="portf_desc" id="portf_desc" style="width:250px; height:100px;" onKeyDown="return limtTextArea();"><?php echo $this->_tpl_vars['portfDtls']->img_detail; ?>
</textarea>
	</td>	
  </tr>
  <tr>
  	<td></td><td><span id="charCount"></span></td>
  </tr>
  <tr>
    <td width="160"><input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
</table>
</form>
<?php if (( $this->_tpl_vars['formAction'] ) == 'doEditPortfolio'): ?>
<div id="img_pos"><img src="../upload/portfolio/<?php echo $this->_tpl_vars['portfDtls']->img_path; ?>
" id="<?php echo $this->_tpl_vars['portfDtls']->img_id; ?>
" alt="Portfolio Image" ></div>
<?php endif; ?>