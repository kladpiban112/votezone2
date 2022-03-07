<?php

$service_date = filter_input(INPUT_GET, 'servicedate', FILTER_SANITIZE_STRING);
$service_date_ymd = date_saveto_db($service_date);
$service = filter_input(INPUT_GET, 'service', FILTER_SANITIZE_STRING);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

if ($search != '') {
    $search_data = " AND p.cid LIKE '%$search%' OR p.fname LIKE '%$search%'  ";
}
if ($service_date_ymd != '') {
    $service_date_data = " AND s.service_date = '$service_date_ymd'  ";
}
if ($service != '') {
    $service_type_data = " AND s.service_type = '$service'  ";
}
?>
<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-th-list"></i>&nbsp;รายการยืม-คืน
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="dashboard.php?module=tools&page=person-add"
                    class="btn btn-success btn-sm font-weight-bold mr-2" title="บันทึกยืม-คืน"><i
                        class="fa fa-plus-circle" title="บันทึกยืม-คืน" data-toggle="tooltip"></i>บันทึกยืม-คืน</a>
            </div>
        </div>
    </div>



    <div class="card-body">


        <form class="form" enctype="multipart/form-data" method="GET">
            <input type="hidden" class="form-control" name="act" value="search" />
            <input type="hidden" class="form-control" name="module" value="<?php echo $module; ?>" />
            <input type="hidden" class="form-control" name="page" value="tools-borrow" />

            <div class="form-group row">
                <div class="col-lg-2">
                    <label>วันที่รับบริการ</label>
                    <input type="text" class="form-control" name="servicedate" id="servicedate"
                        placeholder="วันที่รับบริการ" value="<?php echo $service_date; ?>" data-date-language="th-th"
                        maxlength="10" />
                    <span class="form-text text-muted"></span>

                </div>

                <div class="col-lg-2">
                    <label>รับบริการ</label>
                    <select class="form-control " name="service" id="service">
                        <option value="" <?php if ($service_type == '') {
    echo 'selected';
}?>>ทั้งหมด</option>
                        <option value="1" <?php if ($service_type == '1') {
    echo 'selected';
}?>>ยืมอุปกรณ์</option>
                        <option value="2" <?php if ($service_type == '2') {
    echo 'selected';
}?>>คืนอุปกรณ์</option>
                    </select>

                </div>

                <div class="col-lg-3">
                    <label>เลขบัตรประชาชน/ชื่อสกุล</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="เลขบัตรประชาชน/ชื่อสกุล" name="search"
                            id="search" value="<?php echo $search; ?>" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <?php

    if ($logged_user_role_id == '1') {
        $conditions = ' ';
    } else {
        $conditions = " AND s.org_id = '$logged_org_id' ";
    }

    $numb_data = $conn->query('SELECT count(1) FROM '.DB_PREFIX.'tools_borrow_main s  
    LEFT JOIN '.DB_PREFIX.'service_type t ON s.service_type = t.service_typeid
        LEFT JOIN '.DB_PREFIX."person_borrow p ON s.person_id = p.oid
    WHERE s.flag != '0' $conditions  $search_data $service_date_data $service_type_data")->fetchColumn();

        if (!(isset($pagenum))) {
            $pagenum = 1;
        }
        if ($numb_data == 0) {
            echo 'No Data';
        } else {
            $page_rows = 10;
            $last = ceil($numb_data / $page_rows);

            if ($pagenum < 1) {
                $pagenum = 1;
            } elseif ($pagenum > $last) {
                $pagenum = $last;
            }

            //สำหรับจัดการหน้า
            $numb_data = $numb_data;
            if ($numb_data <= $page_rows) {
                $Num_Pages = 1;
            } elseif (($numb_data % $page_rows) == 0) {
                $Num_Pages = ($numb_data / $page_rows);
            } else {
                $Num_Pages = ($numb_data / $page_rows) + 1;
                $Num_Pages = (int) $Num_Pages;
            }

            $max = ' LIMIT '.($pagenum - 1) * $page_rows.','.$page_rows;
            $stmt_data = $conn->prepare('SELECT p.*,s.*,o.org_name,o.org_shortname,pr.prename AS prename_title,t.service_title,a.grp_eq
        FROM '.DB_PREFIX.'tools_borrow_main s 
        LEFT JOIN '.DB_PREFIX.'service_type t ON s.service_type = t.service_typeid
        LEFT JOIN '.DB_PREFIX.'person_borrow p ON s.person_id = p.oid
        LEFT JOIN '.DB_PREFIX.'org_main o ON p.org_id = o.org_id
        LEFT JOIN '.DB_PREFIX."cprename pr ON p.prename = pr.id_prename
        LEFT JOIN (
            SELECT sd.service_id,GROUP_CONCAT('(',e.spare_code,')',e.spare_name,' ') AS grp_eq
            FROM ".DB_PREFIX.'tools_borrow_data sd
            LEFT JOIN '.DB_PREFIX."spare_main e ON sd.spare_id = e.spare_id
            WHERE sd.flag = '1' GROUP BY sd.service_id
        ) a ON s.service_id = a.service_id
        WHERE s.flag != '0' $conditions  $search_data $service_date_data $service_type_data
        ORDER BY s.service_id DESC
        $max");
            $stmt_data->execute(); ?>



        <div class="table-responsive">
            <table class="table table-bordered table-hover table-strip " id="tbData"
                style="margin-top: 13px !important; min-height: 300px;">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>ผู้รับบริการ</th>
                        <th>ชื่อรับบริการ</th>
                        <th>วันที่รับบริการ</th>
                        <th class="text-center">ประเภทรับบริการ</th>
                        <th>เครื่องมือ</th>
                        <th>หน่วยงาน</th>
                        <th>กำหนดคืน</th>
                        <!--<th class="text-center">สถานะ</th>-->
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

            $i = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
                ++$i;
                $oid = $row['oid'];
                $personid_enc = base64_encode($oid);
                $service_id = $row['service_id'];
                $serviceid_enc = base64_encode($service_id);
                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename.$fname.' '.$lname;
                $cid = $row['cid'];
                $org_name = $row['org_name'];
                $org_shortname = $row['org_shortname'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];

                $servicedate = date_db_2form($row['service_date']);
                $servicetype = $row['service_type'];
                $service_title = $row['service_title'];
                $grp_eqname = $row['grp_eq'];

                $returndate = date_db_2form($row['return_date']); ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-center">
                            <div class="symbol symbol-50 symbol-lg-60">
                                <?php if ($img_profile == '') {?>
                                <img src="uploads/no-image.jpg" alt="image" />
                                <?php } else {?>
                                <img src="uploads/person/<?php echo $img_profile; ?>" alt="image" />
                                <?php   } ?>
                            </div>
                        </td>
                        <td><?php echo $fullname; ?></br><small> เลขบัตร : <?php echo $cid; ?></small></td>
                        <td><?php echo $servicedate; ?></td>
                        <td><?php echo $service_title; ?></td>
                        <td><?php echo str_replace(',', '<br>', $grp_eqname); ?></td>
                        <td><?php echo $org_shortname; ?></td>
                        <td><?php echo $returndate; ?></td>

                        <!--<td class="text-center"><span class="label label-lg label-light-<?php echo $status_color; ?> label-inline"><?php echo $status_title; ?></span></td>-->
                        <td class="text-center">
                            <!--begin::Dropdown-->
                            <div class="dropdown">
                                <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                    <i class="ki ki-bold-more-hor font-size-md"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover py-1">

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=tools&page=tools-borrow-print&personid=<?php echo $personid_enc; ?>&serviceid=<?php echo $serviceid_enc; ?>&act=<?php echo base64_encode('view'); ?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">รายละเอียด</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=tools&page=person-add&personid=<?php echo $personid_enc; ?>&serviceid=<?php echo $serviceid_enc; ?>&act=<?php echo base64_encode('edit'); ?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลผู้รับบริการ</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=tools&page=tools-borrow-add&personid=<?php echo $personid_enc; ?>&serviceid=<?php echo $serviceid_enc; ?>&act=<?php echo base64_encode('edit'); ?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลการรับบริการ</span>
                                            </a>
                                        </li>

                                        <?php if ($servicetype == '1') {?>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=tools&page=person-add&personid=<?php echo $personid_enc; ?>&servicedate=<?php echo $serviceid_enc; ?>&servicetype=<?php echo base64_encode('2'); ?>&act="
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-file-import"></i></span>
                                                <span class="navi-text">คืนเครื่องมือ</span>
                                            </a>
                                        </li>
                                        <?php } ?>



                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link"
                                                onclick='confirm_borrow_delete(<?php echo $service_id; ?>)'>
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิกรายการ</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                            <!--end::Dropdown-->
                        </td>

                    </tr>

                    <?php
            } // end while
            ?>
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex flex-wrap py-2 mr-3">


                <?php
$p = 4;	//	กำหนดช่วงตัวเลขทางซ้าย และ ขวา ของหน้าที่ถูกเลือก
$Prev_Page = $pagenum - 1;
            $Next_Page = $pagenum + 1;
            $page_link = "dashboard.php?module=$module&page=main&search=$search&pagenum";

            if ($pagenum == 1) {		//	กรณีอยู่หน้า 1 หรือยังไม่เลือกหน้า
                echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
                for ($a = 1; $a <= $p; ++$a) {
                    if ($pagenum + $a < $Num_Pages) {
                        echo  "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum + $a)."' >".($pagenum + $a).'</a>';
                    }
                }
                if ($Num_Pages == 2) {
                    echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
        echo " <a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
                }
            } else {		// กรณีอยู่หน้าอื่นๆ
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Prev_Page' title='หน้าก่อนหน้า'><i class='ki ki-bold-arrow-back icon-xs'></i></a> ";		//	แสดงเครื่องหมาย <<
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=1'>1</a> ";		//	แสดงหมายเลข 1
            }

            if ($pagenum == 2) {	//	ถ้าอยู่หน้า 2
                echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
                for ($a = 1; $a <= $p; ++$a) {
                    if ($pagenum + $a < $Num_Pages) {
                        echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum + $a)."' >".($pagenum + $a).'</a>';
                    }
                }
            }

            if ($pagenum > 2 && $pagenum < $Num_Pages) {	//	ถ้าอยู่หน้ามากกว่า 2 แต่น้อยกว่าหน้าสุดท้าย
    for ($a = $p; $a >= 1; --$a) {		//	หา $p หน้าด้านซ้าย
        if ($pagenum - $a > 1) {	//	$p หน้าด้านซ้ายต้องมากกว่า 1
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum - $a)." '>".($pagenum - $a).'</a>';
        }
    }
                echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	หน้าปัจจุบัน
    for ($a = 1; $a <= $p; ++$a) {		//	หา $p หน้าด้านขวา
        if ($pagenum + $a < $Num_Pages) {		//	$p หน้าด้านขวาต้องน้อยกว่าหน้าสุดท้าย
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum + $a)."' >".($pagenum + $a).'</a>';
        }
    }
            }

            if ($pagenum == $Num_Pages && $Num_Pages != 1 && $Num_Pages != 2) {		//	ถ้าเลือกหน้าสุดท้าย
    for ($a = $p; $a >= 1; --$a) {		//	หา $p หน้าด้านซ้าย
        if ($pagenum - $a > 1) {
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum - $a)." '>".($pagenum - $a).'</a>';
        }
    }
                echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	แสดงหน้าปัจจุบัน
            } elseif ($Num_Pages != 1 && $Num_Pages != 2) {	//	กรณีไม่ได้เลือกหน้าสุดท้าย
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
    echo " <a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
            } ?>



            </div>

            <div class="d-flex align-items-center py-3">
                <span class="text-muted">หน้า <?php echo $pagenum; ?> / <?php echo $last; ?> </span>
            </div>
        </div>



        <?php
        } // end if
                    ?>

    </div>
    <div class="card-footer">
        <div class="row">

        </div>
    </div>


</div>
<!--end::Card-->



<script>
$('#servicedate').datepicker({
    autoclose: true
});


function confirm_borrow_delete(id) {
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
            $.post("core/tool/tools-borrow-main-del.php", {
                id: id
            }, function(result) {
                //  $("test").html(result);
                // console.log(result.code);
                location.reload();
            });
        }
    })
}
</script>