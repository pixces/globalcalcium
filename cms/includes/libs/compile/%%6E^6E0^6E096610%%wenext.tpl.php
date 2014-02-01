<?php /* Smarty version 2.6.22, created on 2009-06-17 11:34:33
         compiled from wenext.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['pageTitle']; ?>
</title>
<?php echo $this->_tpl_vars['cssLink']; ?>

<?php echo $this->_tpl_vars['jsLink']; ?>

</head>
<body>
	<div id="MainWrapper">
    	<div id="HeaderWrapper"><img src="images/banner_img.png" /></div>
        
        	<div id="NavWrapper">
            	
            </div>
        
        <div id="BodyWrapper">
            
            <div id="LeftWrapper">
            	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['contentPage']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            
            <div id="RightWrapper">
            
            	<div id="QuoteWrapper" align="center"><a href="quote.php"><img src="images/askquote_button.png" border="0" /></a></div>
                
                <div id="RightBox">
                	<div class="BoxTop"></div>
                    <div class="BoxMiddle">
                    	
                    </div>
                    <div class="BoxBottom"></div>
                </div>
                
                <div id="RightBox">
                	<div class="BoxTop"></div>
                    <div class="BoxMiddle">
                    	
                    </div>
                    <div class="BoxBottom"></div>
                </div>
                
                <div id="RightBox">
                	<div class="BoxTop"></div>
                    <div class="BoxMiddle">
                    	<img src="images/newsletter_heading.png"/>
                        <div class="Newsletter">
                          <div style="float:left; margin-top:7px"><input style="background-color:#252525; color:#CCCCCC; border:#4b4a4a 1px solid;width:150px;" type="text" /></div>
                          <div style="width:35px;float:right"><input type="image" src="images/go_button.png" style="width:30px;border:none;" /></div>
                          <div style="clear:both"></div>
                        </div>
                    </div>
                    <div class="BoxBottom"></div>
                </div>
                
            </div>
            <div style="clear:both"></div>
        </div>
        
        <div id="FooterWrapper">
        	<div class="footerCorners"></div>
            <div class="Footerbg"></div>
        </div>
    </div>
</body>
</html>