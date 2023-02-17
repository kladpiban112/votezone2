<?php
error_reporting(0);

$personid_enc = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid_enc = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$aid = filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_STRING);
$aid = base64_decode($aid);
$personid = base64_decode($personid_enc);
$serviceid = base64_decode($serviceid_enc);
$action = base64_decode($act);

	$txt_title = "แก้ไข";
	$action = $action;
	$stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX."area p 
    WHERE p.aid = '$aid'  LIMIT 1");
    $stmt_data->execute();	
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT COUNT(pm.team_id) FROM ".DB_PREFIX."mapping_person mp LEFT JOIN area a ON a.aid = mp.aid LEFT JOIN person_sub pm ON mp.oid_map = pm.team_id WHERE mp.aid = ? ");
    $stmt->execute([$aid]);
    // $person_num = $stmt->fetch(PDO::FETCH_ASSOC);
    $person_num = $stmt->fetchColumn();


?>


<style>
.ward-label {
    width: max-content;
    background-color: rgba(0, 116, 229, 0.75);
    color: rgba(255, 255, 255, 1);
    padding: 4px 12px;
    border-radius: 12px;
    font-family: 'Mitr', sans-serif;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.ward-label>.province {
    font-size: 12px;
}

.ward-label>.no {
    font-size: 14px;
}
</style>


<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">
        <!-- <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;"></div> -->
        <h3 class="card-title">
            <i class="far fa-user"></i>&nbsp;สรุปข้อมูลเขตการเลือกตั้ง
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <!-- <?php if($action == "edit"){?>

                        <a href="dashboard.php?module=service&page=service-add&personid=<?php echo $personid_enc;?>" class="btn btn-info btn-sm font-weight-bold mr-2" title="บันทึกรับบริการ"><i class="fas fa-plus" title="บันทึกรับบริการ" ></i> บันทึกรับบริการ</a>

                    <?php }else{?>

                        <a href="#" class="btn btn-default btn-sm font-weight-bold mr-2" title="บันทึกรับบริการ" disabled><i class="fas fa-plus" title="บันทึกรับบริการ" ></i> บันทึกรับบริการ</a>

                    <?php } ?> -->
                <!-- <a href="dashboard.php?module=<?php echo $module;?>&page=main" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a> -->
            </div>
        </div>
    </div>


    <form class="form" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action;?>" />
        <input type="hidden" class="form-control" name="personid" id="personid" value="<?php echo $personid;?>" />
        <input type="hidden" class="form-control" name="serviceid" id="serviceid" value="<?php echo $serviceid;?>" />
        <input type="hidden" class="form-control" name="org_id" id="org_id" value="<?php echo $logged_org_id;?>" />
        <input type="hidden" class="form-control" name="aid" id="aid" value="<?php echo $aid;?>" />
        <input type="hidden" class="form-control" name="la" id="la" value="<?php echo $row_person['latitude'];?>" />
        <input type="hidden" class="form-control" name="long" id="long"
            value="<?php echo $row_person['longitude'];?>" />


        <div class="card-body">


            <div class="row">
                <div class="col-lg-12">

                    <!-- <div class="form-group row">

		</div>

   <span><i class="fas fa-house-user"></i> ที่อยู่เขตเลือกตั้ง :</span>
   
   <hr> -->


                    <input type="hidden" class="form-control" name="txt_ampur" id="txt_ampur"
                        value="<?php echo $row_person['ampur'];?>" />

                    <input type="hidden" class="form-control" name="txt_tambon" id="txt_tambon"
                        value="<?php echo $row_person['tambon'];?>" />
                    <div class="form-group row">

                        <div class="col-lg-3">
                            <label>จังหวัด</label>
                            <select class="form-control form-control-sm" name="changwat" id="changwat" disabled>
                                <?php
                                $stmt = $conn->prepare ("SELECT * FROM cchangwat c ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->changwatcode;
                                $name = $row->changwatname; ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['changwat'] == $id){ echo "selected";}?>><?php echo $name;?>
                                </option>
                                <?php 
                                }
                            ?>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label>เขตการเลือกตั้ง</label>
                            <input type="number" class="form-control form-control-sm" name="area_number"
                                id="area_number" placeholder="เขตการเลือกตั้ง"
                                value="<?php echo $row_person['area_number']; ?>" disabled />

                        </div>

                        <div class="col-lg-3">
                            <label>อำเภอ</label>
                            <select class="form-control form-control-sm" name="ampur" id="ampur" disabled>
                                <option value="">ระบุ</option>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label>ตำบล</label>
                            <select class="form-control form-control-sm" name="tambon" id="tambon" disabled>
                                <option value="">ระบุ</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-lg-2">
                            <label>หมู่ที่</label>
                            <input type="number" class="form-control form-control-sm" name="village" id="village"
                                placeholder="หมู่" value="<?php echo $row_person['village'];?>" disabled />
                        </div>

                        <div class="col-lg-2">
                            <label>หน่วยการเลือกตั้ง</label>
                            <input type="number" class="form-control form-control-sm" name="zone_number"
                                id="zone_number" placeholder="เขตการเลือกตั้ง"
                                value="<?php echo $row_person['zone_number'];?>" disabled />
                        </div>



                        <div class="col-lg-3">
                            <label>ชื่อสถานที่เลือกตั้ง</label>
                            <input type="text" class="form-control form-control-sm" name="zone_name" id="zone_name"
                                placeholder="ชื่อสถานที่" value="<?php echo $row_person['zone_name'];?>" disabled />

                        </div>


                    </div>

                    <div class="row">

                        <div class="col-lg-3">
                            <label>latitude</label>
                            <input type="text" class="form-control form-control-sm" name="latitude" id="latitude"
                                placeholder="latitude" value="<?php echo $row_person['Latitude'];?>" disabled />

                            </input>

                        </div>

                        <div class="col-lg-3">
                            <label>longitude</label>
                            <input type="text" class="form-control form-control-sm" name="longitude" id="longitude"
                                placeholder="longitude" value="<?php echo $row_person['Longitude'];?>" disabled />

                        </div>
                    </div>
                    </br>
                    <div class=" row">
                        <div class="col-lg-12">
                            <label>รายละเอียด</label>
                            <textarea class="form-control editor" name="details" id="details"
                                disabled><?php echo $row_person['details'];?> </textarea>
                        </div>
                    </div>
                </div></br>

                <div class="row col-lg-12">
                    <div class="col-6">

                    </div>
                    <div class="col-3">
                        <h3 class="text-left">สรุปจำนวนคะแนน <?php echo $person_num; ?> คน</h3>
                    </div>
                    <div class="col-3 text-right ">
                        <h3><a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalPerson"><i class="far fa-plus-square"></i>เพิ่มหัวคะแนน</a></h3>
                    </div>
                </div>
                <!-- <br> -->

            </div>
            <!--col-->

        </div>
        <!--col-->
        <div class="row col-lg-12">
            <div class=" col-6" id="map" style="width: 100%; height:650px;">
            </div>
            <div class="col-6" id="map1" style="width: 100%;">
                <div>
                    <h4>ระดับ A - เขตเลือกตั้ง</h4>
                </div>
                <div id="person_area_A"></div>
                <div>
                    <h4>ระดับ B - ระดับอำเภอ</h4>
                </div>
                <div id="person_area_B"></div>
                <div>
                    <h4>ระดับ C - ระดับตำบล</h4>
                </div>
                <div id="person_area_C"></div>
                <div>
                    <h4>ระดับ D - ระดับหมูบ้าน</h4>
                </div>
                <div id="person_area_D"></div>
            </div>
        </div>

        <!-- <br> -->
        <div class="card-footer">
            <div class="row">
                <!-- <div class="col-lg-6">
                <button type="button" class="btn btn-primary mr-2 btn-sm" id="btnSaveArea"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> </button>
            </div> -->
            </div>
        </div>
</div>
</form>
</div>

<!--end::Card-->
<!--begin::Modal-->
<div class="modal fade" id="modalPerson" tabindex="-1" role="dialog" aria-labelledby="modalPerson" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-plus-square"></i> เลือกหัวคะแนน</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <form class="form" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" class="form-control" name="repairid" id="repairid" value="" />
                    <div class="form-group row ">
                        <input type="hidden" class="form-control" name="aid" id="aid" value="<?php echo $aid;?>" />
                        <div class="col">
                            <label>หัวคะแนน</label>
                            <select class="js-example-basic-single " style="width: 50%" name="level_a" id="level_a">
                                <?php
                                    $stmt = $conn->prepare ("SELECT * FROM person_sub WHERE level = 1 ");
                                    $stmt->execute();
                                    echo "<option value=''>-ระบุ-</option>";
                                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                        $id = $row->oid;
                                        $name = $row->fname." ".$row->lname; ?>
                                <option value="<?php echo $id;?>"><?php echo $name;?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>รายละเอียด</label>
                            <textarea class="form-control editor" name="details" id="details"
                                placeholder="กรุณาระบุชื่อหัวคะแนน"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-success mr-2 " id="btnAddPerson"><i
                                    class="far fa-save"></i> บันทึก</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</form>
<!--end::Modal-->

<!-- Datepicker Thai -->
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-datepicker-thai.js"></script>
<script src="assets/js/locales/bootstrap-datepicker.th.js"></script>

<script type="text/javascript" src="https://api.longdo.com/map/?key=5e785cb06a872f9662a93d93ad733eed"></script>
<script type="text/javascript">
function init() {
    var map = new longdo.Map({
        placeholder: document.getElementById('map')
    });
    map.Layers.setBase(longdo.Layers.POLITICAL);
    map.location({
        lon: 102.065279,
        lat: 14.973517
    }, true);

    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "core/treeview/map_test.php",
        //dataType: "json",
        data: {
            aid: aid
        },
        success: function(data) {

            var data = JSON.parse(data);
            console.log(data);


            var object4 = new longdo.Overlays.Object(data[0].zone_code, 'IG', {
                combine: true,
                simplify: 0.00005,
                ignorefragment: false,
                lineColor: '#888',
                lineStyle: longdo.LineStyle.Dashed,
                fillColor: data[0].area_color,
                label: data[0].zone_name,
            });
            map.Overlays.load(object4);

            var marker1 = new longdo.Marker({
                lon: data[0].lon,
                lat: data[0].lat
            }, {
                title: 'Marker',
                icon: {
                    html: `
                  <div  class="ward-label" >
                    <div class="no"> ${data[0].zone_name}</div>
                  </div>
                `
                },

                draggable: false,
                weight: longdo.OverlayWeight.Top,
            });

            map.Overlays.add(marker1);



        } //success 

    });





    map.zoom(9, true);
    map.Ui.Mouse.enableWheel(false);
    map.Ui.Toolbar.visible(false);
    map.Ui.LayerSelector.visible(false);
    map.Ui.DPad.visible(false);
    map.Ui.Crosshair.visible(false);
    map.Ui.LayerSelector.visible(false);



}
</script>
<script>
$(document).ready(function() {
    'use strict';
    getoptselect_amphur();
    getoptselect_tambon();
    // $('.js-example-basic-single').select2();
    $('#level_a').select2({
        dropdownParent: $('#modalPerson')
    });
    load_person_area_data_A();
    load_person_area_data_B();
    load_person_area_data_C();
    load_person_area_data_D();
    init();



});




$(".add-more").click(function() {
    //alert(99);
    var html = $(".copy").html();
    $(".after-add-more").after(html);
});


$('#birthdate').datepicker({
    autoclose: true
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


$("#level").change(function() {
    if ($("#level").val() == 1) {
        $("#head_h").hide();
    } else {
        $("#head_h").show();
    }
});


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


$('#btnSaveArea').click(function(e) {
    e.preventDefault();
    if ($('#area_number').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#area_number').focus();
        return false;
    } else if ($('#changwat').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#changwat').focus();
        return false;
    } else if ($('#ampur').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#ampur').focus();
        return false;
    } else if ($('#tambon').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#tambon').focus();
        return false;
    } else if ($('#village').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#village').focus();
        return false;
    } else if ($('#zone_number').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#zone_number').focus();
        return false;
    } else if ($('#zone_name').val().length == "") {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        $('#zone_name').focus();
        return false;
    } else {
        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/zone/zone-add.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    alert('บันทึกข้อมูลเรียบร้อยแล้ว')
                        .then((value) => {
                            window.location.replace("dashboard.php?module=zone&page=main");
                        });
                } else if (data.code == "404") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    alert('ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง')
                        .then((value) => {
                            //liff.closeWindow();
                        });
                }
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                // Your error handling logic here..
            } // success
        });
    }
}); // click


function load_person_area_data_A() {
    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "views/zone/zone-data-person-area-A.php",
        //dataType: "json",
        data: {
            aid: aid
        },
        success: function(data) {
            $("#person_area_A").empty(); //add preload
            $("#person_area_A").append(data);
        } // success
    });
}

function load_person_area_data_B() {
    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "views/zone/zone-data-person-area-B.php",
        //dataType: "json",
        data: {
            aid: aid
        },
        success: function(data) {
            $("#person_area_B").empty(); //add preload
            $("#person_area_B").append(data);
        } // success
    });
}

function load_person_area_data_C() {
    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "views/zone/zone-data-person-area-C.php",
        //dataType: "json",
        data: {
            aid: aid
        },
        success: function(data) {
            $("#person_area_C").empty(); //add preload
            $("#person_area_C").append(data);
        } // success
    });
}

function load_person_area_data_D() {
    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "views/zone/zone-data-person-area-D.php",
        //dataType: "json",
        data: {
            aid: aid
        },
        success: function(data) {
            $("#person_area_D").empty(); //add preload
            $("#person_area_D").append(data);
        } // success
    });
}


$('#btnAddPerson').click(function(e) {
    e.preventDefault();
    if ($('#level_a').val().length == "") {
        alert("กรุณาระบุข้อมูล")
    } else {
        var data = new FormData(this.form);
        console.log(data);
        $.ajax({
            type: "POST",
            url: "core/zone/zone-add-person.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    alert("บันทึกสำเร็จ");
                    load_person_area_data_A();
                    load_person_area_data_B();
                    load_person_area_data_C();
                    load_person_area_data_D();
                    location.reload();
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
                } else if (data.code == "300") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    alert("มีหัวคะแนนรายนี้แล้ว กรุณากรอกข้อมมูลใหม่");
                }
            } // success
        });

    }

}); // click

function delPersonAera(id) {

    var oid = String(id);
    var aid = $('#aid').val();

    $.ajax({
        type: "POST",
        url: "core/zone/zone-del-person-area.php",
        dataType: "json",
        data: {
            oid: oid,
            aid: aid
        },
        success: function(data) {
            if (data.code == "200") {
                alert("ลบข้อมูลสำเร็จ");
                location.reload();
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
            } else if (data.code == "300") {
                //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                alert("มีหัวคะแนนรายนี้แล้ว กรุณากรอกข้อมมูลใหม่");
            }
        } // success
    });

}
</script>