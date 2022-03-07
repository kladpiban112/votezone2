<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$spareid = base64_decode($id);
$action = base64_decode($act);
if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;

	$stmt_data = $conn->prepare ("SELECT u.*,o.org_name FROM ".DB_PREFIX."spare_main u 
	LEFT JOIN ".DB_PREFIX."org_main o ON u.org_id = o.org_id 
	WHERE u.spare_id = '$spareid' LIMIT 1");
	$stmt_data->execute();	
	$row_data = $stmt_data->fetch(PDO::FETCH_ASSOC);


}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}
?>

		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
				<i class="fas fa-cogs"></i>&nbsp;<?php echo $txt_title;?>อะไหล่ 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" value="<?php echo $action;?>"/>
<input type="hidden" class="form-control"  name="spare_id" id="spare_id" value="<?php echo $spareid;?>"/>
	<div class="card-body">
	<div class="row">
	<div class="col-lg-9">
		<div class="form-group row">
			<div class="col-lg-8">
				<label>ชื่ออะไหล่</label>
				<input type="text" class="form-control"  name="spare_name" id="spare_name" placeholder="" value="<?php echo $row_data['spare_name'];?>"/>
			</div>
			<div class="col-lg-4">
				<label>รหัสอะไหล่</label>
				<input type="text" class="form-control"  name="spare_code" id="spare_code" placeholder="" value="<?php echo $row_data['spare_code'];?>"/>
			</div>

			
			
		</div>

		<div class="form-group row">

			<div class="col-lg-4">
				<label>ประเภท</label>
				<select class="form-control " name="spare_type" id="spare_type">
                    
                    <option value="">ระบุ</option>
                    <?php
					
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cspare_type ");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['spare_typeid'];
						$title_selected = stripslashes($row['spare_title']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_data['spare_type'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
				
			</div>

      <div class="col-lg-2">
				<label>หน่วย(หลัก)</label>
				<select class="form-control " name="spare_unit_master" id="spare_unit_master">
                    
                    <option value="">ระบุ</option>
                    <?php
					
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cunit ");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['unit_id'];
						$title_selected = stripslashes($row['unit_title']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_data['spare_unit_master'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
				
			</div>

      <div class="col-lg-2">
				<label>หน่วย(รอง)</label>
				<select class="form-control " name="spare_unit_slave" id="spare_unit_slave">
                    
                    <option value="">ระบุ</option>
                    <?php
					
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cunit ");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['unit_id'];
						$title_selected = stripslashes($row['unit_title']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_data['spare_unit_slave'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
				
			</div>

      <div class="col-lg-4">
				<label>หน่วยแปลง(หลักไปรอง)</label>
				<input type="text" class="form-control"  name="spare_unit_cal" id="spare_unit_cal" placeholder="" value="<?php echo $row_data['spare_unit_cal'];?>"/>
			</div>
      </div>
  <div class="form-group row">
  <div class="col-lg-4">
				<label>คงเหลือ(หน่วยรอง)</label>
				<input type="text" class="form-control"  name="spare_stock" id="spare_stock" placeholder="" value="<?php echo $row_data['spare_stock'];?>"/>
			</div>
			<div class="col-lg-5">
				<label>หน่วยงาน</label>
				<select class="form-control " name="org_id" id="org_id">
                    <option value="">ระบุ</option>
                    <?php
					if($logged_user_role_id == '1'){
						$conditions = " ";
					}else{
						$conditions = " AND org_id = '$logged_org_id' ";
					}
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."org_main WHERE flag = 1  $conditions  ORDER BY org_id ASC");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['org_id'];
						$title_selected = stripslashes($row['org_shortname']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_data['org_id'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
			</div>
			
		</div>

		<div class="form-group row">
			<div class="col-lg-12">
				<label>รายละเอียด</label>
				<textarea rows="" class="form-control editor" name="spare_desc" id="spare_desc"><?php echo $row_data['spare_desc'];?></textarea>
			</div>
			
		</div>

		</div><!--col-->

		
		<div class="col-lg-3 border-x-0 border-x-md border-y border-y-md-0">

		        <div class="form-group row">
					<div class="col-lg-12">
					<div class="symbol symbol-50 symbol-lg-100 text-center">
					<?php if($row_data['spare_img'] == ""){?>
                    <img src="uploads/equipment/no-image.jpg" alt="image"/>
                            <?php }else{?>
                                <img src="uploads/spare/<?php echo $row_data['spare_img'];?>" alt="image"/>
                                <?php   } ?>
								</div>
					</div>
				</div>


				<div class="form-group row">
					<div class="col-lg-12">
						<label>รูปอะไหล่</label>
						<input type="file" class="form-control"  name="img_profile" id="img_profile" placeholder="รูปอะไหล่"/>
						<span class="form-text text-muted">.jpg .png เท่านั้น</span>
					</div>
				</div>

				
			
					<div class="form-group row">
					<div class="col-lg-12">
						<label>สถานะใช้งาน</label>
						<select class="form-control "  name="flag" id="flag">
							<option value="1" <?php if($row_data['flag'] == '1' ){echo "selected";} ?>>เปิดใช้งาน</option>
							<option value="0" <?php if($row_data['flag'] == '0' ){echo "selected";} ?>>ปิดใช้งาน</option>
						</select>
					</div>
				</div>
				</div>


		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mr-2" id="btnSaveUsers"><i class="fa fa-save" title="ย้อนกลับ" ></i> บันทึก</button>
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

$("#spare_unit_slave").change(function() {
    
  spare_unit_cal();
});

function spare_unit_cal(){

var slave = $("#spare_unit_slave").val();
var master = $("#spare_unit_master").val();

if(slave == master){
  $("#spare_unit_cal").val('1');
}

}


$('#btnSaveUsers').click(function(e){
        e.preventDefault();
        if ($('#spare_name').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุชื่อ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#spare_type').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุประเภท',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else  if ($('#spare_unit_master').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหน่วย(หลัก)',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#spare_unit_slave').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหน่วย(รอง)',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#spare_unit_cal').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหน่วยแปลง(หลักไปรอง)',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#org_id').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหน่วยงาน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {
		var fullname = $("#fullname").val();

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/spare/spare-add.php",
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
                    window.location.replace("dashboard.php?module=spare");
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

    $.extend(true, $.trumbowyg, {
        langs: {
            en: {
                table: 'Insert table',
                tableAddRow: 'Add row',
                tableAddColumn: 'Add column',
                tableDeleteRow: 'Delete row',
                tableDeleteColumn: 'Delete column',
                tableDestroy: 'Delete table',
                error: 'Error'
            }
            
        },

        plugins: {
            table: {
                init: function (t) {
                    t.o.plugins.table = $.extend(true, {}, defaultOptions, t.o.plugins.table || {});

                    var buildButtonDef = {
                        fn: function () {
                          t.saveRange();

                          var btnName = 'table';

                          var dropdownPrefix = t.o.prefix + 'dropdown',
                              dropdownOptions = { // the dropdown
                              class: dropdownPrefix + '-' + btnName + ' ' + dropdownPrefix + ' ' + t.o.prefix + 'fixed-top'
                          };
                          dropdownOptions['data-' + dropdownPrefix] = btnName;
                          var $dropdown = $('<div/>', dropdownOptions);

                          if (t.$box.find("." + dropdownPrefix + "-" + btnName).length === 0) {
                            t.$box.append($dropdown.hide());
                          } else {
                            $dropdown = t.$box.find("." + dropdownPrefix + "-" + btnName);
                          }

                          // clear dropdown
                          $dropdown.html('');

                          // when active table show AddRow / AddColumn
                          if (t.$box.find("." + t.o.prefix + "table-button").hasClass(t.o.prefix + 'active-button')) {
                            $dropdown.append(t.buildSubBtn('tableAddRow'));
                            $dropdown.append(t.buildSubBtn('tableAddColumn'));
                            $dropdown.append(t.buildSubBtn('tableDeleteRow'));
                            $dropdown.append(t.buildSubBtn('tableDeleteColumn'));
                            $dropdown.append(t.buildSubBtn('tableDestroy'));
                          } else {
                            var tableSelect = $('<table></table>');
                            for (var i = 0; i < t.o.plugins.table.rows; i += 1) {
                              var row = $('<tr></tr>').appendTo(tableSelect);
                              for (var j = 0; j < t.o.plugins.table.columns; j += 1) {
                                $('<td></td>').appendTo(row);
                              }
                            }
                            tableSelect.find('td').on('mouseover', tableAnimate);
                            tableSelect.find('td').on('mousedown', tableBuild);

                            $dropdown.append(tableSelect);
                            $dropdown.append($('<center>1x1</center>'));
                          }

                          t.dropdown(btnName);
                        }
                    };

                    var tableAnimate = function(column_event) {
                      var column = $(column_event.target),
                          table = column.parents('table'),
                          colIndex = this.cellIndex,
                          rowIndex = this.parentNode.rowIndex;

                      // reset all columns
                      table.find('td').removeClass('active');

                      for (var i = 0; i <= rowIndex; i += 1) {
                        for (var j = 0; j <= colIndex; j += 1) {
                          table.find("tr:nth-of-type("+(i+1)+")").find("td:nth-of-type("+(j+1)+")").addClass('active');
                        }
                      }

                      // set label
                      table.next('center').html((colIndex+1) + "x" + (rowIndex+1));
                    };

                    var tableBuild = function(column_event) {
                      t.saveRange();

                      var tabler = $('<table></table>');
                      if (t.o.plugins.table.styler) {
                        tabler.attr('class', t.o.plugins.table.styler);
                      }

                      var column = $(column_event.target),
                          colIndex = this.cellIndex,
                          rowIndex = this.parentNode.rowIndex;

                      for (var i = 0; i <= rowIndex; i += 1) {
                        var row = $('<tr></tr>').appendTo(tabler);
                        for (var j = 0; j <= colIndex; j += 1) {
                          $('<td></td>').appendTo(row);
                        }
                      }

                      t.range.deleteContents();
                      t.range.insertNode(tabler[0]);
                      t.$c.trigger('tbwchange');
                    };

                    var addRow = {
                      title: t.lang['tableAddRow'],
                      text: t.lang['tableAddRow'],
                      ico: 'row-below',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if(table.length > 0) {
                          var row = $('<tr></tr>');
                          // add columns according to current columns count
                          for (var i = 0; i < table.find('tr')[0].childElementCount; i += 1) {
                            $('<td></td>').appendTo(row);
                          }
                          // add row to table
                          row.appendTo(table);
                        }

                        return true;
                      }
                    };

                    var addColumn = {
                      title: t.lang['tableAddColumn'],
                      text: t.lang['tableAddColumn'],
                      ico: 'col-right',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if(table.length > 0) {
                          $(table).find('tr').each(function() {
                            $(this).find('td:last').after('<td></td>');
                          });
                        }

                        return true;
                      }
                    };

                    var destroy = {
                      title: t.lang['tableDestroy'],
                      text: t.lang['tableDestroy'],
                      ico: 'table-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table');

                        table.remove();

                        return true;
                      }
                    };

                    var deleteRow = {
                      title: t.lang['tableDeleteRow'],
                      text: t.lang['tableDeleteRow'],
                      ico: 'row-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            row = $(node).closest('tr');

                        row.remove();

                        return true;
                      }
                    };

                    var deleteColumn = {
                      title: t.lang['tableDeleteColumn'],
                      text: t.lang['tableDeleteColumn'],
                      ico: 'col-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table'),
                            td = $(node).closest('td'),
                            cellIndex = td.index();

                        $(table).find('tr').each(function() {
                          $(this).find('td:eq('+cellIndex+')').remove();
                        });

                        return true;
                      }
                    };

                    t.addBtnDef('table', buildButtonDef);
                    t.addBtnDef('tableAddRow', addRow);
                    t.addBtnDef('tableAddColumn', addColumn);
                    t.addBtnDef('tableDeleteRow', deleteRow);
                    t.addBtnDef('tableDeleteColumn', deleteColumn);
                    t.addBtnDef('tableDestroy', destroy);
                }
            }
        }
    });

</script>
