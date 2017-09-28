<link href="<?php echo base_url('resources/plugins/select/css/bootstrap-select.min.css');?>" rel="stylesheet" >
<form action="<?php echo base_url('index.php/portcode/store'); ?>" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<h4 class="modal-title"><?php echo $title; ?></h4>
	</div>

	<div class="modal-body">
		<div class="form-group hidden">
			<input type="number" class="form-control" id="id" name="id" value="<?php echo isset($entity->id) ? $entity->id : ''; ?>">
		</div>

		<div class="form-group">
			<label for="short_code">Short Code</label>
			<input type="text" class="form-control" id="short_code" name="short_code" value="<?php echo isset($entity->short_code) ? $entity->short_code : ''; ?>" required>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<input type="text" class="form-control" id="description" name="description" value="<?php echo isset($entity->description) ? $entity->description : ''; ?>" required>
		</div>

	</div>
	
	<div class="modal-footer">
		<div class="form-group">
			<button type="button" class="btn btn-flat btn-info pull-left" data-dismiss="modal">Close</button>
			<input type="submit" value="Submit" class="btn btn-flat btn-danger">
		</div>
	</div>
	
</form><!-- End Form -->
<script src="<?php echo base_url('resources/plugins/select/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#cp_id').selectpicker({});
	});
</script>
					