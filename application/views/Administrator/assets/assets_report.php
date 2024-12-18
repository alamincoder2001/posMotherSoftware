<style>
	.v-select {
		float: right;
		min-width: 200px;
		background: #fff;
		margin-left: 5px;
		border-radius: 4px !important;
		margin-top: -2px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
		border: none;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}
</style>

<div id="assetsReport">
	<div class="row" style="margin: 0;">
		<fieldset class="scheduler-border scheduler-search">
			<legend class="scheduler-border">Asset Report</legend>
			<div class="control-group">
				<div class="col-xs-12 col-md-12">
					<form class="form-inline" @submit.prevent="getReport">
						<div class="form-group">
							<label for="searchType"> Search Type </label>
							<select id="searchType" style="margin: 0;height:26px;width:150px;" class="form-select" v-model="searchType" v-on:change="onChangeSearchType">
								<option value="all"> All </option>
								<option value="asset"> By Asset</option>
							</select>
						</div>

						<div class="form-group" style="display:none" v-bind:style="{display: searchType == 'asset' ? '' : 'none'}">
							<label class="control-label"> Assets </label>
							<v-select v-bind:options="group_assets" v-model="selectedAsset" label="group_name"></v-select>
						</div>

						<div class="form-group">
							<input type="submit" value="Show">
						</div>
					</form>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="row" style="display:none;" v-bind:style="{display: assets.length > 0 ? '' : 'none'}">
		<div class="col-md-12 text-right">
			<a href="" v-on:click.prevent="print">
				<i class="fa fa-print"></i> Print
			</a>
			<div class="table-responsive" id="reportTable">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Name</th>
							<th>Purchase Qty</th>
							<th>Sold Qty</th>
							<th>Availabe Qty</th>
							<th>Purchase Amount</th>
							<th>Sold Amount</th>
							<th>Valuation Amount</th>
							<th>Approx Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="asset in assets">
							<td>{{ asset.group_name }}</td>
							<td>{{ asset.purchase_qty }}</td>
							<td>{{ asset.sold_qty }}</td>
							<td>{{ asset.available_qty }}</td>
							<td>{{ asset.purchase_amount }}</td>
							<td>{{ asset.sold_amount }}</td>
							<td>{{ asset.valuation_amount }}</td>
							<td>{{ asset.approx_amount }}</td>
						</tr>
					</tbody>
					<tbody>
						<tr style="font-weight:bold">
							<td colspan="7" style="text-align:right">Total</td>
							<td>
								{{ assets.reduce((prev, curr) => {return prev + parseFloat(curr.approx_amount)}, 0).toFixed(2) }}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#assetsReport',
		data() {
			return {
				searchType: 'all',
				group_assets: [],
				selectedAsset: null,
				assets: []
			}
		},
		methods: {
			getGroupAssets() {
				axios.get('/get_group_assets').then(res => {
					this.group_assets = res.data;
				})
			},
			onChangeSearchType() {
				if (this.searchType == 'asset' && this.group_assets.length == 0) {
					this.getGroupAssets();
				} else if (this.searchType == 'all') {
					this.selectedAsset = null;
				}
			},
			getReport() {
				if (this.searchType == 'asset' && this.selectedAsset == null) {
					alert('Select Asset');
					return;
				}

				let asset = null;

				if (this.selectedAsset != null && this.selectedAsset.group_name != '') {
					asset = this.selectedAsset.group_name;
				}

				axios.post('/get_assets_report', {
					asset
				}).then(res => {
					console.log(res.data);
					this.assets = res.data;
				})
			},
			async print() {
				let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Assets Report</h4>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

				var mywindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				mywindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				mywindow.document.body.innerHTML += reportContent;
				mywindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				mywindow.print();
				mywindow.close();
			}
		}
	})
</script>