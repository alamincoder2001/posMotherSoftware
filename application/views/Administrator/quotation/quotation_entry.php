<style>
	.v-select {
		margin-bottom: 5px;
		background: #fff;
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

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}
</style>

<div id="quotation" class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<fieldset class="scheduler-border entryFrom">
			<div class="control-group">
				<div class="row">
					<div class="form-group">
						<label class="col-md-1 control-label no-padding-right"> Invoice no </label>
						<div class="col-md-2">
							<input type="text" class="form-control" v-model="quotation.invoiceNo" readonly />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-1 control-label no-padding-right"> Quote. By </label>
						<div class="col-md-2">
							<input type="text" class="form-control" v-model="quotation.quotationBy" readonly />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-1 control-label no-padding-right"> Qu. From </label>
						<div class="col-md-2">
							<v-select id="branchDropdown" v-bind:options="branches" label="Branch_name" v-model="selectedBranch" disabled></v-select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-3">
							<input class="form-control" type="date" v-model="quotation.quotationDate" />
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>


	<div class="col-xs-9 col-md-9 col-lg-9">
		<fieldset class="scheduler-border" style="margin-bottom: 5px;padding-bottom: 5px">
			<legend class="scheduler-border">Customer & Product Information</legend>
			<div class="control-group">
				<div class="row">
					<div class="col-xs-12 col-md-5">
						<div class="form-group">
							<label class="col-xs-4 control-label no-padding-right"> Customer </label>
							<div class="col-xs-7">
								<v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer" v-on:input="customerOnChange"></v-select>
							</div>
							<div class="col-xs-1" style="padding: 0;">
								<a href="<?= base_url('customer') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Customer"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
							</div>
						</div>

						<div class="form-group" style="display:none;" v-bind:style="{display: selectedCustomer.Customer_Type == 'G' ? '' : 'none'}">
							<label class="col-xs-4 control-label no-padding-right"> Name </label>
							<div class="col-xs-8">
								<input type="text" id="customerName" placeholder="Customer Name" class="form-control" v-model="selectedCustomer.Customer_Name" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
							<div class="col-xs-8">
								<input type="text" id="mobileNo" placeholder="Mobile No" class="form-control" v-model="selectedCustomer.Customer_Mobile" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-4 control-label no-padding-right"> Address </label>
							<div class="col-xs-8">
								<textarea id="address" placeholder="Address" class="form-control" v-model="selectedCustomer.Customer_Address" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true"></textarea>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-md-5">
						<form v-on:submit.prevent="addToCart">
							<div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Product </label>
								<div class="col-xs-8">
									<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>

							<div class="form-group" style="display: none;">
								<label class="col-xs-3 control-label no-padding-right"> Brand </label>
								<div class="col-xs-9">
									<input type="text" placeholder="Group" class="form-control" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Sale Rate </label>
								<div class="col-xs-9">
									<input type="number" placeholder="Rate" class="form-control" v-model="selectedProduct.Product_SellingPrice" v-on:input="productTotal" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Quantity </label>
								<div class="col-xs-9">
									<input type="number" id="quantity" placeholder="Qty" class="form-control" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" autocomplete="off" required />
								</div>
							</div>

							<div class="form-group" style="display:none;">
								<label class="col-xs-3 control-label no-padding-right"> Discount</label>
								<div class="col-xs-9">
									<span>(%)</span>
									<input type="text" placeholder="Discount" class="form-control" style="display: inline-block; width: 90%" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Amount </label>
								<div class="col-xs-9">
									<input type="text" placeholder="Amount" class="form-control" v-model="selectedProduct.total" readonly />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> </label>
								<div class="col-xs-9 text-right">
									<button type="submit" class="btnCart">Add to Cart</button>
								</div>
							</div>
						</form>

					</div>
					<div class="col-md-2">
						<input type="password" ref="productPurchaseRate" v-model="selectedProduct.Product_Purchase_Rate" v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate" v-on:mouseout="$refs.productPurchaseRate.type = 'password'" readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;">
					</div>
				</div>
			</div>
		</fieldset>


		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" style="color:#000;">
					<thead>
						<tr class="">
							<th style="width:10%;color:#000;">Sl</th>
							<th style="width:30%;color:#000;">Product Name</th>
							<th style="width:15%;color:#000;">Category</th>
							<th style="width:7%;color:#000;">Qty</th>
							<th style="width:8%;color:#000;">Rate</th>
							<th style="width:15%;color:#000;">Total</th>
							<th style="width:15%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart">
							<td>{{ sl + 1 }}</td>
							<td style="padding-left: 4px;text-align:left;">{{ product.name }}</td>
							<td>{{ product.categoryName }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.salesRate }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-xs-3 col-md-3 col-md-3 col-lg-3">
		<fieldset class="scheduler-border" style="margin-bottom: 5px;padding-bottom: 5px">
			<legend class="scheduler-border">Amount Details</legend>
			<div class="control-group">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
								<tr>
									<td>
										<div class="form-group">
											<label class="col-md-12 control-label no-padding-right">Sub Total</label>
											<div class="col-md-12">
												<input type="number" class="form-control" v-model="quotation.subTotal" readonly />
											</div>
										</div>
									</td>
								</tr>

								<tr>
									<td>
										<div class="form-group">
											<label class="col-md-12 control-label no-padding-right"> Vat </label>
											<div class="col-md-4">
												<input type="number" class="form-control" v-model="vatPercent" v-on:input="calculateTotal" />
											</div>
											<label class="col-md-1 control-label no-padding-right">%</label>
											<div class="col-md-7">
												<input type="number" readonly class="form-control" v-model="quotation.vat" />
											</div>
										</div>
									</td>
								</tr>

								<tr style="display:none;">
									<td>
										<div class="form-group">
											<label class="col-md-12 control-label no-padding-right">Freight</label>
											<div class="col-md-12">
												<input type="number" class="form-control" />
											</div>
										</div>
									</td>
								</tr>

								<tr>
									<td>
										<div class="form-group">
											<label class="col-md-12 control-label no-padding-right">Discount Persent</label>

											<div class="col-md-4">
												<input type="number" class="form-control" v-model="discountPercent" v-on:input="calculateTotal" />
											</div>

											<label class="col-md-1 control-label no-padding-right">%</label>

											<div class="col-md-7">
												<input type="number" id="discount" class="form-control" v-model="quotation.discount" v-on:input="calculateTotal" />
											</div>

										</div>
									</td>
								</tr>

								<tr>
									<td>
										<div class="form-group">
											<label class="col-md-12 control-label no-padding-right">Total</label>
											<div class="col-md-12">
												<input type="number" class="form-control" v-model="quotation.total" readonly />
											</div>
										</div>
									</td>
								</tr>

								<tr>
									<td>
										<div class="form-group">
											<div class="col-xs-5">
												<input type="button" class="btn btn-success btn-sm" value="Save" v-on:click="saveQuotation" style="color: white!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
											</div>
											<div class="col-xs-7">
												<a class="btn btn-info btn-sm" href="/quotation" style="color: white!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New Quotation</a>
											</div>
										</div>
									</td>
								</tr>

							</table>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#quotation',
		data() {
			return {
				quotation: {
					quotationId: parseInt('<?php echo $quotationId; ?>'),
					invoiceNo: '<?php echo $invoice; ?>',
					customerName: '',
					customerMobile: '',
					customerAddress: '',
					quotationBy: '<?php echo $this->session->userdata("FullName"); ?>',
					quotationFrom: '',
					quotationDate: '',
					subTotal: 0.00,
					discount: 0.00,
					vat: 0.00,
					total: 0.00
				},
				customers: [],
				selectedCustomer: {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Cash Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: 'G'
				},
				vatPercent: 0,
				discountPercent: 0,
				cart: [],
				branches: [],
				selectedBranch: {
					branch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Branch_name: "<?php echo $this->session->userdata('Branch_name'); ?>"
				},
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 0,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					total: 0.00
				}
			}
		},
		created() {
			this.quotation.quotationDate = moment().format('YYYY-MM-DD');
			this.getBranches();
			this.getCustomers();
			this.getProducts();

			if (this.quotation.quotationId != 0) {
				this.getQuotations();
			}
		},
		methods: {
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},
			async getCustomers() {
				await axios.post('/get_customers').then(res => {
					this.customers = res.data;
					this.customers.unshift({
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: '',
						display_name: 'Cash Customer',
						Customer_Mobile: '',
						Customer_Address: '',
						Customer_Type: 'G'
					})
				})
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			productTotal() {
				this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.Product_SellingPrice)).toFixed(2);
			},
			productOnChange() {
				if (this.selectedProduct == null) {
					this.selectedProduct = {
						Product_SlNo: '',
						display_text: 'Select Product',
						Product_Name: '',
						Unit_Name: '',
						quantity: 0,
						Product_Purchase_Rate: '',
						Product_SellingPrice: 0.00,
						vat: 0.00,
						total: 0.00
					}
					return
				}
				if (this.selectedProduct.Product_SlNo != "") {
					this.$refs.quantity.focus();
				}
			},
			toggleProductPurchaseRate() {
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},
			async customerOnChange() {
				if (this.selectedCustomer == null) {
					this.selectedCustomer = {
						Customer_SlNo: '',
						Customer_Code: '',
						Customer_Name: '',
						display_name: 'Cash Customer',
						Customer_Mobile: '',
						Customer_Address: '',
						Customer_Type: 'G'
					}
					return
				}
				if (this.selectedCustomer.Customer_SlNo == "") {
					return;
				}
			},
			addToCart() {
				let product = {
					productId: this.selectedProduct.Product_SlNo,
					categoryName: this.selectedProduct.ProductCategory_Name,
					name: this.selectedProduct.Product_Name,
					salesRate: this.selectedProduct.Product_SellingPrice,
					quantity: this.selectedProduct.quantity,
					total: this.selectedProduct.total
				}

				if (product.productId == '') {
					alert('Select Product');
					return;
				}

				if (product.quantity == 0 || product.quantity == '') {
					alert('Enter quantity');
					return;
				}

				if (product.salesRate == 0 || product.salesRate == '') {
					alert('Enter sales rate');
					return;
				}

				let cartInd = this.cart.findIndex(p => p.productId == product.productId);
				if (cartInd > -1) {
					this.cart.splice(cartInd, 1);
				}

				this.cart.unshift(product);
				this.clearProduct();
				this.calculateTotal();
			},
			removeFromCart(ind) {
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearProduct() {
				this.selectedProduct = {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					quantity: 0,
					Product_SellingPrice: 0.00,
					total: 0.00
				}
			},
			calculateTotal() {
				this.quotation.subTotal = this.cart.reduce((prev, curr) => {
					return prev + parseFloat(curr.total)
				}, 0).toFixed(2);
				this.quotation.vat = ((parseFloat(this.quotation.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
				if (event.target.id == 'discount') {
					this.discountPercent = (parseFloat(this.quotation.discount) / parseFloat(this.quotation.subTotal) * 100).toFixed(2);
				} else {
					this.quotation.discount = ((parseFloat(this.quotation.subTotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				}
				this.quotation.total = ((parseFloat(this.quotation.subTotal) + parseFloat(this.quotation.vat)) - parseFloat(this.quotation.discount)).toFixed(2);
			},
			saveQuotation() {
				if (this.cart.length == 0) {
					alert('Cart is empty');
					return;
				}

				let url = "/add_quotation";
				if (this.quotation.quotationId != 0) {
					url = "/update_quotation";
				}

				this.quotation.quotationFrom = this.selectedBranch.branch_id;

				let data = {
					quotation: this.quotation,
					cart: this.cart,
					customer: this.selectedCustomer
				}
				axios.post(url, data).then(async res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						let conf = confirm('Do you want to view invoice?');
						if (conf) {
							window.open('/quotation_invoice/' + r.quotationId, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = '/quotation';
						} else {
							window.location = '/quotation';
						}
					}
				})
			},
			getQuotations() {
				axios.post('/get_quotations', {
					quotationId: this.quotation.quotationId
				}).then(res => {
					let r = res.data;
					let quotation = r.quotations[0];
					this.quotation.quotationBy = quotation.AddBy;
					this.quotation.invoiceNo = quotation.SaleMaster_InvoiceNo;
					this.quotation.salesFrom = quotation.SaleMaster_branchid;
					this.quotation.salesDate = quotation.SaleMaster_SaleDate;
					this.quotation.subTotal = quotation.SaleMaster_SubTotalAmount;
					this.quotation.discount = quotation.SaleMaster_TotalDiscountAmount;
					this.quotation.vat = quotation.SaleMaster_TaxAmount;
					this.quotation.total = quotation.SaleMaster_TotalSaleAmount;

					this.vatPercent = parseFloat(this.quotation.vat) * 100 / parseFloat(this.quotation.subTotal);
					this.discountPercent = parseFloat(this.quotation.discount) * 100 / parseFloat(this.quotation.subTotal);
					this.selectedCustomer = {
						Customer_SlNo: quotation.SalseCustomer_IDNo ?? "",
						Customer_Name: quotation.SaleMaster_customer_name,
						Customer_Mobile: quotation.SaleMaster_customer_mobile,
						Customer_Address: quotation.SaleMaster_customer_address,
						Customer_Type: quotation.customerType,
						display_name: quotation.owner_name == null ? "Cash Customer" : `${quotation.Customer_Name} - ${quotation.Customer_Code} - ${quotation.SaleMaster_customer_mobile}`
					}

					r.quotationDetails.forEach(product => {
						let cartProduct = {
							productId: product.Product_IDNo,
							categoryName: product.ProductCategory_Name,
							name: product.Product_Name,
							salesRate: product.SaleDetails_Rate,
							quantity: product.SaleDetails_TotalQuantity,
							total: product.SaleDetails_TotalAmount
						}

						this.cart.push(cartProduct);
					})
					this.getProducts();
				})
			}
		}
	})
</script>