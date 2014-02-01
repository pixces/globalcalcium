<?php /* Smarty version 2.6.22, created on 2011-05-11 20:02:01
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS: Global Calcium</title>
<link rel="stylesheet" href="admin.css" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script src="js/admin_functions.js" type="text/javascript"></script>
<script src="includes/libs/ckeditor/ckeditor.js" type="text/javascript"></script>
</head>
<body>
<div id="mainWrapper">
	<div id="headerWrapper">
    	<div class="left"><img src="images/site_logo.png" alt="Global Calcium" /></div>
        <div class="right"><?php echo $this->_tpl_vars['welcomeNote']; ?>
</div>
		<div style="clear:both"></div>
    </div>
    <div class="mainTopBar">
    </div>
    <div id="bodyWrapper">
    	<div id="mainBodyWrapper">
<?php if ($this->_tpl_vars['login'] != 'yes'): ?>
            <div id="navigation"><?php echo $this->_tpl_vars['navigation']; ?>

        	    <div class="clearfloat"></div> 
            </div>
<?php endif; ?>          
            <div id="sectionTitle"><?php echo $this->_tpl_vars['sectionTitle']; ?>
</div>
            <div id="mainContent"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['contentFile']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
            <div class="clearfloat"></div> 
        </div>   	
     </div>
     <div class="mainBottomBar"></div> 
     <div class="mainTopBar"></div>
	 <div id="footerWrapper">&copy;-2009. Global Calcium. All Rights Reserved</div>     
     <div class="mainBottomBar"></div>    
</div>
<!-- Following part is for changing the admin user password -->
<div id="popupContact">
   <a id="popupContactClose">x</a> 
	<div id="popupform"></div>    
</div>
<div id="backgroundPopup"></div> 
<!-- Admin user change password ends here--> 
</body>
</html>