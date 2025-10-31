<?php if(!empty($price)): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Price</label>
    <div class="col-sm-9 text"><?php echo $price; ?> Credits</div>
  </div>
<?php endif; ?>

<?php if(!empty($delivery_time)) : ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Delivery Time</label>
    <div class="col-sm-9 text"><?php echo $delivery_time; ?></div>
  </div>
<?php endif; ?>

<?php if(!empty($description) ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Description</label>
    <div class="col-sm-9 text"><?php echo $description; ?>
    </div>
  </div>
<?php endif; ?>

<?php if($providers !== NULL): ?>
<div class="form-group">
	 <label class="col-sm-3 control-label">Netwok Provider</label>    
	<div class="col-sm-9">
	    <select name="ProviderID" id="ProviderID" class="form-control" >
	    	<option value="" selected>Seleccionar Proveedor (Opcional)</option>
	    	<?php foreach($providers as $val): ?>
				<option value="<?php echo $val['ApiProviderID'] ?>" ><?php echo $val['Title'] ?></option>
			<?php endforeach; ?>
	    </select>
	</div>
</div>
<?php endif; ?>

<?php if($models !== NULL): ?>
<div class="form-group">
	 <label class="col-sm-3 control-label">Mobile Model</label>
	<div class="col-sm-9">
	    <select name="ModelID" id="ModelID" class="form-control" >
	    	<option value="" >Select Mobile Model</option>
	    	<?php foreach($models as $val): ?>
				<option value="<?php echo $val['ApiModelID'] ?>" ><?php echo $val['ModelTitle'] ?></option>
			<?php endforeach; ?>
	    </select>
	</div>
</div>
<?php else: ?>
<div class="form-group">
	 <label class="col-sm-3 control-label">Mobile Maker</label>
	<div class="col-sm-9">
		<input type="text" name="Maker" value="" class="form-control">
	</div>
</div>
<div class="form-group">
	 <label class="col-sm-3 control-label">Mobile Model</label>
	<div class="col-sm-9">
		<input type="text" name="Model" value="" class="form-control">
	</div>
</div>
<?php endif; ?>

<?php if($meps !== NULL): ?>
<div class="form-group">
	 <label class="col-sm-3 control-label">MEP</label>    
	<div class="col-sm-9">
	    <select name="MEPID" id="MEPID" class="form-control" >
	    	<option value="" >Select MEP</option>
	    	<?php foreach($meps as $v): ?>
				<option value="<?php echo $val['ApiMepID'] ?>" ><?php echo $val['Title'] ?></option>
			<?php endforeach; ?>
	    </select>
	</div>
</div>
<?php endif; ?>

<?php if($pin ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">PIN</label>
    <div class="col-sm-9">
    <input type="text" name="PIN"  placeholder="PIN (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>

<?php if($kbh ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">KBH</label>
    <div class="col-sm-9">
    <input type="text" name="KBH"  placeholder="KBH (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>

<?php if($prd ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">PRD</label>
    <div class="col-sm-9">
    <input type="text" name="PRD" placeholder="PRD (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>
<?php if($type ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Type</label>
    <div class="col-sm-9">
    <input type="text" name="Type"  placeholder="Type (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>
<?php if($locks ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Locks</label>
    <div class="col-sm-9">
    <input type="text" name="Locks"  placeholder="Locks (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>
<?php if($serial_number ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Serial Number</label>
    <div class="col-sm-9">
    <input type="text" name="SerialNumber" placeholder="Serial Number (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>
<?php if($reference ): ?>
	<div class="form-group">
    <label class="col-sm-3 control-label">Reference</label>
    <div class="col-sm-9">
    <input type="text" name="Reference" placeholder="Reference (Opcional)" class="form-control" >
    </div>
  </div>
<?php endif; ?>
