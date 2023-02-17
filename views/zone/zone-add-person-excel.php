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
	$stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX." area p 
    LEFT JOIN cchangwat c ON p.changwat = c.changwatcode
    LEFT JOIN campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
    LEFT JOIN ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull WHERE p.aid = '$aid'");
    $stmt_data->execute();	
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT COUNT(pm.team_id) FROM ".DB_PREFIX."mapping_person mp LEFT JOIN area a ON a.aid = mp.aid LEFT JOIN person_sub pm ON mp.oid_map = pm.team_id WHERE mp.aid = ? ");
    $stmt->execute([$aid]);
    // $person_num = $stmt->fetch(PDO::FETCH_ASSOC);
    $person_num = $stmt->fetchColumn();


?>

<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div id="excel">
        <div class="card-header ribbon ribbon-right">
            <!-- <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;"></div> -->
            <h3 class="card-title">
                <i class="far fa-user"></i>&nbsp;สรุปข้อมูลเขตการเลือกตั้ง
            </h3>
        </div>

        <form class="form" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action;?>" />
            <input type="hidden" class="form-control" name="personid" id="personid" value="<?php echo $personid;?>" />
            <input type="hidden" class="form-control" name="serviceid" id="serviceid"
                value="<?php echo $serviceid;?>" />
            <input type="hidden" class="form-control" name="org_id" id="org_id" value="<?php echo $logged_org_id;?>" />
            <input type="hidden" class="form-control" name="aid" id="aid" value="<?php echo $aid;?>" />
            <input type="hidden" class="form-control" name="la" id="la" value="<?php echo $row_person['latitude'];?>" />
            <input type="hidden" class="form-control" name="long" id="long"
                value="<?php echo $row_person['longitude'];?>" />

            <div class="card-body">
                <table class="table">

                    <tr>
                        <th class="l">เขตเลือกตั้ง</th>
                        <td><?php echo $row_person['area_number'];?></td>
                        <th class="l">จังหวัด</th>
                        <td><?php echo $row_person['changwatname'];?></td>
                    </tr>
                    <tr>
                        <th class="l">อำเภอ</th>
                        <td><?php echo $row_person['ampurname'];?></td>
                        <th class="l">ตำบล</th>
                        <td><?php echo $row_person['tambonname'];?></td>
                        <th class="l">หมู่</th>
                        <td class="r"><?php echo $row_person['village'];?></td>
                    </tr>
                    <tr>
                        <th class="l">หน่วยเลือกตั้งที่</th>
                        <td><?php echo $row_person['zone_number'];?></td>
                        <th class="l">ชื่อหน่วยเลือกตั้ง</th>
                        <td><?php echo $row_person['zone_name'];?></td>
                    </tr>
                    <tr>
                        <th class="l">สรุปจำนวนคะแนน(คน)</th>
                        <td class="l"><?php echo $person_num;?></td>
                    </tr>

                </table>
                <div class="row">
                    <!-- <div class="row col-lg-12">

                        <div class="col-12">
                            <h3 class="text-left">สรุปจำนวนคะแนน <?php echo $person_num; ?> คน</h3>
                        </div>
                    </div> -->
                    <!-- <br> -->
                </div>
                <!--col-->
            </div>
            <!--col-->
            <div class="row col-lg-12">
                <div class="col-12" id="map1" style="width: 100%;">
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

    </div>
    <!-- <br> -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary mr-2 btn-sm" onClick="PrintDiv();"><i class="fa fa-save"
                        title="พิมพ์รายงาน"></i> พิมพ์รายงาน</button>
            </div>
        </div>
    </div>
</div>
</form>
</div>



<!-- Datepicker Thai -->
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-datepicker-thai.js"></script>
<script src="assets/js/locales/bootstrap-datepicker.th.js"></script>
<!-- Load Leaflet from CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" crossorigin=""></script>
<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@^3.0.8/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-vector@^3.0.0/dist/esri-leaflet-vector.js"></script>
<!-- Load Esri Leaflet Geocoder from CDN -->
<script src="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.js"></script>


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
}); //  click


function load_person_area_data_A() {
    var aid = $("#aid").val();
    $.ajax({
        type: "POST",
        url: "views/zone/zone-data-person-area-A-excel.php",
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
        url: "views/zone/zone-data-person-area-B-excel.php",
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
        url: "views/zone/zone-data-person-area-C-excel.php",
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
        url: "views/zone/zone-data-person-area-D-excel.php",
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

}); //  click

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


function PrintDiv() {
    var divToPrint = document.getElementById('excel'); // เลือก div id ที่เราต้องการพิมพ์
    var html = '<html>' + // 
        '<head>' +
        '<link href="views/zone/print.css?v=1011" rel="stylesheet" type="text/css">' +
        '</head>' +
        '<body onload="window.print(); window.close();">' + divToPrint.innerHTML + '</body>' +
        '</html>';

    var popupWin = window.open();
    popupWin.document.open();
    popupWin.document.write(html); //โหลด print.css ให้ทำงานก่อนสั่งพิมพ์
    popupWin.document.close();
}
</script>