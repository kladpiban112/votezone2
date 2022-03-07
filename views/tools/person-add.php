<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$servicetype = filter_input(INPUT_GET, 'servicetype', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$serviceid = base64_decode($serviceid);
$servicetype = base64_decode($servicetype);
$action = base64_decode($act);
if ($action == 'edit') {
    $txt_title = 'แก้ไข';
    $action = $action;

    $stmt_data = $conn->prepare('SELECT p.*,o.org_name FROM '.DB_PREFIX.'person_borrow p 
	LEFT JOIN '.DB_PREFIX."org_main o ON p.org_id = o.org_id 
  WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $sql_service = 'SELECT s.* FROM '.DB_PREFIX.'tools_borrow_main s 
	LEFT JOIN '.DB_PREFIX."person_borrow p ON s.person_id = p.oid 
  WHERE s.service_id = '$serviceid' AND s.flag != '0'  LIMIT 1";
    $stmt_service = $conn->prepare($sql_service);
    $stmt_service->execute();
    $row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);
} else {
    $txt_title = 'เพิ่ม';
    $action = 'add';
}

if (($servicetype == '2')) {
    $stmt_data = $conn->prepare('SELECT p.*,o.org_name FROM '.DB_PREFIX.'person_borrow p 
	LEFT JOIN '.DB_PREFIX."org_main o ON p.org_id = o.org_id 
  WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);
}
?>



<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">
        <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;">1</div>
        <h3 class="card-title">
            <i class="fas fa-clipboard-list"></i>&nbsp;<?php echo $txt_title; ?>ยืม-คืน
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="dashboard.php?module=<?php echo $module; ?>"
                    class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left"
                        title="ย้อนกลับ"></i></a>
            </div>
        </div>
    </div>


    <form class="form" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action; ?>" />
        <input type="hidden" class="form-control" name="serviceid" id="serviceid" value="<?php echo $serviceid; ?>" />
        <input type="hidden" class="form-control" name="personid" id="personid" value="<?php echo $personid; ?>" />
        <div class="card-body">


            <div class="row">
                <div class="col-lg-12">

                    <span><i class="far fa-bookmark"></i> รับบริการยืม/คืน</span>
                    <hr>
                    <div class="form-group row">


                        <div class="col-lg-2">
                            <label>วันที่ยืม/คืน</label>
                            <input type="text" class="form-control" name="servicedate" id="servicedate"
                                placeholder="วันที่รับบริการ"
                                value="<?php echo date_db_2form($row_service['service_date']); ?>"
                                data-date-language="th-th" maxlength="10" />
                            <span class="form-text text-muted"></span>

                        </div>

                        <div class="col-lg-3">
                            <label>รับบริการ</label>
                            <select class="form-control " name="service" id="service">
                                <option value="1" <?php if ($row_service['service_type'] == '1') {
    echo 'selected';
}?>>ยืมอุปกรณ์</option>
                                <option value="2" <?php
                                if ($servicetype == '2') {
                                    $servicetype = '2';
                                } else {
                                    $servicetype = $row_service['service_type'];
                                }
                                if ($servicetype == '2') {
                                    echo 'selected';
                                }

                                ?>>คืนอุปกรณ์</option>
                            </select>
                        </div>

                        <!--<div class="col-lg-2">
                            <label>กำหนดคืน</label>
                            <select class="form-control " name="returnday" id="returnday">
                                <option value="" <?php if ($row_service['return_day'] == '') {
                                    echo 'selected';
                                }?>>กำหนดเอง</option>
                                <option value="30" <?php if ($row_service['return_day'] == '30') {
                                    echo 'selected';
                                }?>>30 วัน</option>
                                <option value="60" <?php if ($row_service['return_day'] == '60') {
                                    echo 'selected';
                                }?>>60 วัน</option>
                            </select>
                        </div>-->

                        <div class="col-lg-2">
                            <label>กำหนดวันคืน</label>
                            <input type="text" class="form-control" name="returndate" id="returndate"
                                placeholder="กำหนดวันคืน"
                                value="<?php echo date_db_2form($row_service['return_date']); ?>"
                                data-date-language="th-th" maxlength="10" />

                        </div>

                        <div class="col-lg-3">
                            <label>หน่วยงาน</label>
                            <select class="form-control " name="org_id" id="org_id">
                                <option value="">ระบุ</option>
                                <?php
                    if ($logged_user_role_id == '1') {
                        $conditions = ' ';
                    } else {
                        $conditions = " AND org_id = '$logged_org_id' ";
                    }
                    $stmt_user_role = $conn->prepare('SELECT * FROM '.DB_PREFIX."org_main WHERE flag = 1  $conditions  ORDER BY org_id ASC");
                    $stmt_user_role->execute();
                    while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                        $id_selected = $row['org_id'];
                        $title_selected = stripslashes($row['org_name']); ?>
                                <option value="<?php echo $id_selected; ?>" <?php if ($row_person['org_id'] == $id_selected) {
                            echo 'selected';
                        } ?>><?php echo $title_selected; ?></option>
                                <?php
                    }
                    ?>
                            </select>
                        </div>


                    </div>
                    <span><i class="far fa-user"></i> ข้อมูลผู้รับบริการ</span>
                    <hr>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label>ประเภทบุคคลที่ต้องการยืมเครื่องมือ</label>
                            <div class="col-9 col-form-label">
                                <div class="radio-inline">
                                    <label class="radio radio-success">
                                        <input type="radio" id="person" name="person_type" value="1" <?php if ($row_person['person_type'] == '1') {
                                    echo "checked='checked' ";
                                }?> />
                                        <span></span>
                                        บุคคลทั่วไป
                                    </label>
                                    <label class="radio radio-success">
                                        <input type="radio" id="company" name="person_type" value="2" <?php if ($row_person['person_type'] == '2') {
                                    echo "checked='checked' ";
                                }?> />
                                        <span></span>
                                        ช่าง
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="staff" class="col-lg-3" style="display: none;">
                            <label>รายชื่อช่าง</label>
                            <div class="input-group">
                                <select class="form-control " name="staff_id" id="staff_id">
                                    <option value="">ระบุ</option>
                                    <?php
                    if ($logged_user_role_id == '1') {
                        //$conditions = ' ';
                        $conditions = " AND org_id = '$logged_org_id' ";
                    } else {
                        $conditions = " AND org_id = '$logged_org_id' ";
                    }
                    $stmt_user_role = $conn->prepare('SELECT * FROM '.DB_PREFIX."staff_main WHERE flag = 1  $conditions  ORDER BY oid ASC");
                    $stmt_user_role->execute();
                    while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                        $id_selected = $row['oid'];
                        $title_selected1 = stripslashes($row['fname']);
                        $title_selected2 = stripslashes($row['lname']); ?>
                                    <option value="<?php echo $id_selected; ?>">
                                        <?php echo $title_selected1.' '.$title_selected2; ?></option>
                                    <?php
                    }
                    ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>เลขบัตรประชาชน</label>

                            <input type="text" class="form-control" placeholder="เลขบัตรประชาชน 13 หลัก" name="cid"
                                id="cid" maxlength="13" value="<?php echo $row_person['cid']; ?>" />

                        </div>
                       

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label>คำนำหน้า</label>
                            <select class="form-control " name="prename" id="prename">
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare('SELECT * FROM '.DB_PREFIX.'cprename  ORDER BY id_prename ASC');
                          $stmt_user_role->execute();
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                              $id_selected = $row['id_prename'];
                              $title_selected = stripslashes($row['prename']); ?>
                                <option value="<?php echo $id_selected; ?>" <?php if ($row_person['prename'] == $id_selected) {
                                  echo 'selected';
                              } ?>><?php echo $title_selected; ?></option>
                                <?php
                          }
                          ?>
                            </select>

                        </div>
                        <div class="col-lg-5">
                            <label>ชื่อ</label>
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ"
                                value="<?php echo $row_person['fname']; ?>" />

                        </div>
                        <div class="col-lg-5">
                            <label>สกุล</label>
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="สกุล"
                                value="<?php echo $row_person['lname']; ?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>โทรศัพท์</label>
                            <input type="text" class="form-control" name="telephone" id="telephone"
                                placeholder="โทรศัพท์" value="<?php echo $row_person['telephone']; ?>" maxlength="10" />
                            <span class="form-text text-muted">หมายเลขโทรศัพท์ 10 หลัก</span>
                        </div>
                    </div>
                </div>
                <!--col-->
            </div>
            <!--col-->
        </div>
        <!--row-->
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary mr-2" id="btnSavePerson"><i class="fa fa-save"
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
    'use strict';

    getoptselect_amphur();
    getoptselect_tambon();
    //แสดง รายชื่อช่างเมื่อคลิกเลือก checkbox ช่าง

    $('input[type="radio"]').click(function() {
        //var ptype = $("[name=person_type]:checked").attr("value");
        var inputValue = $(this).attr("value");
        if (inputValue == '2') {
            $("#staff").show();
            $("#cid").prop("disabled", true);
            $("#prename").prop("disabled", true);
            $("#fname").prop("disabled", true);
            $("#lname").prop("disabled", true);
            $("#telephone").prop("disabled", true);
        } else {
            $("#staff").hide();
        }



    });

    /*var dateStr = '2019-05-01';
    var days = 30;

    var result = new Date(new Date(dateStr).setDate(new Date(dateStr).getDate() + days));
    //console.log(result);

    //var result = new Date();
    var dd = String(result.getDate()).padStart(2, '0');
    var mm = String(result.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = (result.getFullYear() +543);

    var today = dd + '/' + mm + '/' + yyyy;

    console.log(today); */



});


$('#birthdate').datepicker({
    autoclose: true
});

$('#servicedate').datepicker({
    autoclose: true
});


$('#returndate').datepicker({
    autoclose: true
});


$("#returnday").change(function() {

    calReturndate();
});

$("#changwat").change(function() {
    $("#txt_ampur").val('');
    $("#txt_tambon").val('');
    getoptselect_amphur();
    getoptselect_tambon();
});


$("#ampur").change(function() {
    $("#txt_tambon").val('');
    getoptselect_tambon();
});


function calReturndate() {
    var dateStr = $("#servicedate").val();
    var days = $("#returnday").val();
    //console.log(dateStr.length);

    if (dateStr.length > 0) {
        var dateStr = (parseFloat(dateStr.substring(6, 10)) - parseFloat(543)) + "-" +
            dateStr.substring(3, 5) + "-" +
            dateStr.substring(0, 2);
        var result = new Date(new Date(dateStr).setDate(new Date(dateStr).getDate() + days));
        var dd = String(result.getDate()).padStart(2, '0');
        var mm = String(result.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = (result.getFullYear() + 543);
        var nextday = dd + '/' + mm + '/' + yyyy;
        //console.log(dateStr);
        $("#returndate").val(nextday);
    } else {
        $("#returndate").val('');
    }



}




function getoptselect_amphur() {

    var changwatcode = $("#changwat").val();
    var ampur = $("#txt_ampur").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-ampur.php",
        //dataType: "json",
        data: {
            changwatcode: changwatcode,
            ampur: ampur
        },
        success: function(data) {

            $("#ampur").empty();
            $("#ampur").append(data);
        } // success
    });
}

function getoptselect_tambon() {

    var changwatcode = $("#changwat").val();
    var ampur = $("#txt_ampur").val();
    var ampurcode = $("#ampur").val();
    var tambon = $("#txt_tambon").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-tambon.php",
        //dataType: "json",
        data: {
            changwatcode: changwatcode,
            ampurcode: ampurcode,
            ampur: ampur,
            tambon: tambon
        },
        success: function(data) {

            $("#tambon").empty();
            $("#tambon").append(data);
        } // success
    });

}
</script>


<script>
/*jQuery(document).ready(function() {
   // KTCkeditor.init();
});
var KTCkeditor = function () {
    // Private functions
    var demos = function () {
        ClassicEditor
            .create( document.querySelector( '#kt-ckeditor-1' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}(); */


$('#btnSavePerson').click(function(e) {
    e.preventDefault();
    if ($('#servicedate').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุวันที่รับบริการ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#service').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุประเภทรับบริการ',
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
    } else if (($('#cid').val().length == "") && ($('#person_type').val() == "1") ) {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุเลขบัตรประชาชน',
            showConfirmButton: false,
            timer: 1000
        });
    } else  if (($('#fname').val().length == "") && ($('#person_type').val() == "1")) {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุชื่อ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if (($('#lname').val().length == "") && ($('#person_type').val() == "1")) {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุนามสกุล',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/tool/person-add.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            /*data: {
                fullname:fullname,
				username:username,
                password:password,
                act:act,
				cid:cid,
				shortname:shortname,
				org_id:org_id,
				user_role:user_role,
				user_status:user_status
                },*/
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
                            //window.location.replace("dashboard.php?module=borrow");
                            window.location.replace(
                                "dashboard.php?module=tools&page=tools-borrow-add&personid=" +
                                data.personid + "&serviceid=" + data.serviceid + "&act=" +
                                data.act + "&staffid=" +
                                data.staffid);
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

$('#cidSearch').click(function(e) {
    e.preventDefault();
    var ptype = $("[name=person_type]:checked").attr("value");
    //alert(ptype);
    if (ptype == "2") {

        if ($('#staff_id').val().length == "") {
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเลือกช่างที่ต้องการยืมอุปกรณ์',
                showConfirmButton: false,
                timer: 1000
            });
        } else {

            var cid = $('#staff_id').val();
            //alert(cid);
            //var data = new FormData(this.form);
            $.ajax({
                type: "POST",
                url: "core/tool/person-search.php",
                dataType: "json",
                //data: data,
                data: {
                    staffcid: cid,
                },
                //processData: false,
                //contentType: false,
                success: function(data) {
                    //alert(data.code);
                    if (data.code == "200") {
                        Swal.fire({
                                icon: 'success',
                                title: 'ค้นหาข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then((value) => {
                                $('#cid').val(data.staffcid);
                                $('#prename').val(data.prename);
                                $('#fname').val(data.fname);
                                $('#lname').val(data.lname);
                                $('#telephone').val(data.telephone);
                                $('#org_id').val(data.org_id);
                                //liff.closeWindow();
                                //window.location.replace("dashboard.php?module=borrow");
                                //window.location.replace("dashboard.php?module=borrow&page=borrow-add&personid="+data.personid+"&serviceid="+data.serviceid+"&act="+data.act);
                            });
                    } else if (data.code == "404") {
                        //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                        Swal.fire({
                                icon: 'error',
                                title: 'ไม่พบข้อมูลที่ค้นหา',
                                //text: 'กรุณาลองใหม่อีกครั้ง'
                            })
                            .then((value) => {
                                //liff.closeWindow();
                            });
                    }
                } // success
            });

        }

    } else {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุประเภทผู้มารับบริการ',
            showConfirmButton: false,
            timer: 1000
        });
    }
}); //  click
</script>