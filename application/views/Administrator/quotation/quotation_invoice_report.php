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

<div id="quotationInvoiceReport" class="row">
  <fieldset class="scheduler-border scheduler-search">
    <legend class="scheduler-border">Search Quotation Invoice</legend>
    <div class="control-group">
      <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="form-group" style="margin-top:10px;">
          <label class="col-sm-1 col-sm-offset-2 control-label no-padding-right"> Invoice no </label>
          <label class="col-sm-1 control-label no-padding-right"> : </label>
          <div class="col-sm-3">
            <v-select v-bind:options="invoices" label="SaleMaster_InvoiceNo" v-model="selectedInvoice" v-on:input="viewInvoice" placeholder="Select Invoice"></v-select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2">
            <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewInvoice" style="margin-top:0px;width:150px;display: none;">
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="col-md-8 col-md-offset-2">
    <br>
    <quotation-invoice v-bind:quotation_id="selectedInvoice.SaleMaster_SlNo" v-if="showInvoice"></quotation-invoice>
  </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/quotationInvoice.js"></script>

<script>
  Vue.component('v-select', VueSelect.VueSelect);
  new Vue({
    el: '#quotationInvoiceReport',
    data() {
      return {
        invoices: [],
        selectedInvoice: null,
        showInvoice: false
      }
    },
    created() {
      this.getQuotations();
    },
    methods: {
      getQuotations() {
        axios.get("/get_quotations").then(res => {
          this.invoices = res.data.quotations;
        })
      },
      async viewInvoice() {
        this.showInvoice = false;
        await new Promise(r => setTimeout(r, 500));
        this.showInvoice = true;
      }
    }
  })
</script>