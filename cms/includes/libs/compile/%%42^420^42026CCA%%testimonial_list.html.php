<?php /* Smarty version 2.6.22, created on 2009-06-17 11:27:02
         compiled from testimonial_list.html */ ?>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<div id="left_section">
<form method="post" action="" name="testimonial_list" id="testimonial_list" >
 <table width="650" border="0" cellspacing="0" cellpadding="4">
 <tr>
 
 <td class="tblHead">Name</td>
  <td class="tblHead">City</td>
  <td class="tblHead">State</td>
  <td class="tblHead">Country</td>
  <td class="tblHead">Message</td>
  <td class="tblHead">Email</td>
 </tr>
<?php $_from = $this->_tpl_vars['testimoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['testimoList']):
?>

 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimo_name; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimo_city; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimo_state; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimo_country; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimo_msg; ?>
</td>
 <td class="tblList"><?php echo $this->_tpl_vars['testimoList']->testimoEmail; ?>
</td>
 </tr>

<?php endforeach; endif; unset($_from); ?>

 </table>
</div>