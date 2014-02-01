<?php /* Smarty version 2.6.22, created on 2011-07-20 18:27:53
         compiled from content_list.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left">Found: <b><?php echo $this->_tpl_vars['content_count']; ?>
 Pages </b></div></td>
    <td><div align="right"></div></td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td class="tblHead" width="125"><div align="left">Page Title</div></td>
    <td class="tblHead" width="200"><div align="left">Page Content</div></td>
	<td class="tblHead" width="120"><div align="left">page URL</div></td>
	<td class="tblHead" width="50"><div align="left"></div></td>
  </tr>
  <tr>
    <?php $_from = $this->_tpl_vars['contentList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['content']):
?>
	
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['content']['content_title']; ?>
</b></td>
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['content']['content_file']; ?>
</b></td>
	<td class="tblList" align="left"><b><?php echo $this->_tpl_vars['HOST']; ?>
<?php echo $this->_tpl_vars['content']['link_name']; ?>
</b></td>
	<td class="tblList" align="left">
	
        <a href="?type=edit&id=<?php echo $this->_tpl_vars['content']['content_id']; ?>
" id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
">
        	<img id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
" src="images/ico_edit.png" alt="edit" title="Edit Content" border="0"/>
        </a>
		<a href="meta_tag.php?section=page&linkid=<?php echo $this->_tpl_vars['content']['content_link_id']; ?>
" id="<?php echo $this->_tpl_vars['content']['content_link_id']; ?>
">
        	<img id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
" src="images/ico_meta.png" alt="tags" title="Manage Meta Information"  border="0" />
        </a>
        <a href="?type=delete&id=<?php echo $this->_tpl_vars['content']['content_id']; ?>
" id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
" onClick="return deleteContent();">
        	<img id="<?php echo $this->_tpl_vars['content']['content_id']; ?>
" src="images/ico_delte.png"  alt="delete" title="Delete Content" border="0" />
        </a>
     </td>
  </tr>
  	<?php endforeach; endif; unset($_from); ?>
</table>
<p class="button" style="float:right; margin-top:20px;"><a href="?type=add">Add New Content</a></p>