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
                           
	</div>


<div class="row">

		
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