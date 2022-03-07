<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$receiveid = base64_decode($id);
$action = base64_decode($act);
if ($action == 'edit') {
    $txt_title = 'แก้ไข';
    $action = $action;
    $sql = 'SELECT u.*,o.org_name FROM '.DB_PREFIX.'spare_receive u 
	LEFT JOIN '.DB_PREFIX."org_main o ON u.org_id = o.org_id 
	WHERE u.receive_id = '$receiveid' LIMIT 1";
    $stmt_data = $conn->prepare($sql);
    $stmt_data->execute();
    $row_data = $stmt_data->fetch(PDO::FETCH_ASSOC);
} else {
    $txt_title = 'เพิ่ม';
    $action = 'add';
}
?>

<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cart-arrow-down"></i>&nbsp;<?php echo $txt_title; ?>รับเข้าเครื่องมือ
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="dashboard.php?module=<?php echo $module; ?>&page=spare-receive-list"
                    class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left"
                        title="ย้อนกลับ"></i></a>
            </div>
        </div>
    </div>


    <form class="form" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action; ?>" />
        <input type="hidden" class="form-control" name="receive_id" id="receive_id" value="<?php echo $receiveid; ?>" />
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                    <div class="form-group row">

                        <div class="col-lg-2">
                            <label>วันที่รับเข้า</label>
                            <input type="text" class="form-control" name="receivedate" id="receivedate"
                                placeholder="วันที่รับเข้า"
                                value="<?php echo date_db_2form($row_data['receive_date']); ?>"
                                data-date-language="th-th" maxlength="10" />
                            <span class="form-text text-muted"></span>
                        </div>

                        <div class="col-lg-5">
                            <label>ร้านค้า</label>
                            <select class="form-control " name="stores_id" id="stores_id">

                                <option value="">ระบุ</option>
                                <?php
                    if ($logged_user_role_id == '1') {
                        $conditions = ' ';
                    } else {
                        $conditions = " AND s.org_id = '$logged_org_id' ";
                    }
                    $stmt_user_role = $conn->prepare('SELECT s.* FROM '.DB_PREFIX."stores_main s WHERE s.flag = '1' $conditions ");
                    $stmt_user_role->execute();
                    while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                        $id_selected = $row['stores_id'];
                        $title_selected = stripslashes($row['stores_name']); ?>
                                <option value="<?php echo $id_selected; ?>" <?php if ($row_data['stores_id'] == $id_selected) {
                            echo 'selected';
                        } ?>><?php echo $title_selected; ?></option>
                                <?php
                    }
                    ?>
                            </select>

                        </div>

                        <div class="col-lg-5">
                            <label>หน่วยงาน</label>
                            <select class="form-control " name="org_id" id="org_id">
                                <option value="">ระบุ</option>
                                <?php
                    if ($logged_user_role_id == '1') {
                        if ($action == 'edit') {
                            $org_id = $row_data['org_id'];
                            $conditions = " AND org_id = '$org_id' ";
                        } else {
                            $conditions = ' ';
                        }
                    } else {
                        $conditions = " AND org_id = '$logged_org_id' ";
                    }
                    $stmt_user_role = $conn->prepare('SELECT * FROM '.DB_PREFIX."org_main WHERE flag = 1  $conditions  ORDER BY org_id ASC");
                    $stmt_user_role->execute();
                    while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                        $id_selected = $row['org_id'];
                        $title_selected = stripslashes($row['org_shortname']); ?>
                                <option value="<?php echo $id_selected; ?>" <?php if ($row_data['org_id'] == $id_selected) {
                            echo 'selected';
                        } ?>><?php echo $title_selected; ?></option>
                                <?php
                    }
                    ?>
                            </select>
                        </div>


                    </div>


                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>รายละเอียด</label>
                            <textarea rows="" class="form-control editor" name="receive_desc"
                                id="receive_desc"><?php echo $row_data['receive_desc']; ?></textarea>
                        </div>

                    </div>

                    <?php if ($action == 'edit') {?>
                    <span><i class="fas fa-plus-circle"></i> เลือกเครื่องมือ</span>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>เครื่องมือ</label>
                            <select class="form-control " name="spare_id" id="spare_id">
                                <option value="">ระบุ</option>
                                <?php
                      if ($logged_user_role_id == '1') {
                          $conditions = ' ';
                      } else {
                          $conditions = " AND s.org_id = '$logged_org_id' ";
                      }
                      $stmt_user_role = $conn->prepare('SELECT s.* FROM '.DB_PREFIX."spare_main s 
                      
                      WHERE s.spare_type = 2 and s.flag = 1  $conditions  ORDER BY s.spare_id ASC");
                      $stmt_user_role->execute();
                      while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                          $id_selected = $row['spare_id'];
                          $title_selected = stripslashes($row['spare_name']); ?>
                                <option value="<?php echo $id_selected; ?>"><?php echo $title_selected; ?></option>
                                <?php
                      }
                      ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>จำนวน</label>
                            <input type="text" class="form-control" name="spare_quantity" id="spare_quantity"
                                placeholder="" value="" />
                        </div>

                        <div class="col-lg-2">
                            <label>หน่วย</label>
                            <select class="form-control " name="spare_unit" id="spare_unit">

                                <option value="">ระบุ</option>

                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label>ราคา(บาท)</label>
                            <input type="text" class="form-control" name="spare_price" id="spare_price" placeholder=""
                                value="0" />
                        </div>



                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-success mr-2" id="btnAddSpare"><i
                                    class="fas fa-plus-circle"></i> เพิ่มเครื่องมือ</button>
                        </div>

                    </div>
                    <span><i class="fas fa-list"></i> รายการเครื่องมือ</span>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div id="receive_data"></div>
                        </div>
                    </div>

                    <?php } ?>



                </div>
                <!--col-->





            </div>
            <!--col-->
        </div>
        <!--row-->



        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary mr-2" id="btnSave"><i class="fa fa-save"
                            title="ย้อนกลับ"></i> บันทึก</button>
                    <button type="button" class="btn btn-secondary" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> ย้อนกลับ</button>
                </div>
                <div class="col-lg-6 text-right">
                    <!--<button type="reset" class="btn btn-danger">Delete</button>-->
                </div>
            </div>
        </div>
    </form>

</div>
<!--end::Card-->



<script>
$(document).ready(function() {
    loaddata_receive_data();

    $('#stores_id').select2({});


});


function loaddata_receive_data() {
    var receiveid = $("#receive_id").val();
    $.ajax({
        type: "POST",
        url: "views/tools/tools-receive-data.php",
        //dataType: "json",
        data: {
            receiveid: receiveid
        },
        success: function(data) {
            $("#receive_data").empty(); //add preload
            $("#receive_data").append(data);

        } // success
    });
}


$('#receivedate').datepicker({
    autoclose: true
});
$('#spare_id').change(function(e) {
    e.preventDefault();
    var spare_id = $("#spare_id").val();
    //alert(spare_id);
    $.ajax({
        type: "POST",
        url: "core/spare/fn-spare-unit.php",
        data: {
            spare_id: spare_id
        },
        success: function(data) {
            $("#spare_unit").html(data);

        } // success
    });
}); //  





$('#btnSave').click(function(e) {
    e.preventDefault();
    if ($('#receivedate').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุวันที่รับ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#org_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุหน่วยงาน',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#stores_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุร้าน',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/spare/spare-receive.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then((value) => {
                            //liff.closeWindow();
                            if (data.act == '') {
                                window.location.replace(
                                    "dashboard.php?module=tools&page=tools-receive-list");
                            } else {
                                window.location.replace(
                                    "dashboard.php?module=tools&page=tools-receive&id=" +
                                    data.receiveid + "&act=" + data.act);
                            }

                        });
                } else if (data.code == "404") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถบันทึกข้อมูลได้',
                            text: 'กรุณาลองใหม่อีกครั้ง'
                        })
                        .then((value) => {
                            //liff.closeWindow();
                        });
                }
            } // success
        });

    }

}); //  click




$('#btnAddSpare').click(function(e) {
    e.preventDefault();
    if ($('#receive_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาทำรายการ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุเครื่องมือ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_quantity').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุจำนวน',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_unit').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุหน่วย',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/spare/spare-receive-data.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then((value) => {
                            $('#spare_id').val('');
                            $('#spare_quantity').val('');
                            $('#spare_unit').val('');
                            $('#spare_price').val('0');
                            loaddata_receive_data();

                        });
                } else if (data.code == "404") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถบันทึกข้อมูลได้',
                            text: 'กรุณาลองใหม่อีกครั้ง'
                        })
                        .then((value) => {
                            //liff.closeWindow();
                        });
                }
            } // success
        });

    }

}); //  click


function delReceiveData(id) {

    Swal.fire({
        title: 'แน่ใจนะ?',
        text: "ต้องการยกเลิกรายการ !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ใช่, ต้องการยกเลิกรายการ!'
    }).then((result) => {
        if (result.value) { //Yes
            $.post("core/spare/spare-receive-data-del.php", {
                id: id
            }, function(result) {
                // $("#test").html(result);
                //console.log(result);
                //location.reload();
                loaddata_receive_data();
            });
        }
    })
}
</script>