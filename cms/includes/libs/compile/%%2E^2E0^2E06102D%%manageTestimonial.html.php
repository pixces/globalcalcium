<?php /* Smarty version 2.6.22, created on 2009-06-17 11:37:10
         compiled from manageTestimonial.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<div align="left">
<img src="images/ico_subscribe.png" alt="Deny" width="16" height="16" border="0" />= Users whose testimonial are currently Denyed. Click on the Icon to Allow there testimonial.<br>
<img src="images/ico_un_subscribe.png" alt="Allowed" width="16" height="16" border="0" />= Users whose testimonial are currently allowed. Click on the Icon to deny there testimonial.
</div><br>

<form method="post" action="" id="" name="">

 <table width="550" border="0" cellspacing="0" cellpadding="4">
 <tr>
 <td width="30" class="tblHead"><input name="checkAll" type="checkbox" id="checkAll" style="width:25px;" value="1" onClick="return selectAll();" /></td>
 <td class="tblHead">Email Address</td>
 <td colspan="2" class="tblHead"><div align="right" style="font-weight:normal">All Selected
 <a href="javascript:void(0)" id="allow" onclick="allowAll()">Allow</a> |
 <a href="javascript:void(0)" id="deny" onclick="denyAll()">Deny</a> |
 <a href="javascript:void(0)" id="delete" onclick="deleteAll()">Delete</a></div></td>
 </tr>
<?php $_from = $this->_tpl_vars['testimoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['testimoList']):
?>
 <tr id="row_<?php echo $this->_tpl_vars['testimoList']->testimo_id; ?>
" align="left">
 <td width="30" class="tblList"><input name="check[]" type="checkbox" id="check" style="width:25px;" value="<?php echo $this->_tpl_vars['testimoList']->testimo_id; ?>
" /></td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimoEmail; ?>
</td>
 <td class="tblList"><div align="center"></div></td>
 <td class="tblList">
 <div align="right">
 	<?php if (( $this->_tpl_vars['testimoList']->status ) == 1): ?>
		<a href="?type=deny&id=<?php echo $this->_tpl_vars['testimonial_list']->testimo_id; ?>
"><img src="images/ico_un_subscribe.png" alt="Deny" width="16" height="16" border="0" /></a>
	<?php else: ?>
		<a href="?type=allow&id=<?php echo $this->_tpl_vars['testimonial_list']->testimo_id; ?>
"><img src="images/ico_subscribe.png" alt="Allow" width="16" height="16" border="0" /></a>
	<?php endif; ?>

 <a href="?type=delete&id=<?php echo $this->_tpl_vars['testimonial_list']->testimo_id; ?>
" onClick="return deletel()"><img src="images/ico_delte.png" alt="Delete" width="16" height="16" border="0" /></a> </div></td></tr>

<?php endforeach; endif; unset($_from); ?>

 </table>
<div align="left" style="font-weight:normal;margin-top:5px; margin-bottom:10px;">All Selected
 <a href="javascript:void(0)" id="allow" onclick="subscribeAll()">Allow</a> |
 <a href="javascript:void(0)" id="deny" onclick="unSubscribeAll()">Deny</a> |
 <a href="javascript:void(0)" id="delete" onclick="deleteAll()">Delete</a></div>
</form> 