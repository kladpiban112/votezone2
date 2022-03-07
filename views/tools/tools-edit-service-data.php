<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_GET, 'repairid', FILTER_SANITIZE_STRING);
$spareid = filter_input(INPUT_GET, 'spareid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$repairid = base64_decode($repairid);
$spareid = base64_decode($spareid);
$action = base64_decode($act);
if ($action == 'edit') {
    $txt_title = 'แก้ไข';
    $action = $action;

    $conditions = " AND u.oid = '$spareid' ";
    $stmt_data = $conn->prepare('SELECT u.*,s.spare_name,s.spare_code,t.unit_title
FROM '.DB_PREFIX.'service_data u 
LEFT JOIN  '.DB_PREFIX.'spare_main s ON u.spare_id = s.spare_id
LEFT JOIN '.DB_PREFIX."cunit t ON u.spare_unit = t.unit_id
WHERE u.flag != '0' $conditions 
ORDER BY u.oid ASC
$max");
    $stmt_data->execute();
    $numb_rows = $stmt_data->rowCount();

    $row = $stmt_data->fetch(PDO::FETCH_ASSOC);
    $oid = $row['oid'];
    $oid_enc = base64_encode($oid);
    $spare_id = $row['spare_id'];
    $spare_code = $row['spare_code'];
    $spare_name = $row['spare_name'];
    $spare_quantity = $row['spare_quantity'];
    $unit_title = $row['unit_title'];
    $spare_price = $row['spare_price'];
    $spare_unit = $row['spare_unit'];
    $spare_desc = $row['spare_desc'];
} else {
    $txt_title = 'เพิ่ม';
    $action = 'add';
}
?>



<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">

        <h3 class="card-title">
            <i class="fas fa-edit"></i>&nbsp;<?php echo $txt_title; ?>เครื่องมือใช้งาน
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="#" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"
                    onclick="javascript:history.back()"><i class="fa fa-chevron-left" title="ย้อนกลับ"></i></a>
            </div>
        </div>
    </div>


    <form class="form" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action; ?>" />
        <input type="hidden" class="form-control" name="repairid" id="repairid" value="<?php echo $repairid; ?>" />
        <input type="hidden" class="form-control" name="personid" id="personid" value="<?php echo $personid; ?>" />
        <input type="hidden" class="form-control" name="spareid" id="spareid" value="<?php echo $spareid; ?>" />
        <input type="hidden" class="form-control" name="txt_spare_id" id="txt_spare_id" placeholder=""
            value="<?php echo $spare_id; ?>" />
        <input type="hidden" class="form-control" name="txt_spare_quantity" id="txt_spare_quantity" placeholder=""
            value="<?php echo $spare_quantity; ?>" />
        <input type="hidden" class="form-control" name="txt_spare_unit" id="txt_spare_unit" placeholder=""
            value="<?php echo $spare_unit; ?>" />
        <div class="card-body">


            <div class="row">
                <div class="col-lg-12">


                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>เครื่องมือ</label>
                            <select class="form-control " name="spare_id" id="spare_id">
                                <option value="">ระบุ</option>
                                <?php
                                                            if ($logged_user_role_id == '1') {
                                                                $conditions = ' ';
                                                            } else {
                                                                $conditions = " AND s.org_id = '$logged_org_id' ";
                                                            }
                                                            $stmt_user_role = $conn->prepare('SELECT s.* FROM '.DB_PREFIX."spare_main s 
                                                            
                                                            WHERE s.flag = 1  $conditions  ORDER BY s.spare_id ASC");
                                                            $stmt_user_role->execute();
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                                                                $id_selected = $row['spare_id'];
                                                                $title_selected = stripslashes($row['spare_name']); ?>
                                <option value="<?php echo $id_selected; ?>" <?php if ($id_selected = $spare_id) {
                                                                    echo 'selected';
                                                                } ?>><?php echo $title_selected; ?></option>
                                <?php
                                                            }
                                                            ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>จำนวน</label>
                            <input type="text" class="form-control" name="spare_quantity" id="spare_quantity"
                                placeholder="" value="<?php echo $spare_quantity; ?>" />
                        </div>

                        <div class="col-lg-2">
                            <label>หน่วย</label>

                            <select class="form-control " name="spare_unit" id="spare_unit">

                                <option value="">ระบุ</option>

                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label>ราคา(บาท)</label>
                            <input type="text" class="form-control" name="spare_price" id="spare_price" placeholder=""
                                value="<?php echo $spare_price; ?>" />
                        </div>



                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control" name="spare_desc"
                                id="spare_desc"><?php echo $spare_desc; ?></textarea>
                        </div>
                    </div>

                </div>
                <!--col-->





            </div>
            <!--col-->
        </div>
        <!--row-->



        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary mr-2" id="btnEditSpare"><i class="fa fa-save"
                            title="ย้อนกลับ"></i> บันทึก</button>
                    <button type="button" class="btn btn-secondary" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> ย้อนกลับ</button>
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
$(document).ready(function() {
    'use strict';
    loaddata_spare_unit();

});


function loaddata_spare_unit() {

    var spare_id = $("#spare_id").val();
    var spare_unit = $("#txt_spare_unit").val();
    //alert(spare_id);
    $.ajax({
        type: "POST",
        url: "core/spare/fn-spare-unit.php",
        data: {
            spare_id: spare_id,
            spare_unit: spare_unit
        },
        success: function(data) {
            $("#spare_unit").html(data);

        } // success
    });

}


$('#statusdate').datepicker({
    autoclose: true
});




$('#btnEditSpare').click(function(e) {
    e.preventDefault();
    if ($('#repairid').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาทำรายการ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุอะไหล่/อุปกรณ์',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_quantity').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุจำนวน',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#spare_unit').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุหน่วย',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/tool/tools-edit-service-data.php",
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
                            // $('#spare_id').val('');
                            // $('#spare_quantity').val('');
                            // $('#spare_unit').val('');
                            // $('#spare_price').val('0');
                            // $('#spare_desc').val('');
                            // loaddata_spare_data();

                            window.location.replace(
                                "dashboard.php?module=tools&page=tools-add-data&personid=" +
                                data.personid + "&repairid=" + data.repairid + "&act=" +
                                data.act);


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


$('#btnEditStatus').click(function(e) {
    e.preventDefault();
    if ($('#repairid').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาทำรายการ',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#statusdate').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุวันที่',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#status_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุสถานะ',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/repair/repair-edit-data-status.php",
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
                            //$('#status_id').val('');
                            //$('#statusdate').val('');
                            //$('#staff_id').val('');
                            //$('#status_desc').val('');
                            //loaddata_status_data();

                            window.location.replace(
                                "dashboard.php?module=repair&page=repair-add-data&personid=" +
                                data.personid + "&repairid=" + data.repairid + "&act=" +
                                data.act);

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
        ['foreColor', 'backColor'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
    ],

    plugins: {
        upload: {
            serverPath: '<?php echo ADMIN_URL; ?>/assets/plugins/trumbowyg/texteditor-upload.php',
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
            init: function(t) {
                t.o.plugins.table = $.extend(true, {}, defaultOptions, t.o.plugins.table || {});

                var buildButtonDef = {
                    fn: function() {
                        t.saveRange();

                        var btnName = 'table';

                        var dropdownPrefix = t.o.prefix + 'dropdown',
                            dropdownOptions = { // the dropdown
                                class: dropdownPrefix + '-' + btnName + ' ' + dropdownPrefix + ' ' +
                                    t.o.prefix + 'fixed-top'
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
                        if (t.$box.find("." + t.o.prefix + "table-button").hasClass(t.o.prefix +
                                'active-button')) {
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
                            table.find("tr:nth-of-type(" + (i + 1) + ")").find("td:nth-of-type(" + (j +
                                1) + ")").addClass('active');
                        }
                    }

                    // set label
                    table.next('center').html((colIndex + 1) + "x" + (rowIndex + 1));
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

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if (table.length > 0) {
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

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if (table.length > 0) {
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

                    fn: function() {
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

                    fn: function() {
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

                    fn: function() {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table'),
                            td = $(node).closest('td'),
                            cellIndex = td.index();

                        $(table).find('tr').each(function() {
                            $(this).find('td:eq(' + cellIndex + ')').remove();
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