
<!--begin::Card-->
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
        $.ajax({ 
        url: "core/treeview/treeview.php",
        method:"POST",
        dataType: "json",       
        success: function(data)  
        {
            console.log(data);
            $('#treeview').treeview({
                data: data,
                collapseIcon:'fas fa-minus',
                expandIcon:'fas fa-plus'
            });
        }   
        });
        
    });


</script>