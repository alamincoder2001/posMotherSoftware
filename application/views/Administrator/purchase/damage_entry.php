<style>
    .v-select {
        margin-bottom: 5px;
        background: #fff;
        border-radius: 3px;
    }

    .v-select.open .dropdown-toggle {
        border-bottom: 1px solid #ccc;
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
<div id="damages">
    <div class="row" style="margin: 0;">
        <div class="col-xs-12 col-md-12 col-lg-12 no-padding">
            <fieldset class="scheduler-border entryFrom">
                <div class="control-group">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-1"> Code: </label>
                            <div class="col-md-2">
                                <input type="text" placeholder="Code" class="form-control" v-model="damage.Damage_InvoiceNo" required readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1"> Date: </label>
                            <div class="col-md-3">
                                <input type="date" placeholder="Date" class="form-control" v-model="damage.Damage_Date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1"> Description: </label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Description" v-model="damage.Damage_Description">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Product Information</legend>
            <div class="control-group">
                <div class="col-md-4">
                    <form class="form" @submit.prevent="addToCart">
                        <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right"> Product: </label>
                            <div class="col-md-9">
                                <v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product" v-on:input="productOnChange"></v-select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right"> Quantity: </label>
                            <div class="col-md-9">
                                <input type="number" placeholder="Quantity" class="form-control" v-model="damage.DamageDetails_DamageQuantity" required v-on:input="calculateTotal" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right"> Rate: </label>
                            <div class="col-md-9">
                                <input type="number" step="0.01" placeholder="Rate" class="form-control" v-model="damage.damage_rate" required v-on:input="calculateTotal" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right"> Amount: </label>
                            <div class="col-md-9">
                                <input type="number" placeholder="Amount" class="form-control" v-model="damage.damage_amount" required disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right"></label>
                            <div class="col-md-9 text-right">
                                <button type="submit" class="btnCart">
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 no-padding">
                    <div style="background: #fdfdfd;width:100%;height:110px;display: flex;flex-direction: column;align-items: center;justify-content: center;">
                        <p v-if="productStock > 0" style="color:green;margin:0;font-size:9px;margin-bottom:8px;">Stock Available</p>
                        <p v-else style="color:red;margin:0;font-size:9px;margin-bottom:8px;">Stock Unavailable</p>
                        <strong :style="{color: productStock > 0 ? 'green' : 'red'}">{{productStock}}</strong>
                        <strong>{{productUnit}}</strong>
                    </div>
                </div>
                <div class="col-md-7">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in carts">
                                <td>{{sl + 1}}</td>
                                <td>{{item.productName}} - {{item.productCode}}</td>
                                <td>{{item.quantity}}</td>
                                <td>{{item.rate}}</td>
                                <td>{{item.total}}</td>
                                <td>
                                    <i class="fa fa-trash btnDelete"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="row">
        <div class="col-md-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="damages" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Damage_InvoiceNo }}</td>
                            <td>{{ row.Damage_Date }}</td>
                            <td>{{ row.Product_Code }}</td>
                            <td>{{ row.Product_Name }}</td>
                            <td>{{ row.DamageDetails_DamageQuantity }}</td>
                            <td>{{ row.damage_rate }}</td>
                            <td>{{ row.damage_amount }}</td>
                            <td>{{ row.Damage_Description }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editDamage(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteDamage(row.Damage_SlNo)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#damages',
        data() {
            return {
                damage: {
                    Damage_SlNo: 0,
                    Damage_InvoiceNo: '<?php echo $damageCode; ?>',
                    Damage_Date: moment().format('YYYY-MM-DD'),
                    Damage_Description: '',
                    Product_SlNo: '',
                    DamageDetails_DamageQuantity: '',
                    damage_rate: '',
                    damage_amount: 0,
                },
                products: [],
                selectedProduct: {
                    Product_SlNo: "",
                    Product_Code: "",
                    Product_Name: "",
                    quantity: 0,
                    Product_Purchase_Rate: 0,
                    total: 0,
                },
                carts: [],
                productStock: 0,
                productUnit: '',
                damages: [],
                columns: [{
                        label: 'Code',
                        field: 'Damage_InvoiceNo',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Date',
                        field: 'Damage_Date',
                        align: 'center'
                    },
                    {
                        label: 'Product Code',
                        field: 'Product_Code',
                        align: 'center'
                    },
                    {
                        label: 'Product Name',
                        field: 'Product_Name',
                        align: 'center'
                    },
                    {
                        label: 'Quantity',
                        field: 'DamageDetails_DamageQuantity',
                        align: 'center'
                    },
                    {
                        label: 'Damage Rate',
                        field: 'damage_rate',
                        align: 'center'
                    },
                    {
                        label: 'Damage Amount',
                        field: 'damage_amount',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'Damage_Description',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 100,
                filter: ''
            }
        },
        created() {
            this.getProducts();
            this.getDamages();
        },
        methods: {
            async productOnChange() {
                if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0)) {
                    // this.damage.damage_rate = this.selectedProduct.Product_Purchase_Rate;

                    // let damage_amount = parseFloat(this.damage.damage_rate) * parseFloat(this.damage.DamageDetails_DamageQuantity);
                    // this.damage.damage_amount = isNaN(damage_amount) ? 0 : damage_amount;

                    this.productStock = await axios.post('/get_product_stock', {
                        productId: this.selectedProduct.Product_SlNo
                    }).then(res => {
                        this.productUnit = this.selectedProduct.Unit_Name
                        return res.data;
                    })
                }
            },
            getProducts() {
                axios.post('/get_products', {
                    isService: 'false'
                }).then(res => {
                    this.products = res.data;
                })
            },
            addToCart() {
                if (this.selectedProduct == null) {
                    alert("Product is empty");
                    return;
                }
                let product = {
                    product_id: this.selectedProduct.Product_SlNo,
                    productCode: this.selectedProduct.Product_Code,
                    productName: this.selectedProduct.Product_Name,
                    quantity: this.selectedProduct.quantity,
                    rate: this.selectedProduct.Product_Purchase_Rate,
                    total: this.selectedProduct.total,
                }

                this.carts.push(product);
            },
            addDamage() {
                if (this.selectedProduct == null) {
                    alert('Select product');
                    return;
                }

                if (this.damage.DamageDetails_DamageQuantity > this.productStock) {
                    alert('Stock unavailable');
                    return;
                }

                this.damage.Product_SlNo = this.selectedProduct.Product_SlNo;

                let url = '/add_damage';
                if (this.damage.Damage_SlNo != 0) {
                    url = '/update_damage'
                }
                axios.post(url, this.damage).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.resetForm();
                        this.damage.Damage_InvoiceNo = r.newCode;
                        this.getDamages();
                    }
                })
            },

            editDamage(damage) {
                let keys = Object.keys(this.damage);
                keys.forEach(key => this.damage[key] = damage[key]);

                this.selectedProduct = {
                    Product_SlNo: damage.Product_SlNo,
                    display_text: `${damage.Product_Name} - ${damage.Product_Code}`,
                    Product_Purchase_Rate: damage.damage_rate
                }
            },

            calculateTotal() {
                let damage_amount = parseFloat(this.damage.damage_rate) * parseFloat(this.damage.DamageDetails_DamageQuantity);
                this.damage.damage_amount = isNaN(damage_amount) ? 0 : damage_amount;
            },

            deleteDamage(damageId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_damage', {
                    damageId: damageId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getDamages();
                    }
                })
            },

            getDamages() {
                axios.get('/get_damages').then(res => {
                    this.damages = res.data;
                })
            },

            resetForm() {
                this.damage.Damage_SlNo = '';
                this.damage.Damage_Description = '';
                this.damage.Product_SlNo = '';
                this.damage.DamageDetails_DamageQuantity = '';
                this.damage.damage_rate = '';
                this.damage.damage_amount = 0;
                this.selectedProduct = null;
                this.productStock = '';
            }
        }
    })
</script>