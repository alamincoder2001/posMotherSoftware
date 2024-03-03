<div id="users">
	<form @submit.prevent="saveUser">
		<div class="row" style="margin: 0;">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">User Entry Form</legend>
				<div class="control-group">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-xs-4 control-label" for="txtFirstName"> Full Name </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<input type="text" name="txtFirstName" id="txtFirstName" placeholder="Full Name" v-model="user.FullName" class="form-control" />
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for="user_email"> User Email </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<input type="email" name="user_email" id="user_email" v-model="user.UserEmail" placeholder="User Email" class="form-control" />
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for="Brunch"> Select Branch </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<select class="form-control" style="padding:0;" v-model="user.userBrunch_id" name="Brunch" id="Brunch" data-placeholder="Choose a Brunch...">
									<option value=""> </option>
									<option v-for="item in branches" :value="item.brunch_id">{{item.Brunch_name}}</option>
								</select>
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for="type"> User Type </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<select class="form-control" style="padding:0;" name="type" v-model="user.UserType" id="type">
									<option value=""></option>
									<option value="a">Admin</option>
									<option value="u">User</option>
									<option value="e">Entry User</option>
								</select>
								<div id="brand_" class="col-xs-12"></div>
							</div>
						</div>
	
					</div>
	
					<div class="col-xs-6">
						<div class="form-group">
							<label class="col-xs-4 control-label" for="username"> User name </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<input type="text" id="username" name="username" v-model="user.User_Name" autocomplete="off" placeholder="User name" class="form-control" />
								<div id="usermes" class="col-xs-12"></div>
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for="Password"> Password </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<input type="password" id="assword" name="Password" v-model="user.Password" placeholder="Password" autocomplete="off" class="form-control" />
								<div id="usermes" class="col-xs-12"></div>
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for="rePassword"> Re-Password </label>
							<label class="col-xs-1 control-label">:</label>
							<div class="col-xs-6">
								<input type="password" id="rePassword" name="rePassword" placeholder="Re-Password" v-model="user.Re_Password" class="form-control" />
								<div id="mes" class="col-xs-12"></div>
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-4 control-label" for=""> </label>
							<label class="col-xs-1 control-label"></label>
							<div class="col-xs-6 text-right">
								<button type="submit" name="btnSave" title="Save" class="btnSave">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
	
		</div>
	</form>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="users" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.sl }}</td>
							<td>{{ row.User_ID }}</td>
							<td>{{ row.FullName }}</td>
							<td>{{ row.User_Name }}</td>
							<td>{{ row.UserEmail }}</td>
							<td>
								<span v-if="row.UserType == 'm'" class="badge" style="background: gray;">Super Admin</span>
								<span v-if="row.UserType == 'a'" class="badge badge-success">Admin</span>
								<span v-if="row.UserType == 'e'" class="badge badge-primary">Entry User</span>
								<span v-if="row.UserType == 'u'" class="badge badge-warning">User</span>
							</td>
							<td>
								<span v-if="row.status == 'a'" class="badge badge-success">Active</span>
								<span v-if="row.UserType == 'd'" class="badge badge-danger">Deactive</span>
							</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<i v-if="row.UserType != 'm'" class="btnEdit fa fa-pencil" @click="editUser(row)"></i>
									<i v-if="row.UserType != 'm'" class="btnDelete fa fa-trash" @click="deleteUser(row.District_SlNo)"></i>
								<?php } ?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>

</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#users',
		data() {
			return {
				user: {
					User_SlNo: '',
					FullName: '',
					User_Name: '',
					UserEmail: '',
					userBrunch_id: '',
					Password: '',
					Re_Password: '',
					UserType: '',
				},
				branches: [],

				users: [],
				columns: [{
						label: 'Sl',
						field: 'Sl',
						align: 'center',
						filterable: false
					},
					{
						label: 'UserId',
						field: 'User_ID',
						align: 'center'
					},
					{
						label: 'Full Name',
						field: 'FullName',
						align: 'center'
					},
					{
						label: 'Username',
						field: 'User_Name',
						align: 'center'
					},
					{
						label: 'Email',
						field: 'UserEmail',
						align: 'center'
					},
					{
						label: 'User Type',
						field: 'UserType',
						align: 'center'
					},
					{
						label: 'Status',
						field: 'status',
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
			this.getBranches();
			this.getUsers();
		},
		methods: {
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},
			getUsers() {
				axios.get('/get_users').then(res => {
					this.users = res.data.map((item, index) => {
						item.sl = index + 1;
						return item;
					});
				})
			},
			saveUser() {			
				let url = '/add_user';
				if (this.user.User_SlNo != 0) {
					url = '/update_user';
				}
				axios.post(url, this.user)
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							this.clearForm();
							this.getUsers();
						}
					})

			},
			editUser(user) {
				let keys = Object.keys(this.user);
				keys.forEach(key => {
					this.user[key] = user[key];
				})
			},
			deleteUser(userId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_user', {
					userId: userId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getUsers();
					}
				})
			},
			clearForm() {
				let keys = Object.keys(this.user);
				keys.forEach(key => {
					if (typeof(this.user[key]) == "string") {
						this.user[key] = '';
					} else if (typeof(this.user[key]) == "number") {
						this.user[key] = 0;
					}
				})
			}
		}
	})
</script>