<?php
error_reporting(0);

$oid = filter_input(INPUT_GET, 'oid', FILTER_SANITIZE_STRING);

?>
<!--begin::Card-->
<input type="hidden" class="form-control"  name="oid" id="oid" value="<?php echo $oid;?>"/>

<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                สมาชิก
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
<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
                <button type="button" class="btn btn-warning btn-sm" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> </button>
			</div>
		</div>
</div>
</div>
</div>
		<!--end::Card-->
<script>

    $(document).ready(function(){

        var oid = $("#oid").val();
        $.ajax({ 
        url: "core/treeview/treeview.php",
        type:"POST",
        dataType: "json",
        data: {oid:oid},      
        success: function(data)  
        {
            var dataArray = [];
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    dataArray.push(data[key]);
                }
            };
            console.log(dataArray);
            $('#treeview').treeview({
                data: dataArray,
                collapseIcon:'fas fa-minus',
                expandIcon:'fas fa-plus'
            });
        }   
        });

    });

    
</script>