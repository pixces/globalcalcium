<?php /* Smarty version 2.6.22, created on 2009-06-24 12:31:24
         compiled from newsletter_add.html */ ?>

<ul class="formDetail">
<li>Use the form below to add newsletter</li>
</ul>

<div id="left_section">
<form name="newsLetter_form" id="newsLetter_form" method="post">
<input type="hidden" name="mm_action" id="mm_action" value="<?php echo $this->_tpl_vars['mm_action']; ?>
" />
<input type="hidden" name="nl_id" id="nl_id" value="<?php echo $this->_tpl_vars['nlEdit']->nl_id; ?>
" />
<table cellpadding="2" cellspacing="0" width="100%">
    <tr><td width="150" valign="top"><label>From Name:</label></td>
	<td valign="top"><input type="text" name="nlName" id="nlName" style="width:450px;" value="<?php echo $this->_tpl_vars['nlEdit']->from_name; ?>
"/>
	<br />
        <span class="frmInstruction">Enter the name of the sender</span></td>   </tr>
		
	<tr><td width="150" valign="top"><label>From Email Address:</label></td>
		<td valign="top"><input type="text" name="nlAddr" id="nlAddr" style="width:450px;"  value="<?php echo $this->_tpl_vars['nlEdit']->from_addr; ?>
"/>
		<br />
	    <span class="frmInstruction">Enter the email address of the newsletter sender.</span></td></tr>
	<tr><td width="150" valign="top"><label>Subject:</label></td>
		<td valign="top"><input type="text" name="nlSub" id="nlSub" style="width:450px;"  value="<?php echo $this->_tpl_vars['nlEdit']->subject; ?>
"/>
		<br />
        <span class="frmInstruction">Enter the subject of the newsletter. It will be appended by &quot;[WENEXT Newsletter]&quot;.</td> </tr>
	<tr><td width="150" valign="top"><label>Message:</label></td>
		<td valign="top"><textarea name="nlMessage" id="nlMessage" style="width:450px;" cols="" rows="7" style="width:350px;"><?php echo $this->_tpl_vars['nlEdit']->message; ?>
</textarea></td> </tr>
    <tr><td></td><td width="150" valign="top"><input type="submit" name="<?php echo $this->_tpl_vars['formName']; ?>
" value="<?php echo $this->_tpl_vars['formName']; ?>
&nbsp;Newsletter" onClick="return validateNewsLetter();"/></td>  </tr>
  </table>
 </form>
</div>