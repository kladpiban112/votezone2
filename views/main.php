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

.ward-label>.province {
    font-size: 12px;
}

.ward-label>.no {
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



                </div>
            </div>

            <?php
    
    $numb_A = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='1' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_B = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='2' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_C = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='3' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_D = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='4' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_N = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='5' ")->fetchColumn();//แจ้งซ่อมวันนี้



    
    ?>


            <!-- Text Column1 -->
            <div class="col-md-4  ">
                <a href="?act=search&module=person&page=main&slevel=1" >
                    <div class="row-sm-2 ">
                        <div class="card text-white">
                            <div class="card-header bg-success ">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="p-2 ">
                                        <h4>สมาชิกกลุ่ม A </h4>


                                    </div>
                                    <div class="p-2 ">
                                        <h4><?php echo  number_format($numb_A);?> คน </h4>


                                    </div>

                                </div>
                            </div>
                        </div>
                </a>
                <br>

                <!-- Text Column2 -->
                <div class="row-md-2  ">
                    <a href="?act=search&module=person&page=main&slevel=2">
                        <div class="card text-white">
                            <div class="card-header bg-warning">

                                <div class="d-flex justify-content-between mb-3">
                                    <div class="p-2 ">
                                        <h4>สมาชิกกลุ่ม B</h4>
                                    </div>
                                    <div class="p-2 ">
                                        <h4><?php echo  number_format($numb_B);?> คน </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ListItem2 -->

                    <br>

                    <!-- Text Column3 -->
                    <div class="row-md-2">
                        <a href="?act=search&module=person&page=main&slevel=3" >
                            <div class="card text-white">
                                <div class="card-header bg-primary">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="p-2 ">
                                            <h4>สมาชิกกลุ่ม C</h4>
                                        </div>
                                        <div class="p-2 ">
                                            <h4><?php echo  number_format($numb_C);?> คน </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- ListItem3 -->


                        <br />
                        <!-- Text Column2 -->
                        <div class="row-md-2  ">
                            <a href="?act=search&module=person&page=main&slevel=4" >
                                <div class="card text-white">
                                    <div class="card-header bg-info">

                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="p-2 ">
                                                <h4>สมาชิกกลุ่ม D</h4>
                                            </div>
                                            <div class="p-2 ">
                                                <h4><?php echo  number_format($numb_D);?> คน </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- ListItem2 -->

                        </div>
                        <br />
                        <!-- Text Column2 -->
                        <div class="row-md-2  ">
                            <a href="?act=search&module=person&page=main&slevel=5">
                                <div class="card text-white">
                                    <div class="card-header bg-info">

                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="p-2 ">
                                                <h4>สมาชิกกลุ่ม N</h4>
                                            </div>
                                            <div class="p-2 ">
                                                <h4><?php echo  number_format($numb_N);?> คน </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- ListItem2 -->

                        </div>
                        <!--end::Card-->

                        <script type="text/javascript"
                            src="https://api.longdo.com/map/?key=5e785cb06a872f9662a93d93ad733eed"></script>
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

                                        var marker1 = new longdo.Marker({
                                            lon: data[i].lon,
                                            lat: data[i].lat
                                        }, {
                                            title: 'Marker',
                                            icon: {
                                                html: `
                  <div  class="ward-label" >
                    <div class="no"> ${data[i].zone_name}</div>
                  </div>
                `
                                            },
                                            detail: 'Drag me',
                                            draggable: false,
                                            weight: longdo.OverlayWeight.Top,
                                        });

                                        map.Overlays.add(marker1);
                                    }




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