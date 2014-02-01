<?php /* Smarty version 2.6.22, created on 2009-07-10 04:17:50
         compiled from newsletter_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'newsletter_list.html', 17, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>
<div id="left_section">
<form method="post" action="" id="user_email_list" name="user_email_list">
 <table width="850" border="0" cellspacing="0" cellpadding="4">
 <tr>
 <td class="tblHead">From</td>
  <td class="tblHead">Subject</td>
  <td class="tblHead">Date Created</td>
  <td class="tblHead">Status</td>
  <td class="tblHead">Last Sent</td>
  <td class="tblHead"></td>
 </tr>
<?php $_from = $this->_tpl_vars['nlList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nlList']):
?>
 <td class="tblList"><?php echo $this->_tpl_vars['nlList']->from_name; ?>
:<?php echo $this->_tpl_vars['nlList']->from_addr; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['nlList']->subject; ?>
</td>
 <td class="tblList"><?php echo ((is_array($_tmp=$this->_tpl_vars['nlList']->date_created)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%b-%Y") : smarty_modifier_date_format($_tmp, "%d-%b-%Y")); ?>
</td>
 <td class="tblList">
 		<?php if (( $this->_tpl_vars['nlList']->nl_status ) == 1): ?> Send 
		<?php else: ?> Unsend
		<?php endif; ?>			
 </td>
 <td class="tblList"><?php if (( $this->_tpl_vars['nlList']->nl_sent ) == 0): ?> --
		<?php else: ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['nlList']->nl_sent)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%b-%Y") : smarty_modifier_date_format($_tmp, "%d-%b-%Y")); ?>
 
		<?php endif; ?></td>
 <td class="tblList">
 <div align="right">
 	<a href="nl_send.php?msg_id=<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
">
	   	<img id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" src="images/mail.gif" alt="edit" border="0" title="Send" />
    </a>
 	<a href="?type=edit&id=<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
">
	   	<img id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" src="images/ico_edit.png" alt="edit" border="0" title="Edit" />
    </a>
    <a href="?type=delete&id=<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" onClick="return deleteN();">
    	<img id="<?php echo $this->_tpl_vars['nlList']->nl_id; ?>
" src="images/ico_delte.png"  alt="delete" title="Delete" border="0" />
    </a>
</div></td></tr>

<?php endforeach; endif; unset($_from); ?>

 </table>
<p class="button" style="float:right; margin-top:20px;"><a href="?type=add">Add Newsletters</a></p>