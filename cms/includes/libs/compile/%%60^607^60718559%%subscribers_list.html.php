<?php /* Smarty version 2.6.22, created on 2009-07-15 07:01:36
         compiled from subscribers_list.html */ ?>


<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="list_nav">
<?php if ($this->_tpl_vars['subxList']): ?>
<div align="left" style="margin-bottom:10px;">
<img src="images/ico_subscribe.png" alt="Un Subscribe" width="16" height="16" border="0" />= Users who are currently Un-subscribed from the list. Click on the Icon to subscribe them<br>
<img src="images/ico_un_subscribe.png" alt="Un Subscribe" width="16" height="16" border="0" />= Users who are currently Subscribed to the list. Click on the Icon to un-subscribe them.
</div>

<form method="post" action="" id="user_email_list" name="user_email_list">

 <table border="0" cellspacing="0" cellpadding="4" width="600">
 <tr>
 <td width="30" class="tblHead"><input name="checkAll" type="checkbox" id="checkAll" style="width:25px;" value="1" onClick="return selectAll();" /></td>
 <td class="tblHead">Email Address</td>
 <td colspan="2" class="tblHead"><div align="right" style="font-weight:normal">All Selected
 <a href="javascript:void(0)" id="subscribe" onclick="subscribeAll()">Subscribe</a> |
 <a href="javascript:void(0)" id="unSubscribe" onclick="unSubscribeAll()">Un-Subscribe</a> |
 <a href="javascript:void(0)" id="delete" onclick="deleteAll()">Delete</a></div></td>
 </tr>
<?php $_from = $this->_tpl_vars['subxList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subxList']):
?>
 <tr id="row_<?php echo $this->_tpl_vars['subxList']->subscriber_id; ?>
" align="left">
 <td width="30" class="tblList"><input name="check[]" type="checkbox" id="check" style="width:25px;" value="<?php echo $this->_tpl_vars['subxList']->subscriber_id; ?>
" /></td>
 <td class="tblList"><?php echo $this->_tpl_vars['subxList']->email; ?>
</td>
 <td class="tblList"><div align="center"></div></td>
 <td class="tblList">
 <div align="right">
 	<?php if (( $this->_tpl_vars['subxList']->status ) == 1): ?>
		<a href="?type=unSubx&id=<?php echo $this->_tpl_vars['subxList']->subscriber_id; ?>
"><img src="images/ico_un_subscribe.png" alt="Un Subscribe" width="16" height="16" border="0" /></a>
	<?php else: ?>
		<a href="?type=subx&id=<?php echo $this->_tpl_vars['subxList']->subscriber_id; ?>
"><img src="images/ico_subscribe.png" alt="Subscribe" width="16" height="16" border="0" /></a>
	<?php endif; ?>

 <a href="?type=delSubx&id=<?php echo $this->_tpl_vars['subxList']->subscriber_id; ?>
" onClick="return deleteN();"><img src="images/ico_delte.png" alt="Delete" width="16" height="16" border="0" /></a></div></td></tr>
<?php endforeach; endif; unset($_from); ?>
 <tr align="left">
   <td class="tblHead">&nbsp;</td>
   <td class="tblHead">&nbsp;</td>
   <td class="tblHead"colspan="2" >
   <div align="right">
   All Selected<a href="javascript:void(0)" id="subscribe" onclick="subscribeAll()">Subscribe</a> |
 <a href="javascript:void(0)" id="unSubscribe" onclick="unSubscribeAll()">Un-Subscribe</a> |
 <a href="javascript:void(0)" id="delete" onclick="deleteAll()">Delete</a>
 	</div>
   </td>
 </tr>
 </table>
</form> 
<?php endif; ?>
<p class="button" style="float:center; margin-top:20px;"><a href="newsletter.php">Manage Newsletters</a></p>
</div>