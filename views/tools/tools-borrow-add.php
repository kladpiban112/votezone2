<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$serviceid = base64_decode($serviceid);
$action = base64_decode($act);
if ($action == 'edit') {
    $txt_title = 'แก้ไข';
    $action = $action;

    $sql_service = 'SELECT s.* FROM '.DB_PREFIX.'tools_borrow_main s 
	LEFT JOIN '.DB_PREFIX."person_borrow p ON s.person_id = p.oid 
  WHERE s.service_id = '$serviceid' AND s.flag != '0'  LIMIT 1";
    $stmt_service = $conn->prepare($sql_service);
    $stmt_service->execute();
    $row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);

    $servicetype = $row_service['service_type'];
    $person_type = $row_service['person_type'];
    $staff_id = $row_service['staff_id'];
  
    if($person_type == "1"){
    $stmt_data = $conn->prepare('SELECT p.*,o.org_name FROM '.DB_PREFIX.'person_borrow p 
	LEFT JOIN '.DB_PREFIX."org_main o ON p.org_id = o.org_id 
  WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    }else{

        $stmt_data = $conn->prepare('SELECT p.*,o.org_name FROM '.DB_PREFIX.'staff_main p 
        LEFT JOIN '.DB_PREFIX."org_main o ON p.org_id = o.org_id 
      WHERE p.oid = '$staff_id'  LIMIT 1");
        $stmt_data->execute();
        $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    }

    
} else {
    $txt_title = 'เพิ่ม';
    $action = 'add';

    $stmt_data = $conn->prepare('SELECT u.*,o.org_name FROM '.DB_PREFIX.'person_borrow u 
	LEFT JOIN '.DB_PREFIX."org_main o ON u.org_id = o.org_id 
	WHERE u.oid = '$personid' AND u.flag != '0'  LIMIT 1");
    $stmt_data->execute();
    $row_data = $stmt_data->fetch(PDO::FETCH_ASSOC);
}
?>



<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">
        <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;">2</div>
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
        <input type="hidden" class="form-control" name="oid" id="oid" value="<?php echo $oid; ?>" />
        <input type="hidden" class="form-control" name="serviceid" id="serviceid" value="<?php echo $serviceid; ?>" />
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
                                data-date-language="th-th" maxlength="10" disabled />
                            <span class="form-text text-muted"></span>

                        </div>

                        <div class="col-lg-3">
                            <label>รับบริการ</label>
                            <select class="form-control " name="service" id="service" disabled>
                                <option value="1" <?php if ($row_service['service_type'] == '1') {
    echo 'selected';
}?>>ยืมอุปกรณ์</option>
                                <option value="2" <?php if ($row_service['service_type'] == '2') {
    echo 'selected';
}?>>คืนอุปกรณ์</option>
                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label>กำหนดวันคืน</label>
                            <input type="text" class="form-control" name="returndate" id="returndate"
                                placeholder="กำหนดวันคืน"
                                value="<?php echo date_db_2form($row_service['return_date']); ?>"
                                data-date-language="th-th" maxlength="10" disabled />

                        </div>


                    </div>
                    <span><i class="far fa-user"></i> ข้อมูลผู้ยืมคืน</span>
                    <hr>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>เลขบัตรประชาชน</label>

                            <input type="text" class="form-control" placeholder="Search for..." name="cid" id="cid"
                                value="<?php echo $row_person['cid']; ?>" disabled />


                        </div>
                        <div class="col-lg-6">
                            <label>หน่วยงาน</label>
                            <select class="form-control " name="org_id" id="org_id" disabled>
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

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label>คำนำหน้า</label>
                            <select class="form-control " name="org_id" id="org_id" disabled>
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
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="ชื่อ"
                                value="<?php echo $row_person['fname']; ?>" disabled />

                        </div>
                        <div class="col-lg-5">
                            <label>สกุล</label>
                            <input type="text" class="form-control" name="shortname" id="shortname" placeholder="สกุล"
                                value="<?php echo $row_person['lname']; ?>" disabled />

                        </div>

                    </div>

                    <span><i class="fas fa-tools"></i> ข้อมูลเครื่องมือ <a href="#" class="btn btn-sm btn-primary"
                            data-toggle="modal" data-target="#modalAddTools"><i class="far fa-plus-square"></i>
                            เลือกเครื่องมือ</a></span>
                    <hr>
                    <div id="service_detail"></div>







                </div>
                <!--col-->




            </div>
            <!--col-->
        </div>
        <!--row-->


        <?php
$personid_enc = base64_encode($personid);
$serviceid_enc = base64_encode($serviceid);
?>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <!--<button type="button" class="btn btn-primary mr-2" id="btnSaveEquipment"><i class="fa fa-save" title="ย้อนกลับ" ></i> บันทึก</button>-->
                    <button type="button" class="btn btn-secondary btn-sm" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> ย้อนกลับ</button>

                    <a href="dashboard.php?module=tools&page=tools-borrow-print&personid=<?php echo $personid_enc; ?>&serviceid=<?php echo $serviceid_enc; ?>&act=<?php echo base64_encode('view'); ?>"
                        class="btn btn-success btn-sm font-weight-bold mr-2" title="พิมพ์เอกสาร"><i class="fa fa-print"
                            title=""></i>พิมพ์เอกสาร</a>
                </div>
                <div class="col-lg-6 text-right">
                    <!--<button type="reset" class="btn btn-danger">Delete</button>-->
                </div>
            </div>
        </div>
    </form>

</div>
<!--end::Card-->


<!--begin::Modal-->
<div class="modal fade" id="exampleModalSizeXl" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeXl"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-tools"></i> เครื่องมือ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!--begin: Datatable-->

                <?php

if ($logged_user_role_id == '1') {
    $conditions = ' ';
} else {
    $conditions = " AND u.org_id = '$logged_org_id' ";
}

// ยืม
if ($servicetype == '1') {
    $servicetype_search = " u.flag = '1' ";
// คืน
} elseif ($servicetype == '2') {
    $servicetype_search = " u.flag != ''  ";
} else {
    $serviceservicetype_searchtype = " u.flag = '1' ";
}

//$numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."equipment_main u  WHERE u.flag != '0' $conditions  ")->fetchColumn();

    $sql_eq = 'SELECT u.*,o.org_name,s.status_title,s.status_color,nn.unit_title AS spare_unit_slave_title  
    FROM '.DB_PREFIX.'spare_main u 
    LEFT JOIN '.DB_PREFIX.'org_main o ON u.org_id = o.org_id
    LEFT JOIN '.DB_PREFIX.'equipment_status s ON u.flag = s.status_id 
    LEFT JOIN '.DB_PREFIX."cunit nn ON u.spare_unit_slave = nn.unit_id
    WHERE u.spare_type = 2 and s.status_id = 1 and $servicetype_search $conditions  
    ORDER BY u.spare_id DESC ";
    $stmt_data = $conn->prepare($sql_eq);
    $stmt_data->execute();

?>



                <div class="table-responsive">
                    <table class="table table-separate table-hover table-head-custom table-checkable" id="tbData">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th>รูปเครื่องมือ</th>
                                <th>รหัส</th>
                                <th>ชื่อเครื่องมือ</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">หน่วยนับรอง</th>
                                <th class="text-center">เลือก</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

        $i = 0;
        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
            ++$i;

            $eq_id = $row['spare_id'];
            $oid_enc = base64_encode($eq_id);
            $eq_name = $row['spare_name'];
            $eq_desc = $row['spare_desc'];
            $eq_code = $row['spare_code'];
            $org_name = $row['org_name'];
            $eq_typename = $row['spare_type'];
            $receive_date = date_db_2form($row['add_date']);
            $eq_img = $row['spare_img'];
            $status_title = $row['status_title'];
            $status_color = $row['status_color'];
            $unit_title = $row['spare_unit_slave_title']; ?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center">
                                    <div class="symbol symbol-50 symbol-lg-60">
                                        <?php if ($eq_img == '') {?>
                                        <img src="uploads/no-image.jpg" alt="image" />
                                        <?php } else {?>
                                        <img src="uploads/spare/<?php echo $eq_img; ?>" alt="image" />
                                        <?php   } ?>
                                    </div>
                                </td>
                                <td><?php echo $eq_code; ?></br><small> วันที่รับ : <?php echo $receive_date; ?></small>
                                </td>
                                <td><?php echo $eq_name; ?></td>
                                <td><input type="text" name="amount" id="amount"></td>
                                <td><?php echo $unit_title; ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-outline-success btn-sm"
                                        onclick="addEquipment('<?php echo $eq_id; ?>','<?php echo $serviceid; ?>','<?php echo $servicetype; ?>')">
                                        <i class="far fa-check-square"></i> เลือกอุปกรณ์
                                    </a>
                                </td>

                            </tr>

                            <?php
        } // end while
        ?>
                        </tbody>
                    </table>
                </div>
                <!--end: Datatable-->


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal"><i
                        class="far fa-times-circle"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="modalAddTools" tabindex="-1" role="dialog" aria-labelledby="modalAddTools"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-plus-square"></i> เลือกเครื่องมือ<?php if ($servicetype == '1') {
            echo 'ยืม';
        } elseif ($servicetype == '2') {
            echo 'คืน';
        } else {
            echo '-';
        }?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <form class="form" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" class="form-control" name="act" id="act" value="add" />
                    <input type="hidden" class="form-control" name="serviceid" id="serviceid"
                        value="<?php echo $serviceid; ?>" />
                    <input type="hidden" class="form-control" name="servicetype" id="servicetype"
                        value="<?php echo $servicetype; ?>" />

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
                                                                $title_selected = stripslashes($row['spare_name']);
                                                                $title_stock = $row['spare_stock']; ?>
                                <option value="<?php echo $id_selected; ?>">
                                    <?php echo $title_selected.'('.$title_stock.')'; ?></option>
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
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control" name="spare_desc" id="spare_desc"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-success mr-2" id="btnAddTools"><i
                                    class="far fa-save"></i> บันทึก</button>
                        </div>

                    </div>



            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal"><i
                        class="far fa-times-circle"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>
</form>
<!--end::Modal-->



<script>
$(document).ready(function() {
    loaddata_service_detail();

    var table = $('#tbData');

    // begin first table
    table.DataTable({
        "searching": true,
        "pageLength": 10

    });
});

$('#servicedate').datepicker({
    autoclose: true
});

$('#returndate').datepicker({
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

$('#btnAddTools').click(function(e) {
    e.preventDefault();
    if ($('#serviceid').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาทำรายการ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#servicetype').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุประเภทการยืม/คืนเครื่องมือ',
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
            url: "core/tool/tool-borrow-add.php",
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
                            $('#spare_desc').val('');
                            //loaddata_spare_data();
                            loaddata_service_detail();

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
                loaddata_service_detail();
            } // success
        });

    }

}); //  click

function delEquipment(id) {

    Swal.fire({
        title: 'แน่ใจนะ?',
        text: "ต้องการลบข้อมูล!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ใช่, ต้องการลบข้อมูล!'
    }).then((result) => {
        if (result.value) { //Yes
            $.post("core/tool/tools-data-del.php", {
                id: id
            }, function(result) {
                // $("#test").html(result);
                //console.log(result);
                location.reload();
                loaddata_service_detail();
            });
        }
    })
}


function addEquipment(eqid, serviceid, servicetype) {
    var act = "add";
    $.ajax({
        type: "POST",
        url: "core/tool/tool-borrow-add.php",
        dataType: "json",
        data: {
            act,
            eqid,
            serviceid,
            servicetype
        },
        //cache:false,
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
                        //window.location.replace("dashboard.php?module=equipment");
                    });
            } else if (data.code == "404") {
                Swal.fire({
                        icon: 'error',
                        title: 'เลือกรายการซ่้ำ',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then((value) => {
                        //liff.closeWindow();
                        //window.location.replace("dashboard.php?module=equipment");
                    });
            }
            loaddata_service_detail();
        }

    });
}




function loaddata_service_detail() {
    var serviceid = $("#serviceid").val();
    $.ajax({
        type: "POST",
        url: "views/tools/tools-borrow-detail.php",
        //dataType: "json",
        data: {
            serviceid: serviceid
        },
        success: function(data) {
            $("#service_detail").empty(); //add preload
            $("#service_detail").append(data);

        } // success
    });
}




//Example 2
$('#filer_example2').filer({
    limit: 5,
    maxSize: 10,
    //extensions: ['jpg', 'jpeg', 'png', 'gif','pdf','doc','docx','xls','xlsx','ppt','pptx','zip','rar'],
    extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar'],
    changeInput: true,
    showThumbs: true,
    addMore: true
});


$('.editor').trumbowyg({
    removeformatPasted: true,
    lang: 'th',
    autogrow: true,
    btnsDef: {
        // Create a new dropdown
        image: {
            dropdown: ['insertImage', 'noembed'],
            ico: 'insertImage'
        }
    },


    btns: [
        ['viewHTML'],
        ['undo', 'redo'],
        ['formatting'],
        'btnGrp-semantic',
        ['link'],
        ['table'],
        ['image'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen'],
        ['noembed'],
        ['foreColor', 'backColor'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
    ],

    plugins: {
        upload: {
            serverPath: '<?php echo ADMIN_URL; ?>/assets/plugins/trumbowyg/texteditor-upload.php',
            fileFieldName: 'image'
        }
    },
    table: {
        // Some table plugin options, see details below
    }

});


var defaultOptions = {
    rows: 8,
    columns: 8,
    styler: 'table'
};

$.extend(true, $.trumbowyg, {
    langs: {
        en: {
            table: 'Insert table',
            tableAddRow: 'Add row',
            tableAddColumn: 'Add column',
            tableDeleteRow: 'Delete row',
            tableDeleteColumn: 'Delete column',
            tableDestroy: 'Delete table',
            error: 'Error'
        },

        id: {
            table: 'Sisipkan tabel',
            tableAddRow: 'Sisipkan baris',
            tableAddColumn: 'Sisipkan kolom',
            tableDeleteRow: 'Hapus baris',
            tableDeleteColumn: 'Hapus kolom',
            tableDestroy: 'Hapus tabel',
            error: 'Galat'
        },
        pt_br: {
            table: 'Inserir tabela',
            tableAddRow: 'Adicionar linha',
            tableAddColumn: 'Adicionar coluna',
            tableDeleteRow: 'Deletar linha',
            tableDeleteColumn: 'Deletar coluna',
            tableDestroy: 'Deletar tabela',
            error: 'Erro'
        }
    },

    plugins: {
        table: {
            init: function(t) {
                t.o.plugins.table = $.extend(true, {}, defaultOptions, t.o.plugins.table || {});

                var buildButtonDef = {
                    fn: function() {
                        t.saveRange();

                        var btnName = 'table';

                        var dropdownPrefix = t.o.prefix + 'dropdown',
                            dropdownOptions = { // the dropdown
                                class: dropdownPrefix + '-' + btnName + ' ' + dropdownPrefix + ' ' +
                                    t.o.prefix + 'fixed-top'
                            };
                        dropdownOptions['data-' + dropdownPrefix] = btnName;
                        var $dropdown = $('<div/>', dropdownOptions);

                        if (t.$box.find("." + dropdownPrefix + "-" + btnName).length === 0) {
                            t.$box.append($dropdown.hide());
                        } else {
                            $dropdown = t.$box.find("." + dropdownPrefix + "-" + btnName);
                        }

                        // clear dropdown
                        $dropdown.html('');

                        // when active table show AddRow / AddColumn
                        if (t.$box.find("." + t.o.prefix + "table-button").hasClass(t.o.prefix +
                                'active-button')) {
                            $dropdown.append(t.buildSubBtn('tableAddRow'));
                            $dropdown.append(t.buildSubBtn('tableAddColumn'));
                            $dropdown.append(t.buildSubBtn('tableDeleteRow'));
                            $dropdown.append(t.buildSubBtn('tableDeleteColumn'));
                            $dropdown.append(t.buildSubBtn('tableDestroy'));
                        } else {
                            var tableSelect = $('<table></table>');
                            for (var i = 0; i < t.o.plugins.table.rows; i += 1) {
                                var row = $('<tr></tr>').appendTo(tableSelect);
                                for (var j = 0; j < t.o.plugins.table.columns; j += 1) {
                                    $('<td></td>').appendTo(row);
                                }
                            }
                            tableSelect.find('td').on('mouseover', tableAnimate);
                            tableSelect.find('td').on('mousedown', tableBuild);

                            $dropdown.append(tableSelect);
                            $dropdown.append($('<center>1x1</center>'));
                        }

                        t.dropdown(btnName);
                    }
                };

                var tableAnimate = function(column_event) {
                    var column = $(column_event.target),
                        table = column.parents('table'),
                        colIndex = this.cellIndex,
                        rowIndex = this.parentNode.rowIndex;

                    // reset all columns
                    table.find('td').removeClass('active');

                    for (var i = 0; i <= rowIndex; i += 1) {
                        for (var j = 0; j <= colIndex; j += 1) {
                            table.find("tr:nth-of-type(" + (i + 1) + ")").find("td:nth-of-type(" + (j +
                                1) + ")").addClass('active');
                        }
                    }

                    // set label
                    table.next('center').html((colIndex + 1) + "x" + (rowIndex + 1));
                };

                var tableBuild = function(column_event) {
                    t.saveRange();

                    var tabler = $('<table></table>');
                    if (t.o.plugins.table.styler) {
                        tabler.attr('class', t.o.plugins.table.styler);
                    }

                    var column = $(column_event.target),
                        colIndex = this.cellIndex,
                        rowIndex = this.parentNode.rowIndex;

                    for (var i = 0; i <= rowIndex; i += 1) {
                        var row = $('<tr></tr>').appendTo(tabler);
                        for (var j = 0; j <= colIndex; j += 1) {
                            $('<td></td>').appendTo(row);
                        }
                    }

                    t.range.deleteContents();
                    t.range.insertNode(tabler[0]);
                    t.$c.trigger('tbwchange');
                };

                var addRow = {
                    title: t.lang['tableAddRow'],
                    text: t.lang['tableAddRow'],
                    ico: 'row-below',

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if (table.length > 0) {
                            var row = $('<tr></tr>');
                            // add columns according to current columns count
                            for (var i = 0; i < table.find('tr')[0].childElementCount; i += 1) {
                                $('<td></td>').appendTo(row);
                            }
                            // add row to table
                            row.appendTo(table);
                        }

                        return true;
                    }
                };

                var addColumn = {
                    title: t.lang['tableAddColumn'],
                    text: t.lang['tableAddColumn'],
                    ico: 'col-right',

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if (table.length > 0) {
                            $(table).find('tr').each(function() {
                                $(this).find('td:last').after('<td></td>');
                            });
                        }

                        return true;
                    }
                };

                var destroy = {
                    title: t.lang['tableDestroy'],
                    text: t.lang['tableDestroy'],
                    ico: 'table-delete',

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table');

                        table.remove();

                        return true;
                    }
                };

                var deleteRow = {
                    title: t.lang['tableDeleteRow'],
                    text: t.lang['tableDeleteRow'],
                    ico: 'row-delete',

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            row = $(node).closest('tr');

                        row.remove();

                        return true;
                    }
                };

                var deleteColumn = {
                    title: t.lang['tableDeleteColumn'],
                    text: t.lang['tableDeleteColumn'],
                    ico: 'col-delete',

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table'),
                            td = $(node).closest('td'),
                            cellIndex = td.index();

                        $(table).find('tr').each(function() {
                            $(this).find('td:eq(' + cellIndex + ')').remove();
                        });

                        return true;
                    }
                };

                t.addBtnDef('table', buildButtonDef);
                t.addBtnDef('tableAddRow', addRow);
                t.addBtnDef('tableAddColumn', addColumn);
                t.addBtnDef('tableDeleteRow', deleteRow);
                t.addBtnDef('tableDeleteColumn', deleteColumn);
                t.addBtnDef('tableDestroy', destroy);
            }
        }
    }
});
</script>


<script>
$('#btnSaveEquipment').click(function(e) {
    e.preventDefault();
    if ($('#eq_typeid').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุประเภทกายอุปกรณ์',
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
    } else if ($('#eq_name').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุชื่อการอุปกรณ์',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/equipment/equipment-add.php",
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
                            window.location.replace("dashboard.php?module=equipment");
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
</script>



<script>
$(document).ready(function() {
    'use strict';

    // ------------------------------------------------------- //
    // Text editor (WYSIWYG)
    // ------------------------------------------------------ //


});
</script>


<!--
					<script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6"></script>
                        
                            <script src="assets/js/pages/crud/forms/editors/ckeditor-classic.js?v=7.0.6"></script>
                        -->