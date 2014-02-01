<?php /* Smarty version 2.6.22, created on 2011-07-07 20:24:26
         compiled from event_add.html */ ?>
<script language="javascript" type="text/javascript">
	$(document).ready(function (){ CKEDITOR.replace('event_details'); });
</script>
<ul class="formDetail">
	<li>Use the form below to add the Products.</li>
</ul>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form id="addEvent" name="addEvent" method="post" enctype="multipart/form-data">
<input type="hidden" name="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="eventId" value="<?php echo $this->_tpl_vars['eventDet']->id; ?>
" />
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event Title:</label></div></td>
    <td width="10" valign="top"><div align="left"></div></td>
    <td valign="top"><div align="left">
      <input name="event_title" id="page_title" type="text" value="<?php echo $this->_tpl_vars['eventDet']->news_title; ?>
" style="width:250px;"  onblur="addSefUrl()"/>
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"><label>Title SEF:</label></div></td>
    <td valign="top"><div align="left"></div></td>
    <td valign="top"><div align="left">
      <input name="sef_title" type="text" id="sef_title" maxlength="250" value="<?php echo $this->_tpl_vars['eventDet']->news_title_sef; ?>
" style="width:250px;" />
    </div></td>
  </tr>
  <?php if (( $this->_tpl_vars['action'] ) == 'doEdit'): ?>
  <tr>
    <td valign="top"><div align="left"><label>Uploaded Logo Image:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><img src="../upload/<?php echo $this->_tpl_vars['eventDet']->news_image_logo; ?>
" width="150" border="1" /></div></td>
  </tr>
  <?php endif; ?>
  <tr>
    <td valign="top"><div align="left"><label>Event Logo Image:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
      <input type="file" name="event_logo" id="eventLogo" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event Location:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
      <input type="text" name="event_location" id="eventLocation" value="<?php echo $this->_tpl_vars['eventDet']->news_location; ?>
" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event Date:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
      <input type="text" name="event_date" id="eventDate" value="<?php echo $this->_tpl_vars['eventDet']->news_date; ?>
" style="width:250px;" />
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event end Date:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
      <input type="text" name="event_end_date" id="eventEndDate" value="<?php echo $this->_tpl_vars['eventDet']->news_valid_upto; ?>
" style="width:250px;" />
    </div></td>
  </tr>  
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event Summary Text:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
		<textarea name="event_summary" id="eventSummary" rows="3" style="width:250px;"><?php echo $this->_tpl_vars['eventDet']->news_summary; ?>
</textarea>
    </div></td>
  </tr>
<?php if (( $this->_tpl_vars['action'] ) == 'doEdit'): ?>
<?php if (( $this->_tpl_vars['eventDet']->news_photo1 ) != ''): ?>
  <tr>
    <td valign="top"><div align="left"><label>Uploaded Image:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><img src="../upload/<?php echo $this->_tpl_vars['eventDet']->news_photo1; ?>
" width="150" border="1" /></div></td>
  </tr>
<?php endif; ?>  
<?php endif; ?>
  <tr>
    <td valign="top"><div align="left"><label>Event Pictures:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><input type="file" name="event_image[]" id="eventImage01" style="width:250px;" /></div></td>
  </tr>
<?php if (( $this->_tpl_vars['action'] ) == 'doEdit'): ?>
<?php if (( $this->_tpl_vars['eventDet']->news_photo2 ) != ''): ?>
  <tr>
    <td valign="top"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><img src="../upload/<?php echo $this->_tpl_vars['eventDet']->news_photo2; ?>
" width="150" border="1" /></div></td>
  </tr>
<?php endif; ?>  
<?php endif; ?>
  <tr>
    <td valign="top"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><input type="file" name="event_image[]" id="eventImage01" style="width:250px;" /></div></td>
  </tr>
<?php if (( $this->_tpl_vars['action'] ) == 'doEdit'): ?>
<?php if (( $this->_tpl_vars['eventDet']->news_photo3 ) != ''): ?>
  <tr>
    <td valign="top"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><img src="../upload/<?php echo $this->_tpl_vars['eventDet']->news_photo3; ?>
" width="150" border="1" /></div></td>
  </tr>
<?php endif; ?>  
<?php endif; ?>  
  <tr>
    <td valign="top"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left"><input type="file" name="event_image[]" id="eventImage03" style="width:250px;" /></div></td>
  </tr>  
  <tr>
    <td width="150" valign="top"><div align="left"><label>Event Details:</label></div></td>
    <td>&nbsp;</td>
    <td valign="top"><div align="left">
      <textarea name="event_details" id="eventDetails"><?php if ($this->_tpl_vars['eventDet']->news_details): ?><?php echo $this->_tpl_vars['eventDet']->news_details; ?>
<?php endif; ?></textarea>
    </div></td>
  </tr>
  <tr>
    <td width="150" valign="top"><div align="left"></div></td>
    <td>&nbsp;</td>
    <td><div align="left">
      <input type="submit" name="submit" id="submit" value="<?php echo $this->_tpl_vars['formName']; ?>
 Events" />
    </div></td>
  </tr>
</table>
</form>