
<!--begin::Card-->
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
    <div class="col-md-8" >
        <div id="map" style="width: 100%; height:750px;">
            <script type="text/javascript">

                var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    'attribution': 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
                    });

                var map = new L.Map('map', {
                    'center': [14.9674218,102.0682299],
                    'zoom': 12,
                    'layers': [tileLayer]
                    });

                map.on('popupopen', function(openEvent){
                        $(function () {
                        $('#marker-popover').popover();
                    });
                    });
            </script>
        </div>
    </div>
   
<!-- Text Column1 --> 
    <div class="col-md-4 ">
        <div class="row-md-2 "> 
            <div class="card text-white">
                   <div class="card-header bg-primary ">  <h4>สมาชิกในกลุ่ม B</h4>  </div>
                    
                    
            </div>
        </div>
    <!-- ListItem1 -->
        <div class="= ex3 " id="style-1" >
     
            <ul >
                <li class="w3-bar border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>    
                
                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>    
                

                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>   
                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>
                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>
            </ul>        
        </div>

      <br>

    
<!-- Text Column2 --> 
    <div class="row-md-2  "> 
        <div class="card text-white">
            <div class="card-header bg-warning" >
                <h4>สมาชิกในกลุ่ม C </h4>
            </div>
        </div>
      <!-- ListItem2 -->
        <div class="ex3 "  id="style-1">
            <ul>
                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>    
                
                <li class="w3-bar  border-bottom ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>    
                

                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>   
                <li class="w3-bar  border-bottom  ">
                    <img src="uploads/avatars/36b4e770-images.png" class="w3-bar-item w3-circle" style="width:85px">
                    <div class="w3-bar-item">
                        <span class="w3-large">Mike</span><br>
                        <span>Web Designer</span>
                    </div>
                </li>
            </ul>        
            
        </div>
    </div>

<!--end::Body-->
    </div>
    </div>

    <!--end::Advance Table Widget 1-->			

</div>
</div>
		<!--end::Card-->

<script>

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
                                $.post("core/repair/repair-del.php", {id: id}, function(result){
                                    //  $("test").html(result);
                                    // console.log(result.code);
                                    location.reload();
                                });
                            }
                        })
                }

</script>