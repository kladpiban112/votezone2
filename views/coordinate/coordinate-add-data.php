<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$serviceid = base64_decode($id);
$action = base64_decode($act);
if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;

	$stmt_data = $conn->prepare ("SELECT u.*,o.org_name,o.org_shortname,c.changwatname,a.ampurname,t.tambonname ,pr.prename,u.prename AS prename_id
  FROM ".DB_PREFIX."coordinate_main u 
  LEFT JOIN ".DB_PREFIX."cprename pr ON u.prename = pr.id_prename
  LEFT JOIN ".DB_PREFIX."org_main o ON u.org_id = o.org_id 
  LEFT JOIN ".DB_PREFIX."cchangwat c ON u.changwat = c.changwatcode
  LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(u.changwat,u.ampur) = a.ampurcodefull
  LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(u.changwat,u.ampur,u.tambon) = t.tamboncodefull
  WHERE u.flag = '1'  AND u.service_id = '$serviceid'  LIMIT 1 ");
	$stmt_data->execute();	
	$row_service = $stmt_data->fetch(PDO::FETCH_ASSOC);


}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}
?>

		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
				<i class="fas fa-podcast"></i>&nbsp;<?php echo $txt_title;?>ข้อมูลประสานงานขอความช่วยเหลือ 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>



	<div class="card-body">
	<div class="row">
	<div class="col-lg-5">

		<div class="form-group row">

    		<div class="col-lg-6" disabled>
				<label>วันที่รับเรื่อง</label>
				<input type="text" class="form-control"  name="servicedate" id="servicedate" placeholder="วันที่รับเรื่อง" value="<?php echo date_db_2form($row_service['service_date']);?>"  data-date-language="th-th" maxlength="10" disabled/>
				<span class="form-text text-muted"></span>
				
			</div>

      

			
		</div>

    <span><i class="fas fa-user"></i> ข้อมูลผู้ขอความช่วยเหลือ :</span>
<hr>

		<div class="form-group row">
      <div class="col-lg-2">
				<label>คำนำหน้า</label>
				<select class="form-control " name="prename" id="prename" disabled>
							<option value="">ระบุ</option>
							<?php
							$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cprename  ORDER BY id_prename ASC");
							$stmt_user_role->execute();		
							while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
								{
								$id_selected = $row['id_prename'];
								$title_selected = stripslashes($row['prename']);
								?>
								<option value="<?php echo $id_selected;?>" <?php if($row_service['prename_id'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
								<?php
								}
							?>
				</select>
					
			</div>
			<div class="col-lg-5">
				<label>ชื่อ</label>
				<input type="text" class="form-control"  name="fname" id="fname" placeholder="ชื่อ" value="<?php echo $row_service['fname'];?>" disabled/>
				
			</div>
			<div class="col-lg-5">
				<label>สกุล</label>
				<input type="text" class="form-control"  name="lname" id="lname" placeholder="สกุล" value="<?php echo $row_service['lname'];?>" disabled/>
				
			</div>

		
			
		</div>

			


	  		<span><i class="fas fa-podcast"></i> ข้อมูลขอความช่วยเหลือ :</span>
	  		<hr>
			<div class="form-group row">
					<div class="col-lg-12">
						<label>เรื่องที่ขอความช่วยเหลือ</label>
						<input type="text" class="form-control"  name="service_title" id="service_title" placeholder="เรื่องที่ขอความช่วยเหลือ" value="<?php echo $row_service['service_title'];?>" disabled/>
						
					</div>

			</div>

			<div class="form-group row">
			<div class="col-lg-12">
				<label>รายละเอียด</label>
				<?php echo $row_service['service_desc'];?>
			</div>
			
		</div>
		

		

		</div><!--col-->

    <div class="col-lg-7 border-x-0 border-x-md border-y border-y-md-0">

    <span><i class="fas fa-list"></i> ข้อมูลบันทึกให้ความช่วยเหลือ <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="far fa-plus-square"></i> เพิ่มข้อมูลให้การช่วยเหลือ</a></span>
	  		<hr>
        <div id="service_detail"></div> 
    </div><!--col-->



		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<!--<button type="button" class="btn btn-primary mr-2" id="btnSave"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>-->
				<button type="button" class="btn btn-secondary" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> ย้อนกลับ</button>
			</div>
			<div class="col-lg-6 text-right">
				<!--<button type="reset" class="btn btn-danger">Delete</button>-->
			</div>
		</div>
	</div>


</div>
		<!--end::Card-->



 <!--begin::Modal-->
 <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAdd" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-plus-square"></i> เพิ่มบันทึกให้ความช่วยเหลือ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       
                                    <form class="form" enctype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" class="form-control"  name="act" id="act" value="add"/>
                                        <input type="hidden" class="form-control"  name="serviceid" id="serviceid" value="<?php echo $serviceid;?>"/>
                                        <div class="form-group row">
                                              <div class="col-lg-12">
                                                <label>รายละเอียด</label>
                                                <textarea rows="" class="form-control editor" name="service_desc" id="service_desc"></textarea>
                                              </div>
                                        </div>
                                   
    
    
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-primary mr-2" id="btnAdddata"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>
                                        <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <!--end::Modal-->

<script>
		$(document).ready(function () {
			'use strict';
      loaddata_service_detail();
		}); 


		$('#servicedate').datepicker({
				autoclose: true
		});

    function loaddata_service_detail() {
            var serviceid = $("#serviceid").val();
                $.ajax({
                    type: "POST",
                    url: "views/coordinate/coordinate-detail.php",
                    //dataType: "json",
                    data: {serviceid:serviceid},
                    success: function(data) {
                        $("#service_detail").empty(); //add preload
                        $("#service_detail").append(data);

                    } // success
                });
}


function confirm_coordinate_data_delete(id) {
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
                            $.post("core/coordinate/coordinate-del-data.php", {id: id}, function(result){
                              loaddata_service_detail();
                            });
                        }
                    })
            }




$('#btnAdddata').click(function(e){
        e.preventDefault();
        if ($('#service_desc').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุรายละเอียด',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/coordinate/coordinate-add-data.php",
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
                    //window.location.replace("dashboard.php?module=equipment");
                    loaddata_service_detail();
                    $('#modalAdd').modal('hide');
                    $('#service_desc').val('');
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
						'btnGrp-justify',
						'btnGrp-lists',
						['horizontalRule'],
						['removeformat'],
						['fullscreen'],
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
