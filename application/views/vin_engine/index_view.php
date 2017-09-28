<link href="<?php echo base_url('resources/plugins/select2/css/select2.css');?>" rel="stylesheet" >
<!-- Items block -->
<section class="content vin_engine">
	<!-- row -->
	<div class="row" id="app">
		<!-- col-md-6 -->
		<div class="col-md-12">
			<!-- Box danger -->
			<?php echo $this->session->flashdata('message'); ?>

			<div class="box box-danger">
				<!-- box-header -->
				<div class="box-header">

				</div>

				<div class="box-body">
					<!-- Item table -->
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th>Sequence</th>
								<th>Model Name</th>
								<th>Vin No.</th>
								<th>Engine No.</th>
								<th>Security No.</th>
								<th>Lot No.</th>
								<th>Product Model</th>
								<th>Invoice No.</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, index) in items">
								<td>{{ item.sequence }}</td>
								<td>{{ item.product_model }}</td>
								<td>{{ item.vin_no }}</td>
								<td><input type="text" class="form-control" v-bind:value="item.engine_no" v-model="items[index].engine_no"></td>
								<td>{{ item.security_no }}</td>
								<td>{{ item.lot_no }}</td>
								<td>{{ item.model_name }}</td>
								<td>{{ item.invoice_no }}</td>
							</tr>
						</tbody>
					</table>
					<!-- End of table -->
				</div>
				<!-- End of content -->
			</div>
			<!-- End of danger -->
		</div>
		<!-- End of col-md-6 -->
	</div>
	<!-- End of row -->
</section>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>
<script src="<?php echo base_url('resources/plugins/select2/js/select2.js');?>"></script>
<script src="<?php echo base_url('resources/js/axios/axios.min.js') ?>"></script>
<script src="<?php echo base_url('resources/js/vue/vue.min.js') ?>"></script>
<script src="<?php echo base_url('resources/js/lodash/lodash.js') ?>"></script>
<script type="text/javascript">
	var appUrl = '<?php echo base_url('index.php') ?>';

	var app = new Vue({
		el: '#app',
		data: {
			vinModel: [],
			selected: '',
			items: [],
			vinControl: ''
		},            
		created() {
			this.fetchVinModel()	
		},
		watch: {
			selected: function() {
				console.log(this.selected);
				this.fetchVinControlEntity()
			},
		},
		mounted() {
			var self = this

			$(this.$refs.vin_model).on("change", function() {
				self.selected = self.getSelectedModel($(this).val())
			})
		},
		methods: {
			fetchVinModel: function() {
				axios.get(appUrl + '/vin/ajax_model_list')
				.then((response) => {
					this.vinModel = response.data
				})
				.catch(function (err) {
					console.log(err.message);
				});
			},
			getSelectedModel: function(searchItem)
			{
				for(var [index, value] of this.vinModel.entries())
				{
					if (searchItem == value.product_model)
					{
						return value
					}
				}

				return false
			},
			populateItems: function()
			{
				if (this.selected instanceof Object)
				{
					// Clear items before populate
					this.clearItems()

					for(var i = 1; i <= this.selected.lot_size; i++)
					{
						this.items.push(this.formatData(i))
					}
				}	
			},
			formatData: function(count)
			{
				var formattedData = {
						sequence: count,
						product_model: this.vinControl.product_model || '',
						vin_no: this.vinControl.vin_no || '',
						engine_no: this.vinControl.engine || '',
						security_no: '',
						lot_no: Number(this.vinControl.lot_no) + 1 || '',
						model_name: this.vinControl.model_name || '',
						invoice_no: ''
					}

				return formattedData
			},
			clearItems: function()
			{
				this.items.splice(0, this.items.length)
			},
			fetchVinControlEntity: function()
			{
				axios({
					url: appUrl + '/vin_control/ajax_vin_control_entity',
					method: 'post',
					data: {
						product_model: this.selected.product_model,
					}
				})
				.then((response) => {
					this.vinControl = response.data

					//this.populateItems()
					_.debounce(this.populateItems(), 200)					

				})
				.catch((error) => {
					// your action on error success
					console.log(error)
				});
			},
		},
	});

	$(document).ready(function() {
		//$('.table').DataTable();
	});

	$('select').select2()

	// Detroy modal
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	}); 
</script>