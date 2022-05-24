<?php
error_reporting(0);

$personid_enc = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid_enc = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$aid = filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_STRING);
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


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" value="<?php echo $action;?>"/>
<input type="hidden" class="form-control"  name="personid" id="personid" value="<?php echo $personid;?>"/>
<input type="hidden" class="form-control"  name="serviceid" id="serviceid" value="<?php echo $serviceid;?>"/>
<input type="hidden" class="form-control"  name="org_id" id="org_id" value="<?php echo $logged_org_id;?>"/>
<input type="hidden" class="form-control"  name="aid" id="aid" value="<?php echo $aid;?>"/>

	<div class="card-body">

	
	<div class="row">
	<div class="col-lg-12">

        <!-- <div class="form-group row">

		</div>

   <span><i class="fas fa-house-user"></i> ที่อยู่เขตเลือกตั้ง :</span>
   
   <hr> -->
		

        <input type="hidden" class="form-control"  name="txt_ampur" id="txt_ampur" value="<?php echo $row_person['ampur'];?>"/>

        <input type="hidden" class="form-control"  name="txt_tambon" id="txt_tambon" value="<?php echo $row_person['tambon'];?>"/>
    <div class="form-group row">

    <div class="col-lg-3">
				<label>จังหวัด</label>
            <select class="form-control form-control-sm" name="changwat" id="changwat">    
                        <?php
                                $stmt = $conn->prepare ("SELECT * FROM cchangwat c ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->changwatcode;
                                $name = $row->changwatname; ?>
                                <option value="<?php echo $id;?>" <?php if($row_person['changwat'] == $id){ echo "selected";}?>><?php echo $name;?></option>
                                <?php 
                                }
                            ?>
            </select>
			</div>

            <div class="col-lg-2">
				<label>เขตการเลือกตั้ง</label>
             <input type="number" class="form-control form-control-sm"  name="area_number" id="area_number" placeholder="เขตการเลือกตั้ง" value="<?php echo $row_person['area_number'];?>"/>
				
			</div>

      <div class="col-lg-3">
				<label>อำเภอ</label>
            <select class="form-control form-control-sm" name="ampur" id="ampur">
                        <option value="">ระบุ</option>
            </select>
			</div>

      <div class="col-lg-3">
				<label>ตำบล</label>
            <select class="form-control form-control-sm" name="tambon" id="tambon">
                        <option value="">ระบุ</option>
            </select>
			</div>
   </div>

            <div class="form-group row">

            <div class="col-lg-2">
				<label>หมู่ที่</label>
                <input type="number" class="form-control form-control-sm"  name="village" id="village" placeholder="หมู่" value="<?php echo $row_person['village'];?>"/>
			</div>
			 
			<div class="col-lg-2">
				<label>หน่วยการเลือกตั้ง</label>
                <input type="number" class="form-control form-control-sm"  name="zone_number" id="zone_number" placeholder="เขตการเลือกตั้ง" value="<?php echo $row_person['zone_number'];?>"/>
			</div>
				
			

            <div class="col-lg-3">
				<label>ชื่อสถานที่เลือกตั้ง</label>
             <input type="text" class="form-control form-control-sm"  name="zone_name" id="zone_name" placeholder="ชื่อสถานที่" value="<?php echo $row_person['zone_name'];?>"/>
				
			</div>

            
		</div>

      <div class="row">

      <div class="col-lg-3">
				<label>latitude</label>
             <input type="text" class="form-control form-control-sm"  name="latitude" id="latitude" placeholder="latitude" value="<?php echo $row_person['latitude'];?>"/>
                
            </input>
		
			</div>

            <div class="col-lg-3">
				<label>longitude</label>
             <input type="text" class="form-control form-control-sm"  name="longitude" id="longitude" placeholder="longitude" value="<?php echo $row_person['longitude'];?>"/>
				
			</div>
        </div> 
        </br>
            <div class=" row">
                <div class="col-lg-12">
                    <label>รายละเอียด</label>
                    <textarea class="form-control editor" name="details" id="details"><?php echo $row_person['details'];?></textarea>
                </div>
            </div>
        </div>    
  <div class="row col-lg-12">
               <h3>กรุณากด Shift + Scoll Mouse เพื่อ  Zoom Map </h3> 


            </div>
 <!-- <br> -->
     
		</div><!--col-->

		</div><!--col-->

<div id="map" style="width: 100%; height:650px;" >
</div>
<!-- <br> -->
<div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary mr-2 btn-sm" id="btnSaveArea"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> </button>
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
<!-- Load Leaflet from CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" crossorigin=""></script>
<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@^3.0.8/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-vector@^3.0.0/dist/esri-leaflet-vector.js"></script>
<!-- Load Esri Leaflet Geocoder from CDN -->
<script src="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.js"></script>


<script>


$(document).ready(function () {
    'use strict';
    getoptselect_amphur();
	getoptselect_tambon();

}); 

$(".add-more").click(function(){ 
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
    if($("#level").val() == 1 ){
        $("#head_h").hide();
    }else{
        $("#head_h").show();
    }
});


function getoptselect_amphur(){

    var changwatcode = $("#changwat").val();
    var ampur = $("#txt_ampur").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-ampur.php",
        //dataType: "json",
        data: {changwatcode:changwatcode,ampur:ampur},
        success: function(data) {
            $("#ampur").empty();
            $("#ampur").append(data);
        } // success
    });
}


function getoptselect_tambon(){

var changwatcode = $("#changwat").val();
var ampur = $("#txt_ampur").val();
var ampurcode = $("#ampur").val();
var tambon = $("#txt_tambon").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-tambon.php",
        //dataType: "json",
        data: {changwatcode:changwatcode,ampurcode:ampurcode,ampur:ampur,tambon:tambon},
        success: function(data) {
        
            $("#tambon").empty();
            $("#tambon").append(data);
        } // success
    });

}	


$('#btnSaveArea').click(function(e){
        e.preventDefault();
        if ($('#area_number').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุเขตเลือกตั้ง',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#changwat').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุจังหวัด',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#ampur').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุอำเภอ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#tambon').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุตำบล',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#village').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหมู่',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#zone_number').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุเลขหน่วยเลือกตั้ง',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#zone_name').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุชื่อหน่วยเลือกตั้ง',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {
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
                Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ',
                showConfirmButton: false,
                timer: 1500
                })
                .then((value) => {
                    window.location.replace("dashboard.php?module=zone&page=main");
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
            },error: function (jqXHR, exception) {
                console.log(jqXHR);
                // Your error handling logic here..
            } // success
        });
        }
      }); //  click

</script>
<script>
const apiKey = "AAPK2c46051a3469443eb9b301070f4e958a-Ckglf3c9zJNWi6O8g24f55AbJet4nBw3tZi-seb6K5VBtOyGgMzfS2gVKf4j65I";

const basemapEnum = "ArcGIS:Navigation";

const map = L.map("map", {
  minZoom: 2

}).setView([14.9674218,102.0682299], 13); // Paris

L.esri.Vector.vectorBasemapLayer(basemapEnum, {
  apiKey: apiKey
}).addTo(map);

const layerGroup = L.layerGroup().addTo(map);

map.on("click", function (e) {
  L.esri.Geocoding
    .reverseGeocode({
      apikey: apiKey
    })
    .latlng(e.latlng)
    .run(function (error, result) {
      if (error) {
        return;
      }

      const lngLatString = `${Math.round(result.latlng.lng * 100000) / 100000}, ${Math.round(result.latlng.lat * 100000) / 100000}`;

      layerGroup.clearLayers();
      marker = L.marker(result.latlng)
        .addTo(layerGroup)
        .bindPopup(`<b>${lngLatString}</b><p>${result.address.Match_addr}</p>`)
        .openPopup();
    });
});
</script>

