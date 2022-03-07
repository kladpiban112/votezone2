
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="fas fa-cogs"></i>&nbsp;ตั้งค่าระบบ 
				</h3>
				<div class="card-toolbar">
					
				</div>
			</div>



	<div class="card-body">
	<form class="form" enctype="multipart/form-data" >
   <input type="hidden" class="form-control"  name="act" id="act" value="edit"/>
	<div class="form-group">
					<label>Site Title</label>
					<input class="form-control" name="cfg_site_title" id="cfg_site_title"  type="text" value="<?php echo $cfg_site_title;?>">
					</div>

					<div class="row">
						<div class="form-group col-md-6">
						<label>Application name</label>
						<input type="text" class="form-control" name="cfg_app_name" id="cfg_app_name" value="<?php echo $cfg_app_name;?>">    
						</div>

						<div class="form-group col-md-6">
						<label>Application nickname</label>
						<input type="text" class="form-control" name="cfg_app_nickname" id="cfg_app_nickname" value="<?php echo $cfg_app_nickname;?>">    
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-md-6">
						<label>SEO meta title</label>
						<input type="text" class="form-control" name="cfg_site_meta_title" name="cfg_site_meta_title" value="<?php echo $cfg_site_meta_title;?>">    
						</div>

						<div class="form-group col-md-6">
						<label>SEO meta description</label>
						<input type="text" class="form-control" name="cfg_site_meta_description" id="cfg_site_meta_description" value="<?php echo $cfg_site_meta_description;?>">    
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-md-6">
						<label>SEO meta keywords</label>
						<input type="text" class="form-control" name="cfg_site_meta_keywords" id="cfg_site_meta_keywords" value="<?php echo $cfg_site_meta_keywords;?>">    
						</div>
					
						<div class="form-group col-md-6">
						<label>SEO meta author</label>
						<input type="text" class="form-control" name="cfg_site_meta_author" id="cfg_site_meta_author" value="<?php echo $cfg_site_meta_author;?>">    
						</div>
					</div>
					
					<div class="form-group">
					<label>Homepage content</label>
					<textarea rows="3" class="form-control editor" name="cfg_homepage_content" id="cfg_homepage_content"><?php echo $cfg_homepage_content;?></textarea>
					</div>
					
					<div class="form-group">
					<label>Footer HTML content</label>
					<textarea rows="3" class="form-control editor" name="cfg_footer_content"  id="cfg_footer_content"><?php echo $cfg_footer_content;?></textarea>
					</div>
					
					<div class="form-row">
					<div class="form-group col-md-6">
							<label>Line Notify KEY</label>
							<input type="text" class="form-control" name="cfg_line_notify_key"  id="cfg_line_notify_key" value="<?php echo $cfg_line_notify_key;?>">
						</div>
						</div>
					<div class="form-group">
					<label>Change logo image</label><br />
					<input type="file" name="image">
					</div>
				

		
	</div>
	<div class="card-footer">
		
		<div class="row">
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mr-2" id="btnSave"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>
				<button type="button" class="btn btn-secondary" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> ย้อนกลับ</button>
			</div>
			<div class="col-lg-6 text-right">
				<!--<button type="reset" class="btn btn-danger">Delete</button>-->
			</div>
		</div>
	
	</div>

</form>
</div>
		<!--end::Card-->




		                             
		<script>
$('#btnSave').click(function(e){
        e.preventDefault();
        if ($('#cfg_site_title').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุชื่อระบบ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else{
		//var fullname = $("#fullname").val();

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/systems/system-add.php",
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
                    //liff.closeWindow();
                    //window.location.replace("dashboard.php?module=systems");
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
            } // success
        });

        }
    
	  }); //  click
	  


	  $('.editor').trumbowyg({
				removeformatPasted: true,
				lang: 'th',
				autogrow: true,
				btnsDef: {
					// Create a new dropdown
					image: {
						dropdown: ['insertImage', 'noembed'],
						ico: 'insertImage'
					}
				}, 

					
				btns: [
						['viewHTML'],
						['undo', 'redo'],
						['formatting'],
						'btnGrp-semantic',
						['link'],
						['table'],
						['image'],
						'btnGrp-justify',
						'btnGrp-lists',
						['horizontalRule'],
						['removeformat'],
						['fullscreen'],
						['noembed'],
						['foreColor', 'backColor'],
						['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
					],
							
				plugins: {
						upload: {
							serverPath: '<?php echo ADMIN_URL;?>/assets/plugins/trumbowyg/texteditor-upload.php',
							fileFieldName: 'image'
							}
						},
						table: {
            // Some table plugin options, see details below
        }				
							
			});	


			var defaultOptions = {
        rows: 8,
        columns: 8,
        styler: 'table'
    };


</script>



