<?php
$serial = "E1000";
$query = $this->db->query("SELECT * FROM tbl_employee order by Employee_ID desc limit 1");
$result = $query->row();
if (@$result->Employee_ID != null) {
	$serial = $result->Employee_ID;
}
$serial = explode("E", $serial);
if ($serial[1] >= 9) {
	$serial = $serial['1'];
	$autoserial = $serial + 1;
	$generateCode = "E" . $autoserial;
} else {
	$serial = $serial[1];
	$autoserial = $serial + 1;
	$generateCode = "E0" . $autoserial;
}
?>
<style>
	.add-button {
		padding: 2.5px;
		width: 100%;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
		cursor: pointer;
		border-radius: 3px;
	}

	.add-button:hover {
		background-color: #41add6;
		color: white;
	}
</style>
<div id="Edit_emloyee_form">
	<div class="row">
		<div class="col-md-6">
			<fieldset class="scheduler-border scheduler-search">
				<legend class="scheduler-border">Job Information</legend>
				<div class="control-group">
					<div class="form-group">
						<label class="col-md-4 control-label" for="Product_id"> Employee ID </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-2">
							<input type="text" name="Employeer_id" id="Employeer_id" value="<?php echo $employee->Employee_ID; ?>" class="form-control" readonly />
						</div>

						<label class="col-md-2 control-label" for="bio_id"> Bio ID: </label>
						<div class="col-md-2 no-padding-left">
							<input type="text" name="bio_id" id="bio_id" value="<?php echo $employee->bio_id; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_name"> Employee Name </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="em_name" name="em_name" value="<?php echo $employee->Employee_Name; ?>" placeholder="Employee Name .." class="form-control" />
							<div id="em_name_" class="col-md-12"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_Designation"> Designation </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6" style="display: flex;align-items:center;">
							<div style="width: 88%;">
								<select class="chosen-select form-control" name="em_Designation" id="em_Designation" data-placeholder="Choose a Designation...">
									<option value=""> </option>
									<?php
									$query = $this->db->query("SELECT * FROM tbl_designation where status='a' order by Designation_Name asc");
									$row = $query->result();
									foreach ($row as $row) { ?>
										<option value="<?php echo $row->Designation_SlNo; ?>" <?= $employee->Designation_ID == $row->Designation_SlNo ? 'selected' : ''; ?>><?php echo $row->Designation_Name; ?></option>
									<?php } ?>
								</select>
								<div id="em_Designation"></div>
							</div>
							<div style="width:12%;margin-left:2px;">
								<a href="<?= base_url('designation') ?>" title="Add New Designation" style="margin-top:-3px;" class="add-button" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_Depertment"> Department </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6" style="display: flex;align-items:center;">
							<div style="width: 88%;">
								<select class="chosen-select form-control" name="em_Depertment" id="em_Depertment" data-placeholder="Choose a Depertment...">
									<option value=""> </option>
									<?php
									$dquery = $this->db->query("SELECT * FROM tbl_department order by Department_Name asc ");
									$drow = $dquery->result();
									foreach ($drow as $drow) { ?>
										<option value="<?php echo $drow->Department_SlNo; ?>" <?= $employee->Department_ID == $drow->Department_SlNo ? 'selected' : ''; ?>><?php echo $drow->Department_Name; ?></option>
									<?php } ?>
								</select>
								<div id="em_Depertment"></div>
							</div>
							<div style="width:12%;margin-left:2px;">
								<a href="<?= base_url('depertment') ?>" title="Add New Department" style="margin-top:-3px;" class="add-button" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_Joint_date">Joint Date</label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input class="form-control" name="em_Joint_date" id="em_Joint_date" type="date" data-date-format="yyyy-mm-dd" style="border-radius: 5px !important;margin-bottom:4px;" value="<?php echo $employee->Employee_JoinDate; ?>" />
						</div>
					</div>


					<div class="form-group">
						<label class="col-md-4 control-label" for="salary_range">Salary Range</label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="salary_range" name="salary_range" value="<?php echo $employee->salary_range; ?>" placeholder="Salary Range .." class="form-control" />
							<div id="salary_range_" class="col-md-12"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="form-field-1"> Activation status</label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<select class="chosen-select form-control" name="status" id="status" data-placeholder="Choose a status...">
								<option value="a" <?= $employee->status == 'a' ? 'selected' : '' ?>> Active </option>
								<option value="p" <?= $employee->status == 'p' ? 'selected' : '' ?>> Deactive </option>
							</select>
						</div>
					</div>
				</div>
			</fieldset>
		</div>



		<div class="col-md-6">
			<fieldset class="scheduler-border scheduler-search">
				<legend class="scheduler-border">Contact Information</legend>
				<div class="control-group">

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_Present_address"> Present Address </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="em_Present_address" value="<?= $employee->Employee_PrasentAddress ?>" name="em_Present_address" placeholder="Present Address" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_Permanent_address"> Permanent Address </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="em_Permanent_address" value="<?= $employee->Employee_PermanentAddress ?>" name="em_Permanent_address" placeholder="Present Address" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_contact"> Contact No </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="em_contact" name="em_contact" value="<?= $employee->Employee_ContactNo ?>" placeholder="Contact No" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="ec_email"> E-mail </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="ec_email" name="ec_email" value="<?= $employee->Employee_Email ?>" placeholder="E-mail" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="ec_email"> E-mail </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="ec_email" name="ec_email" value="<?= $employee->Employee_Email ?>" placeholder="E-mail" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nid"> NID </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="nid" name="nid" value="<?= $employee->Employee_NID ?>" placeholder="NID" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_reference"> Reference </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<textarea id="em_reference" name="em_reference" placeholder="Reference" value="<?= $employee->Employee_Reference ?>" class="form-control"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for=""> </label>
						<label class="col-md-1 control-label"></label>
						<div class="col-md-6 text-right">
							<button type="button" onclick="Employee_submit()" name="btnSubmit" title="Save" class="btnSave">
								Update
								<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
							</button>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="col-md-6">
			<fieldset class="scheduler-border scheduler-search">
				<legend class="scheduler-border">Personal Information</legend>
				<div class="control-group">

					<div class="form-group">
						<label class="col-md-4 control-label" for="form-field-1"> Father's Name </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="em_father" name="em_father" placeholder="Father's Name" class="form-control" value="<?= $employee->Employee_FatherName ?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="form-field-1"> Mother's Name </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="mother_name" name="mother_name" placeholder="Mother's Name" class="form-control" value="<?= $employee->Employee_MotherName ?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="form-field-1"> Gender </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<select class="chosen-select form-control" name="Gender" id="Gender" data-placeholder="Choose a Gender...">
								<option value="Male" <?= $employee->Employee_Gender == 'Male' ? 'selected' : '' ?>>Male</option>
								<option value="Female" <?= $employee->Employee_Gender == 'Female' ? 'selected' : '' ?>>Female</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="em_dob">Date of Birth</label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input class="form-control" name="em_dob" id="em_dob" type="date" style="border-radius: 5px !important;margin-bottom:4px;" value="<?php echo $employee->Employee_BirthDate; ?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="Marital"> Marital status </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<select class="chosen-select form-control" name="Marital" id="Marital" data-placeholder="Choose a Marital status...">
								<option value="unmarried" <?= $employee->Employee_MaritalStatus == 'unmarried' ? 'selected' : '' ?>>Unmarried</option>
								<option value="married" <?= $employee->Employee_MaritalStatus == 'married' ? 'selected' : '' ?>>Married</option>
							</select>
						</div>
					</div>
				</div>
			</fieldset>
		</div>

		<div class="col-md-6">
			<input type="file" id="em_photo" name="em_photo" class="form-control" onchange="readURL(this)" style="height: 26px;padding: 1px 0;border-radius: 3px;" />
			<img id="hideid" src="<?php echo base_url(); ?>uploads/no_user.png" alt="" style="width:100px;">
			<img id="preview" src="#" style="width:80px;height:80px" hidden>
		</div>
	</div>
</div>


<script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById('preview').src = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
			$("#hideid").hide();
			$("#preview").show();
		}
	}
</script>
<script type="text/javascript">
	function Employee_submit() {
		var Employeer_id = $("#Employeer_id").val();
		var em_name = $("#em_name").val();
		if (em_name == "") {
			$("#em_name").css('border-color', 'red');
			return false;
		}
		var em_Designation = $("#em_Designation").val();
		if (em_Designation == "") {
			$("#em_Designation").css('border-color', 'red');
			return false;
		}
		var em_Depertment = $("#em_Depertment").val();
		if (em_Depertment == "") {
			$("#em_Depertment").css('border-color', 'red');
			return false;
		}
		var em_Joint_date = $("#em_Joint_date").val();
		if (em_Joint_date == "") {
			$("#em_Joint_date").css('border-color', 'red');
			return false;
		}
		var Gender = $("#Gender").val();
		if (Gender == "") {
			$("#Gender").css('border-color', 'red');
			return false;
		}
		var em_dob = $("#em_dob").val();
		if (em_dob == "") {
			$("#em_dob").css('border-color', 'red');
			return false;
		}
		var Marital = $("#Marital").val();
		if (Marital == "") {
			$("#Marital").css('border-color', 'red');
			return false;
		}
		var em_contact = $("#em_contact").val();
		if (em_contact == "") {
			$("#em_contact").css('border-color', 'red');
			return false;
		}
		var em_Present_address = $("#em_Present_address").val();
		var em_reference = $("#em_reference").val();

		var em_father = $("#em_father").val();
		var mother_name = $("#mother_name").val();

		var em_Permanent_address = $("#em_Permanent_address").val();



		var ec_email = $("#ec_email").val();
		var salary_range = $("#salary_range").val();
		var status = $("#status").val();

		var fd = new FormData();
		fd.append('em_photo', $('#em_photo')[0].files[0]);
		fd.append('iidd', "<?php echo $employee->Employee_SlNo; ?>");
		fd.append('Employeer_id', $('#Employeer_id').val());
		fd.append('em_name', $('#em_name').val());
		fd.append('em_Designation', $('#em_Designation').val());
		fd.append('em_Depertment', $('#em_Depertment').val());
		fd.append('em_Joint_date', $('#em_Joint_date').val());
		fd.append('em_father', $('#em_father').val());
		fd.append('mother_name', $('#mother_name').val());
		fd.append('em_Present_address', $('#em_Present_address').val());
		fd.append('em_reference', $('#em_reference').val());
		fd.append('em_Permanent_address', $('#em_Permanent_address').val());
		fd.append('em_dob', $('#em_dob').val());
		fd.append('em_contact', $('#em_contact').val());
		fd.append('Gender', $('#Gender').val());
		fd.append('ec_email', $('#ec_email').val());
		fd.append('Marital', $('#Marital').val());
		fd.append('bio_id', $('#bio_id').val());
		fd.append('nid', $('#nid').val());

		fd.append('salary_range', $('#salary_range').val());
		fd.append('status', $('#status').val());

		var x = $.ajax({
			url: "<?php echo base_url(); ?>employeeUpdate",
			type: "POST",
			data: fd,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			success: function(res) {
				let resp = $.parseJSON(res);
				alert(resp.message);
				if (resp.success) {
					location.href = '/employee'
				}
			}
		});
	}
</script>