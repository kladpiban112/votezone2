<!--begin::Card-->
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
      .ward-label > .province {
        font-size: 12px;
      }
      .ward-label > .no {
        font-size: 14px;
      }
</style>

<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            DASHBOARD


            <div class="card-toolbar">
                <!--<div class="example-tools justify-content-center">
						<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
						<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
					</div>-->
            </div>
    </div>

    <div class="card-body">

        <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>




        <div class="row">
            <!-- Map -->
            <div class="col-md-8">


                <div id="map" style="width: 100%; height:750px;">


                    <script>




                    </script>
                </div>
            </div>


            <!-- Text Column1 -->
            <div class="col-md-4  ">
                <a href="#demo" data-bs-toggle="collapse">
                    <div class="row-sm-2 ">
                        <div class="card text-white">
                            <div class="card-header bg-success ">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="p-2 ">
                                        <h4>สมาชิกกลุ่ม A</h4>
                                    </div>
                                    <div class="p-2 "> <i class='fas fa-angle-double-down text-white'
                                            style='font-size:35px;'> </i> </div>
                                </div>
                            </div>
                        </div>
                </a>

                <!-- ListItem1 -->
                <div class=" ex3 collapse " id="demo">


                    <?php


    $stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
    FROM ".DB_PREFIX."person_main p 
    LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
    LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
    LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
    LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
    LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex WHERE p.level =1
    ORDER BY p.oid DESC
");
    $stmt_data->execute();		

    
?>

                    <?php

        $i  = 0;
        $no = 1;
        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
        {
            $i++;
            $no++;
            $oid = $row['oid'];
            $personid = $oid;
            $personid_enc = base64_encode($oid);
            $prename = $row['prename_title'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $fullname = $prename.$fname." ".$lname;
            $cid = $row['cid'];
            $telephone = $row['telephone'];
            $img_profile = $row['img_profile'];
            $today = date("Y-m-d");
            $level = $row['level'];
            
            $house = $row['house'];
            $village = $row['village'];
                $changwatname = $row['changwatname'];
                $ampurname = $row['ampurname'];
                $tambonname = $row['tambonname'];
                $addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
            ?>

                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <ul>
                                        <li class="w3-bar border-bottom  ">
                                            <div class="row-xs-2">
                                                <?php if($img_profile == ""){?>
                                                <a href="uploads/no-image.jpg" class="example-image-link"
                                                    data-lightbox="example-set" data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/no-image.jpg" alt="image" />
                                                    </div>
                                                </a>
                                                <?php }else{?>
                                                <a href="uploads/person/<?php echo $img_profile;?>"
                                                    class="example-image-link" data-lightbox="example-set"
                                                    data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/person/<?php echo $img_profile;?>" width="200"
                                                            height="300" alt="image" />
                                                    </div>
                                                </a>
                                                <?php } ?>

                                            </div>
                                </td>
                                <td>
                                    <div class="row-sx-2">
                                        <div class="w3-bar-item"></br>
                                            <span class="w3-large"><?php echo $fullname;?></span><br>
                                            <span><?php echo $telephone;?></span><br>
                                            <span><?php echo $addr;?></span>
                                        </div>
                                    </div>
                                    </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                </div>
                </tbody>
                </table>
            </div>
            <br>

            <!-- Text Column2 -->
            <div class="row-md-2  ">
                <a href="#demo2" data-bs-toggle="collapse">
                    <div class="card text-white">
                        <div class="card-header bg-warning">

                            <div class="d-flex justify-content-between mb-3">
                                <div class="p-2 ">
                                    <h4>สมาชิกกลุ่ม B</h4>
                                </div>
                                <div class="p-2 "> <i class='fas fa-angle-double-down text-white'
                                        style='font-size:35px;'> </i> </div>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ListItem2 -->
                <div class=" ex3 collapse " id="demo2">

                    <?php


$stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
FROM ".DB_PREFIX."person_main p 
LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex WHERE p.level =2
ORDER BY p.oid DESC
");
$stmt_data->execute();		


?>

                    <?php

    $i  = 0;
    $no = 1;
    while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
    {
        $i++;
        $no++;
        $oid = $row['oid'];
        $personid = $oid;
        $personid_enc = base64_encode($oid);
        $prename = $row['prename_title'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $fullname = $prename.$fname." ".$lname;
        $cid = $row['cid'];
        $telephone = $row['telephone'];
        $img_profile = $row['img_profile'];
        $today = date("Y-m-d");
        $level = $row['level'];
        
        $house = $row['house'];
        $village = $row['village'];
            $changwatname = $row['changwatname'];
            $ampurname = $row['ampurname'];
            $tambonname = $row['tambonname'];
            $addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
        ?>

                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <ul>
                                        <li class="w3-bar border-bottom  ">
                                            <div class="row-xs-2"><?php if($img_profile == ""){?>
                                                <a href="uploads/no-image.jpg" class="example-image-link"
                                                    data-lightbox="example-set" data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/no-image.jpg" alt="image" />
                                                    </div>
                                                </a>
                                                <?php }else{?>
                                                <a href="uploads/person/<?php echo $img_profile;?>"
                                                    class="example-image-link" data-lightbox="example-set"
                                                    data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/person/<?php echo $img_profile;?>"
                                                            alt="image" />
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                </td>
                                <td>
                                    <div class="row-sx-2">
                                        <div class="w3-bar-item"></br>
                                            <span class="w3-large"><?php echo $fullname;?></span><br>
                                            <span><?php echo $telephone;?></span><br>
                                            <span><?php echo $addr;?></span>
                                        </div>
                                    </div>
                                    </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                </div>
                </tbody>
                </table>

            </div>
            <br>

            <!-- Text Column3 -->
            <div class="row-md-2">
                <a href="#demo3" data-bs-toggle="collapse">
                    <div class="card text-white">
                        <div class="card-header bg-primary">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="p-2 ">
                                    <h4>สมาชิกกลุ่ม C</h4>
                                </div>
                                <div class="p-2 "> <i class='fas fa-angle-double-down text-white'
                                        style='font-size:35px;'> </i> </div>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ListItem3 -->
                <div class=" ex3 collapse " id="demo3">


                    <?php


$stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
FROM ".DB_PREFIX."person_main p 
LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex WHERE p.level =3
ORDER BY p.oid DESC
");
$stmt_data->execute();		


?>

                    <?php

    $i  = 0;
    $no = 1;
    while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
    {
        $i++;
        $no++;
        $oid = $row['oid'];
        $personid = $oid;
        $personid_enc = base64_encode($oid);
        $prename = $row['prename_title'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $fullname = $prename.$fname." ".$lname;
        $cid = $row['cid'];
        $telephone = $row['telephone'];
        $img_profile = $row['img_profile'];
        $today = date("Y-m-d");
        $level = $row['level'];
        
        $house = $row['house'];
        $village = $row['village'];
            $changwatname = $row['changwatname'];
            $ampurname = $row['ampurname'];
            $tambonname = $row['tambonname'];
            $addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
        ?>
                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <ul>
                                        <li class="w3-bar border-bottom  ">
                                            <div class="row-xs-2"><?php if($img_profile == ""){?>
                                                <a href="uploads/no-image.jpg" class="example-image-link"
                                                    data-lightbox="example-set" data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/no-image.jpg" alt="image" />
                                                    </div>
                                                </a>
                                                <?php }else{?>
                                                <a href="uploads/person/<?php echo $img_profile;?>"
                                                    class="example-image-link" data-lightbox="example-set"
                                                    data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/person/<?php echo $img_profile;?>"
                                                            alt="image" />
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                </td>
                                <td>
                                    <div class="row-sx-2">
                                        <div class="w3-bar-item"></br>
                                            <span class="w3-large"><?php echo $fullname;?></span><br>
                                            <span><?php echo $telephone;?></span><br>
                                            <span><?php echo $addr;?></span>
                                        </div>
                                    </div>
                                    </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                </div>
                </tbody>
                </table>
            </div>
            <br />
            <!-- Text Column2 -->
            <div class="row-md-2  ">
                <a href="#demo4" data-bs-toggle="collapse">
                    <div class="card text-white">
                        <div class="card-header bg-info">

                            <div class="d-flex justify-content-between mb-3">
                                <div class="p-2 ">
                                    <h4>สมาชิกกลุ่ม D</h4>
                                </div>
                                <div class="p-2 "> <i class='fas fa-angle-double-down text-white'
                                        style='font-size:35px;'> </i> </div>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ListItem2 -->
                <div class=" ex3 collapse " id="demo4">

                    <?php


$stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
FROM ".DB_PREFIX."person_main p 
LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex WHERE p.level = 4
ORDER BY p.oid DESC
");
$stmt_data->execute();		


?>

                    <?php

    $i  = 0;
    $no = 1;
    while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
    {
        $i++;
        $no++;
        $oid = $row['oid'];
        $personid = $oid;
        $personid_enc = base64_encode($oid);
        $prename = $row['prename_title'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $fullname = $prename.$fname." ".$lname;
        $cid = $row['cid'];
        $telephone = $row['telephone'];
        $img_profile = $row['img_profile'];
        $today = date("Y-m-d");
        $level = $row['level'];
        
        $house = $row['house'];
        $village = $row['village'];
            $changwatname = $row['changwatname'];
            $ampurname = $row['ampurname'];
            $tambonname = $row['tambonname'];
            $addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
        ?>

                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <ul>
                                        <li class="w3-bar border-bottom  ">
                                            <div class="row-xs-2"><?php if($img_profile == ""){?>
                                                <a href="uploads/no-image.jpg" class="example-image-link"
                                                    data-lightbox="example-set" data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/no-image.jpg" alt="image" />
                                                    </div>
                                                </a>
                                                <?php }else{?>
                                                <a href="uploads/person/<?php echo $img_profile;?>"
                                                    class="example-image-link" data-lightbox="example-set"
                                                    data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/person/<?php echo $img_profile;?>"
                                                            alt="image" />
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                </td>
                                <td>
                                    <div class="row-sx-2">
                                        <div class="w3-bar-item"></br>
                                            <span class="w3-large"><?php echo $fullname;?></span><br>
                                            <span><?php echo $telephone;?></span><br>
                                            <span><?php echo $addr;?></span>
                                        </div>
                                    </div>
                                    </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                </div>
                </tbody>
                </table>

            </div>
            <br>

            <!-- Text Column3 -->
            <div class="row-md-2">
                <a href="#demo5" data-bs-toggle="collapse">
                    <div class="card text-white">
                        <div class="card-header bg-primary">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="p-2 ">
                                    <h4>สมาชิกกลุ่ม N</h4>
                                </div>
                                <div class="p-2 "> <i class='fas fa-angle-double-down text-white'
                                        style='font-size:35px;'> </i> </div>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ListItem3 -->
                <div class=" ex3 collapse " id="demo5">


                    <?php


$stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
FROM ".DB_PREFIX."person_main p 
LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex WHERE p.level =5
ORDER BY p.oid DESC
");
$stmt_data->execute();		


?>

                    <?php

    $i  = 0;
    $no = 1;
    while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
    {
        $i++;
        $no++;
        $oid = $row['oid'];
        $personid = $oid;
        $personid_enc = base64_encode($oid);
        $prename = $row['prename_title'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $fullname = $prename.$fname." ".$lname;
        $cid = $row['cid'];
        $telephone = $row['telephone'];
        $img_profile = $row['img_profile'];
        $today = date("Y-m-d");
        $level = $row['level'];
        
        $house = $row['house'];
        $village = $row['village'];
            $changwatname = $row['changwatname'];
            $ampurname = $row['ampurname'];
            $tambonname = $row['tambonname'];
            $addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
        ?>
                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <ul>
                                        <li class="w3-bar border-bottom  ">
                                            <div class="row-xs-2"><?php if($img_profile == ""){?>
                                                <a href="uploads/no-image.jpg" class="example-image-link"
                                                    data-lightbox="example-set" data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/no-image.jpg" alt="image" />
                                                    </div>
                                                </a>
                                                <?php }else{?>
                                                <a href="uploads/person/<?php echo $img_profile;?>"
                                                    class="example-image-link" data-lightbox="example-set"
                                                    data-title="">
                                                    <div class="symbol symbol-50 symbol-lg-60">
                                                        <img src="uploads/person/<?php echo $img_profile;?>"
                                                            alt="image" />
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                </td>
                                <td>
                                    <div class="row-sx-2">
                                        <div class="w3-bar-item"></br>
                                            <span class="w3-large"><?php echo $fullname;?></span><br>
                                            <span><?php echo $telephone;?></span><br>
                                            <span><?php echo $addr;?></span>
                                        </div>
                                    </div>
                                    </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                </div>
                </tbody>
                </table>
            </div>

        </div>

        <!--end::Body-->
    </div>
</div>

<!--end::Advance Table Widget 1-->

</div>
</div>
<!--end::Card-->

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

    $.ajax({
        type: "POST",
        url: "core/treeview/treeview_test.php",
        //dataType: "json",
        data: {},
        success: function(data) {

            var data = JSON.parse(data);
            console.log(data);
            for (var i = 0; i < data.length; i++) {

                var object4 = new longdo.Overlays.Object(data[i].zone_code, 'IG', {
                    combine: true,
                    simplify: 0.00005,
                    ignorefragment: false,
                    lineColor: '#888',
                    lineStyle: longdo.LineStyle.Dashed,
                    fillColor: data[i].area_color,

                });
                map.Overlays.load(object4);

                var marker1 = new longdo.Marker({ lon:data[i].lon , lat:data[i].lat  },
{
  title: 'Marker',
  icon: {
      html: `
                  <div  class="ward-label" >
                    <div class="no"> ${data[i].zone_name}</div>
                  </div>
                `,
    offset: { x: 12, y: 45 }
  },
  detail: 'Drag me',
  draggable: false,
  weight: longdo.OverlayWeight.Top,
});

map.Overlays.add(marker1);
            }




        } //success 

    });





    map.zoom(11, true);
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
    init();
    // $.ajax({
    //     type: "POST",
    //     url: "core/treeview/treeview_test.php",
    //     //dataType: "json",
    //     data: {},
    //     success: function(data) {

    //         var data = JSON.parse(data);
    //         console.log(data);
    //         for (var i = 0; i < data.length; i++) {

    //             var marker = L.marker([data[i].lat, data[i].lon]).addTo(map)

    //             for (var j = 0; j < data[i].person.length; j++) {

    //                 {

    //                     marker.bindPopup(
    //                         '<div class="container-fluid"  ><span class="w2-md p-2">เขตการเลือกตั้งที่ : ' +
    //                         data[i].zone_number + '</span><br><span> หน่วยเลือกตั้งที่ : ' +
    //                         data[i].area_number + '</span><br><span>ชื่อสถานที่ : ' +
    //                         data[i].zone_name + '</span></div><p></p>จำนวน : ' + data[i].person
    //                         .length + ' คน</div>'

    //                     );
    //                 }
    //             }
    //             marker.openPopup();

    //         }


    //     } //success 

    // });



});

function delRepairMain(id) {
    Swal.fire({
        title: 'แน่ใจนะ?',
        text: "ต้องการยกเลิกรายการ",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ใช่, ต้องการยกเลิกรายการ !'
    }).then((result) => {
        if (result.value) { //Yes
            $.post("core/repair/repair-del.php", {
                id: id
            }, function(result) {
                //  $("test").html(result);
                // console.log(result.code);
                location.reload();
            });
        }
    })
}
</script>