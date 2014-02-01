<?php /* Smarty version 2.6.22, created on 2011-07-20 18:47:09
         compiled from meta_tag.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'meta_tag.html', 37, false),)), $this); ?>
<ul class="formDetail">
<li>Use the form below to add all Meta Information for the selected link.</li>
</ul>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form name="metaTag_form" id="metaTag_form" action="" method="post" />
<input type="hidden" name="mm_action" id="mm_action" value="doAddMeta" />
<input type="hidden" name="linkId" id="linkId" value="<?php echo $this->_tpl_vars['linkId']; ?>
" />
<input type="hidden" name="link_type" id="link_type" value="<?php echo $this->_tpl_vars['section']; ?>
" />
<table width="100%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td width="175" valign="top"><label>Page Name:</label></td>
		<td valign="top"><div align="left">
		<input name="link_name" type="text" id="link_name" value="<?php echo $this->_tpl_vars['page_name']; ?>
" style="width:400px;" readonly="true"/>
		</div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Page Title:</label></td>
		<td valign="top"><div align="left">
		<input name="page_title" type="text" id="page_title" value="<?php echo $this->_tpl_vars['metaDtls']['page_title']; ?>
" style="width:400px;"/>
		</div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Desciption:</label></td>
		<td valign="top"><div align="left"><textarea name="metaDesc" id="metaDesc" style="width:400px; height:100px;"><?php echo $this->_tpl_vars['metaDtls']['meta_description']; ?>
</textarea></div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Keywords:</label></td>
		<td valign="top"><div align="left"><textarea name="metaKey" id="metaKey" style="width:400px; height:50px;"><?php echo $this->_tpl_vars['metaDtls']['meta_key']; ?>
</textarea></div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Robots:</label></td>
		<td valign="top"><div align="left">
			<select name="metaRobots" id="metaRobots">
			  <option value="">-- Select One --</option>
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['robotArray'],'selected' => $this->_tpl_vars['metaDtls']['meta_robots']), $this);?>

			</select>
	</div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Author:</label></td>
		<td valign="top"><div align="left">
		<input name="metaAuthor" type="text" id="metaAuthor" value="<?php echo $this->_tpl_vars['metaDtls']['meta_author']; ?>
" style="width:400px;"/>
		</div></td>
	</tr>
	<tr>
		<td width="175" valign="top"><label>Custom Meta Tag / Verification Code:</label></td>
		<td valign="top"><div align="left">
		<input name="metaCustom" type="text" id="metaCustom"  style="width:400px;" value="<?php echo $this->_tpl_vars['custom1']; ?>
"/>		
		</div></td>
	</tr>
		<tr>
		<td width="175" valign="top"><label></label></td>
		<td valign="top"><div align="left">
		<input name="metaCustom2" type="text" id="metaCustom2" style="width:400px;" value="<?php echo $this->_tpl_vars['custom2']; ?>
"/>				
		<div class="frmInstruction"> Ex: &lt;meta name="abc" content="ABC, pqr, xyz" /&gt;</div></div>
		</td>
		
	</tr>
	<tr>
     <td width="175" valign="top"><div align="left"></div></td>
     <td valign="top">
       <div align="left">
         <input type="submit" name="submit" id="submit" value="Add Meta" onClick="return validateMeta();" />   
       </div></td>
    </tr>
</table>
</form>