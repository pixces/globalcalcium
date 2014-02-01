<?php /* Smarty version 2.6.22, created on 2011-07-20 18:49:09
         compiled from product_list.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left">Found: <b><?php echo $this->_tpl_vars['products_count']; ?>
 Products </b></div></td>
    <td><div align="right"></div></td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td class="tblHead"><div align="left">Product Name</div></td>
    <td class="tblHead" width="200"><div align="left"></div></td>
	<td class="tblHead" width="125"><div align="left">Latest</div></td>
	<td class="tblHead" width="75"><div align="left"></div></td>
  </tr>
  <tr>
    <?php $_from = $this->_tpl_vars['productList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['product']['name']; ?>
</b></td>
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['product']->sef_name; ?>
</b></td>
	<td class="tblList" align="left"><b>
    	<?php if ($this->_tpl_vars['product']['latest'] == 1): ?>
        	<a href="?type=status&change=unmark&id=<?php echo $this->_tpl_vars['product']['id']; ?>
" class="marked">&nbsp;</a>
        <?php else: ?>
        	<a href="?type=status&change=mark&id=<?php echo $this->_tpl_vars['product']['id']; ?>
" class="unmarked">&nbsp;</a>
        <?php endif; ?>
        </b></td>
	<td class="tblList" align="left">
        <a href="?type=edit&id=<?php echo $this->_tpl_vars['product']['id']; ?>
" id="<?php echo $this->_tpl_vars['product']['id']; ?>
">
        	<img id="<?php echo $this->_tpl_vars['product']['id']; ?>
" src="images/ico_edit.png" alt="edit" title="Edit product" border="0"/>
        </a>
        <a href="?type=tests&id=<?php echo $this->_tpl_vars['product']['id']; ?>
" id="<?php echo $this->_tpl_vars['product']['id']; ?>
">
        	<img id="<?php echo $this->_tpl_vars['product']['id']; ?>
" src="images/ico_layout_add.png" title="Add product Tests" alt="Add product Tests" border="0" />
        </a> 
		<a href="meta_tag.php?section=products&linkid=<?php echo $this->_tpl_vars['product']['id']; ?>
" id="<?php echo $this->_tpl_vars['product']['id']; ?>
">
        	<img id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
" src="images/ico_meta.png" alt="tags" title="Manage Meta Information"  border="0" />
        </a>               
        <a href="?type=delete&id=<?php echo $this->_tpl_vars['product']['id']; ?>
" id="<?php echo $this->_tpl_vars['product']['id']; ?>
" onClick="return deleteproduct();">
        	<img id="<?php echo $this->_tpl_vars['product']['id']; ?>
" src="images/ico_delete.png" alt="delete" title="Delete product" border="0" />
        </a>
     </td>
  </tr>
  	<?php endforeach; endif; unset($_from); ?>
</table>
<p class="button" style="float:right; margin-top:20px;"><a href="?type=add">Add New Product</a></p>