<?php
error_reporting(0);
session_start();
$oid = filter_input(INPUT_GET, 'oid', FILTER_SANITIZE_STRING);

?>
<!--begin::Card-->
<input type="hidden" class="form-control"  name="oid" id="oid" value="<?php echo $oid;?>"/>

<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                TREEVIEW
				<div class="card-toolbar">
				</div>
			</div>

	<div class="card-body">


 <div class="row">
     
    <div class="col-lg-12"  id="treeview"></div>

<!--end::Body-->
    </div>
    </div>
<!--end::Advance Table Widget 1-->			

</div>
</div>
		<!--end::Card-->
<script>

    $(document).ready(function(){

        var oid_page = $("#oid").val();
        $.ajax({ 
        url: "core/treeview/treeview.php",
        method:"POST",
        dataType: "json",
        data: {oid:oid_page},      
        success: function(data)  
        {
            var dataArray = [];
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    dataArray.push(data[key]);
                }
            };
            console.log(dataArray);
            // $('#treeview').treeview({
            //     data: dataArray,
            //     collapseIcon:'fas fa-minus',
            //     expandIcon:'fas fa-plus'
            // });
        }   
        });
        
    });


</script>