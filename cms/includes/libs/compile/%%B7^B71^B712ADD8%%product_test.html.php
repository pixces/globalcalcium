<?php /* Smarty version 2.6.22, created on 2011-07-04 17:05:45
         compiled from product_test.html */ ?>
<ul class="formDetail">
	<li>Add Test specifications in the form below</li>
</ul>
<?php if (isset ( $this->_tpl_vars['error'] )): ?> <div class="errorBox"><?php echo $this->_tpl_vars['error']; ?>
</div> <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['message'] )): ?> <div class="messageBox"><?php echo $this->_tpl_vars['message']; ?>
</div> <?php endif; ?>

<form id="addTests" name="addTests" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="mm_action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="productId" value="<?php echo $this->_tpl_vars['productId']; ?>
" />
<input type="hidden" name="test_count" id="test_count" value="<?php echo $this->_tpl_vars['product_test_count']; ?>
" />
<table border="0" cellspacing="0" cellpadding="5" id="productTests">
    <tr>
        <th valign="top" scope="col">
        	<div align="left">Tests</div>
        </th>
        <th valign="top" scope="col">
        	<div align="left">Specifications</div>
       	</th>
        <th valign="top" scope="col">
        	<div align="left">Reference</div>
        </th>
        <th valign="top" scope="col">
        	<div align="left"></div>
        </th>
    </tr>
    <tr id="row_test_<?php echo $this->_tpl_vars['productTestDet']['0']['id']; ?>
">
        <td valign="top">
        	<div align="left">
            	<textarea name="product_test[]" id="product_test" cols="29" ><?php if ($this->_tpl_vars['productTestDet']['0']): ?><?php echo $this->_tpl_vars['productTestDet']['0']['product_test']; ?>
<?php endif; ?></textarea>
            </div>
        </td>
        <td valign="top" align="left">
        	<div align="left">
            	<textarea name="product_specification[]" id="product_specification" cols="25" ><?php if ($this->_tpl_vars['productTestDet']['0']): ?><?php echo $this->_tpl_vars['productTestDet']['0']['test_specification']; ?>
<?php endif; ?></textarea>
            </div>
        </td>
        <td valign="top" align="left">
        	<div align="left">
            	<textarea name="product_reference[]" id="product_reference" cols="25" ><?php if ($this->_tpl_vars['productTestDet']['0']): ?><?php echo $this->_tpl_vars['productTestDet']['0']['test_reference']; ?>
<?php endif; ?></textarea>
        	</div>
        </td>
        <td align="left">
        	<a href="javascript:add_more_tests();"><img src="images/ico_add_doc.png" width="16" height="16" border="0" /></a>
        </td>
    </tr>
	<?php if ($this->_tpl_vars['product_test_count'] > 1): ?>
		<?php unset($this->_sections['tests']);
$this->_sections['tests']['name'] = 'tests';
$this->_sections['tests']['loop'] = is_array($_loop=$this->_tpl_vars['productTestDet']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tests']['start'] = (int)1;
$this->_sections['tests']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['tests']['show'] = true;
$this->_sections['tests']['max'] = $this->_sections['tests']['loop'];
if ($this->_sections['tests']['start'] < 0)
    $this->_sections['tests']['start'] = max($this->_sections['tests']['step'] > 0 ? 0 : -1, $this->_sections['tests']['loop'] + $this->_sections['tests']['start']);
else
    $this->_sections['tests']['start'] = min($this->_sections['tests']['start'], $this->_sections['tests']['step'] > 0 ? $this->_sections['tests']['loop'] : $this->_sections['tests']['loop']-1);
if ($this->_sections['tests']['show']) {
    $this->_sections['tests']['total'] = min(ceil(($this->_sections['tests']['step'] > 0 ? $this->_sections['tests']['loop'] - $this->_sections['tests']['start'] : $this->_sections['tests']['start']+1)/abs($this->_sections['tests']['step'])), $this->_sections['tests']['max']);
    if ($this->_sections['tests']['total'] == 0)
        $this->_sections['tests']['show'] = false;
} else
    $this->_sections['tests']['total'] = 0;
if ($this->_sections['tests']['show']):

            for ($this->_sections['tests']['index'] = $this->_sections['tests']['start'], $this->_sections['tests']['iteration'] = 1;
                 $this->_sections['tests']['iteration'] <= $this->_sections['tests']['total'];
                 $this->_sections['tests']['index'] += $this->_sections['tests']['step'], $this->_sections['tests']['iteration']++):
$this->_sections['tests']['rownum'] = $this->_sections['tests']['iteration'];
$this->_sections['tests']['index_prev'] = $this->_sections['tests']['index'] - $this->_sections['tests']['step'];
$this->_sections['tests']['index_next'] = $this->_sections['tests']['index'] + $this->_sections['tests']['step'];
$this->_sections['tests']['first']      = ($this->_sections['tests']['iteration'] == 1);
$this->_sections['tests']['last']       = ($this->_sections['tests']['iteration'] == $this->_sections['tests']['total']);
?>
    <tr id="row_test_<?php echo $this->_tpl_vars['productTestDet'][$this->_sections['tests']['index']]['id']; ?>
">
        <td valign="top">
	        <div align="left">
            	<textarea name="product_test[]" id="product_test" cols="29" ><?php echo $this->_tpl_vars['productTestDet'][$this->_sections['tests']['index']]['product_test']; ?>
</textarea>
            </div>
        </td>
        <td valign="top" align="left">
	        <div align="left">
            	<textarea name="product_specification[]" id="product_specification" cols="25" ><?php echo $this->_tpl_vars['productTestDet'][$this->_sections['tests']['index']]['test_specification']; ?>
</textarea>
            </div>
        </td>
        <td valign="top" align="left">
    	    <div align="left">
            	<textarea name="product_reference[]" id="product_reference" cols="25" ><?php echo $this->_tpl_vars['productTestDet'][$this->_sections['tests']['index']]['test_reference']; ?>
</textarea>
	        </div>
        </td>
        <td align="left">
            <a href="javascript:add_more_tests();"><img src="images/ico_add_doc.png" width="16" height="16" border="0" /></a>
            <a href="javascript:remove_tests(<?php echo $this->_tpl_vars['productTestDet'][$this->_sections['tests']['index']]['id']; ?>
);"><img src="images/ico_remove_doc.png" width="16" height="16" border="0" /></a>
        </td>
    </tr>
		<?php endfor; endif; ?>
	<?php endif; ?>
    <tr>
        <td valign="top" align="left"><input type="submit" name="submit" id="submitBtn" value="Submit Product Tests" /></td>
        <td valign="top" align="left"></td>
        <td valign="top" align="left"></td>
        <td align="left"></td>
    </tr>   
</table>

</form>