<?php /* Smarty version 2.6.22, created on 2011-05-11 19:17:11
         compiled from content_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'content_add.html', 19, false),)), $this); ?>
<script language="javascript" type="text/javascript">
	$(document).ready(function (){ CKEDITOR.replace('page_content'); });
</script>
<ul class="formDetail">
	<li>Use the form below to add the site content.</li>
</ul>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form id="addContent" name="addContent" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="contentId" value="<?php echo $this->_tpl_vars['contentDet']->content_id; ?>
" />
<table width="100%" border="0" cellpadding="2" cellspacing="0" id="contentTable">
  <tr>
    <td width="150" valign="top"><label>Link Name:</label></td>
    <td valign="top"><div align="left">
        <select name="linkList" class="frm" id="linkList" style="width:250px;" <?php echo $this->_tpl_vars['disable']; ?>
 >
          <option value="">-- Select Link --</option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['linkList'],'selected' => $this->_tpl_vars['contentDet']->content_link_id), $this);?>

        </select>
      </div></td>
    </div></td>
    </tr>
	
  <tr>
    <td width="150" valign="top"><label>Page Title:</label></td>
    <td valign="top"><div align="left">
      <input name="page_title" type="text" id="page_title" value="<?php echo $this->_tpl_vars['contentDet']->content_title; ?>
" maxlength="250" style="width:250px;"  onblur="addSefUrl()"/>
    </div></td>
    </tr>
  <tr>
      <td width="150" valign="top"><label>SEF URL:</label></td>
	  <td valign="top"><div align="left">
      <input name="sef_title" type="text" id="sef_title" maxlength="250" value="<?php echo $this->_tpl_vars['contentDet']->content_sef_title; ?>
" style="width:250px;" />
	  <span class="frmInstruction">All the special characters and spaces will be replaced with hyphens (-).</span>
    </div></td>
	</tr>
  <tr>  
    <td width="150" valign="top"><label>Page Content:</label></td>
    <td valign="top"><div align="left"><textarea name="page_content" id="page_content"><?php if ($this->_tpl_vars['contentDet']->content): ?><?php echo $this->_tpl_vars['pageContent']; ?>
<?php endif; ?></textarea></div></td>
    </tr>
	<!--
	<tr id="row_0">
    <td width="150" valign="top"><label>Content Image:</label></td>
    <td valign="top"><div align="left"><div id="addImage"><input type="file" name="content_image[]" id="content_image" accept="gif|jpeg" /> &nbsp; <a href="javascript:add_more();"><img src="images/plus.jpg" width="16" height="16" border="0" /></a>
	    <span class="frmInstruction">*Only (.png,.jpg,.jpeg,.gif) file allowed</span></div></div> 
	  </td>
    </tr> -->
	<tr>
     <td width="150" valign="top"><div align="left"></div></td>
     <td valign="top">
       <div align="left">
         <input type="submit" name="submit" id="submit" value="<?php echo $this->_tpl_vars['formName']; ?>
 Content" onClick="return validateContentForm();"/>
       </div></td>
    </tr>
</table>
<div id="removeDiv"></div>
</form>
