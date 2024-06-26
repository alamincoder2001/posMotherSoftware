<style>
    #accountForm select {
        padding: 0 !important;
    }

    #accountsTable .button {
        width: 25px;
        height: 25px;
        border: none;
        color: white;
    }

    #accountsTable .edit {
        background-color: #7bb1e0;
    }

    #accountsTable .delete {
        background-color: #ff6666;
    }
</style>

<div id="accounts">
    <div class="row">
        <div class="col-md-12" style="margin: 0;">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Investment Account Entry Form</legend>
                <div class="control-group">
                    <form id="accountForm" class="form-horizontal" @submit.prevent="saveAccount">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Account Id</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="account.Acc_Code" required readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Account Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="account.Acc_Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Description</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" v-model="account.Acc_Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4 text-right">
                                        <input type="submit" value="Save" class="btnSave">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div id="accountsTable" class="table-responsive">
                <datatable :columns="columns" :data="accounts" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Acc_Code }}</td>
                            <td>{{ row.Acc_Name }}</td>
                            <td>{{ row.Acc_Description }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                        <i class="btnEdit fa fa-pencil" @click="editAccount(row)"></i>
                                        <i class="btnDelete fa fa-trash" @click="deleteAccount(row.Acc_SlNo)"></i>
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
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>

<script>
    new Vue({
        el: '#accounts',
        data() {
            return {
                account: {
                    Acc_SlNo: null,
                    Acc_Code: '<?php echo $accountCode; ?>',
                    Acc_Name: '',
                    Acc_Description: ''
                },
                accounts: [],


                columns: [{
                        label: 'Account Id',
                        field: 'Acc_Code',
                        align: 'center'
                    },
                    {
                        label: 'Account Name',
                        field: 'Acc_Name',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'Acc_Description',
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
            this.getAccounts();
        },
        methods: {
            getAccounts() {
                axios.get('/get_investment_accounts').then(res => {
                    this.accounts = res.data;
                })
            },

            saveAccount() {
                let url = '/add_investment_account';
                if (this.account.Acc_SlNo != null) {
                    url = '/update_investment_account';
                }
                axios.post(url, this.account).then(res => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            this.resetForm();
                            this.account.Acc_Code = r.newAccountCode;
                            this.getAccounts();
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            alert(`${error.response.status}, ${error.response.statusText}`);
                        }
                    })
            },

            editAccount(account) {
                Object.keys(this.account).forEach(key => {
                    this.account[key] = account[key];
                })
            },

            deleteAccount(accountId) {
                let confirmation = confirm("Are you sure?");
                if (confirmation == false) {
                    return;
                }
                axios.post('/delete_investment_account', {
                        accountId: accountId
                    })
                    .then(res => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            this.getAccounts();
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            alert(`${error.response.status}, ${error.response.statusText}`);
                        }
                    })
            },

            resetForm() {
                this.account = {
                    Acc_SlNo: null,
                    Acc_Name: '',
                    Acc_Description: ''
                }
            }
        }
    })
</script>