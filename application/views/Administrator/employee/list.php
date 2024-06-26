<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>

                        <th>Photo</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th class="hidden-480">Designation</th>
                        <th>Contact No</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($employes) && $employes) {
                        foreach ($employes as $row) {
                    ?>
                            <tr>
                                <td>
                                    <?php if ($row->Employee_Pic_thum) { ?>
                                        <img src="<?php echo base_url() . 'uploads/employeePhoto_thum/' . $row->Employee_Pic_thum; ?>" alt="" style="width:45px;height:45px;">
                                </td>
                            <?php } else { ?>
                                <img src="<?php echo base_url() . 'uploads/no_image.jpg' ?>" alt="" style="width:25px;height:25px;"></td>
                            <?php } ?>
                            </td>
                            <td><?php echo $row->Employee_ID; ?></td>
                            <td class="hidden-480"><?php echo $row->Employee_Name; ?></td>
                            <td><?php echo $row->Designation_Name; ?></td>

                            <td class="hidden-480"><?php echo $row->Employee_ContactNo; ?></td>
                            <td class="hidden-480"><?php if ($row->status == 'a') {
                                                        echo '<strong class="text-success">Active</strong>';
                                                    } else if ($row->status == 'p') {
                                                        echo '<strong class="text-danger">Deactive</strong>';
                                                    } ?></td>

                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">

                                    <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                        <a class="blue" href="<?php echo base_url(); ?>employeeEdit/<?php echo $row->Employee_SlNo; ?>">
                                            <i class="btnEdit ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <span onclick="deleted(<?php echo $row->Employee_SlNo; ?>)"><i class="btnDelete fa fa-trash-o"></i></span>
                                    <?php } ?>

                                </div>
                            </td>
                            </tr>

                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleted(id) {
        var deletedd = id;
        var inputdata = 'deleted=' + deletedd;
        if (confirm("Are you sure, You want to delete this?")) {
            var urldata = "<?php echo base_url(); ?>employeeDelete";
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success: function(data) {
                    alert("Delete Success");
                    location.reload();
                }
            });
        }
    }
</script>


<script type="text/javascript">
    function active(id) {
        var deletedd = id;
        var inputdata = 'deleted=' + deletedd;
        if (confirm("Are you sure, You want to active this?")) {
            var urldata = "<?php echo base_url(); ?>employeeActive";
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success: function(data) {
                    //$("#saveResult").html(data);
                    alert("Delete Success");
                    location.reload();
                }
            });
        }
    }
</script>