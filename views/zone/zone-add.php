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


if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;
	$stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX."area p 
    WHERE p.aid = '$aid'  LIMIT 1");
    $stmt_data->execute();	
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}

?>


<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">
        <!-- <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;"></div> -->
        <h3 class="card-title">
            <i class="far fa-user"></i>&nbsp;<?php echo $txt_title;?>เขตการเลือกตั้ง
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
                            <select class="form-control form-control-sm" name="changwat" id="changwat">
                                <?php
                        $stmt = $conn->prepare ("SELECT * FROM cchangwat c  WHERE c.changwatcode = '30' ");
                        $stmt->execute();
                      
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
                                value="<?php echo $row_person['area_number'];?>" />

                        </div>

                        <div class="col-lg-3">
                            <label>อำเภอ</label>
                            <select class="form-control form-control-sm" name="ampur" id="ampur">
                                <option value="">ระบุ</option>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label>ตำบล</label>
                            <select class=" form-control form-control-sm  " multiple name="tambon[]" id="tambon">
                                <option value="" id="tambon">ระบุ</option>
                            </select>


                        </div>


                    </div>

                    <div class="form-group row">

                        <div class="col-lg-2">
                            <label>หมู่ที่</label>
                            <input type="number" class="form-control form-control-sm" name="village" id="village"
                                placeholder="หมู่" value="<?php echo $row_person['village'];?>" />
                        </div>

                        <div class="col-lg-2">
                            <label>หน่วยการเลือกตั้ง</label>
                            <input type="number" class="form-control form-control-sm" name="zone_number"
                                id="zone_number" placeholder="เขตการเลือกตั้ง"
                                value="<?php echo $row_person['zone_number'];?>" />
                        </div>

                        <div class="col-lg-3">
                            <label>ชื่อสถานที่เลือกตั้ง</label>
                            <input type="text" class="form-control form-control-sm" name="zone_name" id="zone_name"
                                placeholder="ชื่อสถานที่" value="<?php echo $row_person['zone_name'];?>" />

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-3">
                            <label>latitude</label>
                            <input type="text" class="form-control form-control-sm" name="latitude" id="latitude"
                                placeholder="latitude" value="<?php echo $row_person['latitude'];?>" />

                            </input>

                        </div>

                        <div class="col-lg-3">
                            <label>longitude</label>
                            <input type="text" class="form-control form-control-sm" name="longitude" id="longitude"
                                placeholder="longitude" value="<?php echo $row_person['longitude'];?>" />

                        </div>
                    </div>
                    </br>
                    <div class=" row">
                        <div class="col-lg-12">
                            <label>รายละเอียด</label>
                            <textarea class="form-control editor" name="details"
                                id="details"><?php echo $row_person['details'];?></textarea>
                        </div>
                    </div>


                </div>
                <div class="row col-lg-12">
                    <h4>กรุณากด เลื่อนแผนที่ เพื่อขยับแผนที่ คลิกขวาเพื่อแสดงข้อมูล </h4>

                </div>
                <!-- <br> -->

            </div>
            <!--col-->

        </div>
        <!--col-->

        <div>
            <iframe
                src="https://map.longdo.com/snippet/iframe.php?locale=th&zoom=12&mode=political&map=epsg4326&lat=14.97269980670208&long=102.09930002689362&zoombar=auto&toolbar=no&mapselector=no&scalebar=no&centermark=no"
                style="border: none; width: 100%; height: 750px;"></iframe>
        </div>
        <!-- <br> -->
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary mr-2 btn-sm" id="btnSaveArea"><i class="fa fa-save"
                            title="บันทึก"></i> บันทึก</button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> </button>
                </div>
            </div>
        </div>
</div>
</form>
</div>

<!--end::Card-->

<!-- Datepicker Thai -->
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-datepicker-thai.js"></script>
<script src="assets/js/locales/bootstrap-datepicker.th.js"></script>

<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="css/bootstrap-multiselect.css" />




<!-- <script type="text/javascript">
$(document).ready(function() {
    $('#tambon').multiselect({
        includeSelectAllOption: true,
        selectAllValue: 'select-all-value'
    });
});
</script> -->

<script>
$(document).ready(function() {
    'use strict';
    getoptselect_amphur();
    getoptselect_tambon();

    $('#tambon').multiselect({
        nonSelectedText: 'Select Your Skills',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
    });

});

$(".add-more").click(function() {
    //alert(99);
    var html = $(".copy").html();
    $(".after-add-more").after(html);
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
                    // window.location.replace("dashboard.php?module=zone&page=main");
                    location.reload();
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
</script>