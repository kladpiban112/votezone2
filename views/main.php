		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                DASHBOARD
				</h3>
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
        <div id="map" style="width: 100%; height:650px;"></div>
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

            var marker = L.marker([14.9674218,102.0682299])  
                .addTo(map)
                .bindPopup('<button id="marker-popover" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">Popover</button>');


        </script>

        </div>
   
   <!-- Text --> 
        <div class="col-md-4">
    
        <div class="row-md-4"> 
        <div class="card">
                <div class="card-body">
                    This is some text within a card body.
                </div>
            </div>
        </div>

   
        <div class="row-md-4"> 
       <div class="card">
            <div class="card-body">
                This is some text within a card body.
            </div>
        </div>
    </div>


</div>
    </div>
    <!--end::Body-->
 </div>
<!--end::Advance Table Widget 1-->
	</div>
	</div>				

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