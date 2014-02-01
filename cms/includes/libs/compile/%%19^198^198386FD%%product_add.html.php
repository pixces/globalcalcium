<?php /* Smarty version 2.6.22, created on 2011-08-11 19:39:27
         compiled from product_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'product_add.html', 20, false),)), $this); ?>
<script language="javascript" type="text/javascript">
	$(document).ready(function (){ CKEDITOR.replace('product_details'); });
</script>
<ul class="formDetail">
	<li>Use the form below to add the Products.</li>
</ul>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form id="addContent" name="addContent" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="productId" value="<?php echo $this->_tpl_vars['productDet']->id; ?>
" />
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="150" valign="top"><label><div align="right">Product Category:</div></label></td>
    <td width="10" valign="top"><div align="left"></div></td>
    <td valign="top">
        <div align="left">
          <select name="productList" class="frm" id="productList" style="width:256px;" <?php echo $this->_tpl_vars['disable']; ?>
 >
            <option value="0">-- Select Category --</option><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['ProductGroupList'],'selected' => $this->_tpl_vars['productDet']->parent_id), $this);?>
</select>
        </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">Product Name:</div></label></td>
    <td valign="top"><div align="left"></div></td>
    <td valign="top">
        <div align="left">
          <input name="product_name" type="text" id="page_title" value="<?php echo $this->_tpl_vars['productDet']->name; ?>
" maxlength="250" style="width:250px;"  onblur="addSefUrl()"/>
      </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">SEF Name:</div></label></td>
    <td valign="top"><div align="left"></div></td>
    <td valign="top">
      
        <div align="left">
          <input name="sef_title" type="text" id="sef_title" maxlength="250" value="<?php echo $this->_tpl_vars['productDet']->sef_name; ?>
" style="width:250px;" />
      </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">Product Formula:</div></label></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <input name="product_formula" type="text" id="product_formula" maxlength="250" value="<?php echo $this->_tpl_vars['productDet']->formula; ?>
" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">Product Weight:</div></label></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <input name="product_weight" type="text" id="product_weight" value="<?php echo $this->_tpl_vars['productDet']->weight; ?>
" maxlength="250" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">Product CSA No.:</div></label></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <input name="product_cas_no" type="text" id="product_cas_no" value="<?php echo $this->_tpl_vars['productDet']->cas_number; ?>
" maxlength="250" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><label><div align="right">Product Group:</div></label></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <select name="product_group[]" multiple="multiple" class="frm" style="width:256px;" size="4">
        <option value="">-- Select Groups --</option><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['product_groups'],'selected' => $this->_tpl_vars['groups']), $this);?>
    
      </select>
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"><label><div align="right">Product Tests:</div></label></div></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <textarea name="product_details" id="product_details"><?php if ($this->_tpl_vars['productDet']->details): ?><?php echo $this->_tpl_vars['productDet']->details; ?>
<?php endif; ?></textarea>
    </div></td>
  </tr>
  <tr>
    <td width="150"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <input type="submit" name="submit" id="submit" value="<?php echo $this->_tpl_vars['formName']; ?>
 Products" onclick="return validateProductForm();"/>
    </div></td>
  </tr>
</table>
</form>