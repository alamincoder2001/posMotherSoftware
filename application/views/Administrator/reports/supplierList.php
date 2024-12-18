<div id="supplierListReport">
  <div class="row">
    <div class="col-md-12" style="margin: 0;">
      <fieldset class="scheduler-border scheduler-search">
        <legend class="scheduler-border">Supplier List</legend>
        <div class="control-group">
          <form class="form-inline" @submit.prevent="getSuppliers">
            <div class="form-group">
              <label>Search Type</label>
              <select class="form-select" style="height: 26px;margin:0 6px;width:150px;" v-model="searchType">
                <option value="">All</option>
              </select>
            </div>

            <div class="form-group" style="margin-top: -1px;">
              <input type="submit" value="Search">
            </div>
          </form>
        </div>
      </fieldset>
    </div>
  </div>
  <div style="display:none;" v-bind:style="{display: suppliers.length > 0 ? '' : 'none'}">
    <div class="row">
      <div class="col-md-12 text-right">
        <a href="" @click.prevent="printSupplierList"><i class="fa fa-print"></i> Print</a>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" id="printContent">
          <table class="table table-bordered table-condensed">
            <thead>
              <th>Sl</th>
              <th>Supplier Id</th>
              <th>Supplier Name</th>
              <th>Address</th>
              <th>Contact No.</th>
            </thead>
            <tbody>
              <tr v-for="(supplier, sl) in suppliers">
                <td>{{ sl + 1 }}</td>
                <td>{{ supplier.Supplier_Code }}</td>
                <td>{{ supplier.Supplier_Name }}</td>
                <td>{{ supplier.Supplier_Address }} {{ supplier.District_Name }}</td>
                <td>{{ supplier.Supplier_Mobile }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div style="display:none;text-align:center;" v-bind:style="{display: suppliers.length > 0 ? 'none' : ''}">
    No records found
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
  new Vue({
    el: '#supplierListReport',
    data() {
      return {
        searchType: '',
        suppliers: []
      }
    },
    methods: {
      getSuppliers() {
        axios.get('/get_suppliers').then(res => {
          this.suppliers = res.data;
        })
      },

      async printSupplierList() {
        let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">Supplier List</h4>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#printContent').innerHTML}
							</div>
						</div>
                    </div>
                `;

        let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
        printWindow.document.write(`
                    <?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
                `);

        printWindow.document.body.innerHTML += printContent;
        printWindow.focus();
        await new Promise(r => setTimeout(r, 1000));
        printWindow.print();
        printWindow.close();
      }
    }
  })
</script>