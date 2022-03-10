<?php
error_reporting(0);
$receive_date_get = filter_input(INPUT_GET, 'receivedate', FILTER_SANITIZE_STRING);
$receivedate = date_saveto_db($receive_date_get);
$storesid = filter_input(INPUT_GET, 'storesid', FILTER_SANITIZE_STRING);

?>
<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-basket"></i>&nbsp;รายการรับเข้าคลังอะไหล่
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="dashboard.php?module=spare&page=spare-receive"
                    class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มข้อมูล"><i
                        class="fa fa-plus-circle" title="เพิ่มข้อมูล" data-toggle="tooltip"></i>เพิ่มข้อมูล</a>
            </div>
        </div>
    </div>



    <div class="card-body">

        <!--begin::Search Form-->
        <form class="form" enctype="multipart/form-data" method="GET">
            <input type="hidden" class="form-control" placeholder="" name="module" id="module"
                value="<?php echo $module; ?>" />
            <input type="hidden" class="form-control" placeholder="" name="page" id="page"
                value="<?php echo $page; ?>" />
            <input type="hidden" class="form-control" placeholder="" name="pagenum" id="pagenum"
                value="<?php echo $pagenum; ?>" />
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-xl-6">
                        <div class="row align-items-center">
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="" name="receivedate"
                                        id="receivedate" data-date-language="th-th" maxlength="10"
                                        value="<?php echo $receive_date_get; ?>" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>

                            <div class="col-md-8 my-4 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">ร้าน</label>


                                    <select class="form-control" name="storesid" id="storesid">

                                        <option value="">ทั้งหมด</option>
                                        <?php
                                    if ($logged_user_role_id == '1') {
                                        $conditions = ' ';
                                    } else {
                                        $conditions = " AND s.org_id = '$logged_org_id' ";
                                    }
                                    $stmt_user_role = $conn->prepare('SELECT s.* FROM '.DB_PREFIX."stores_main s WHERE s.flag = '1' $conditions ");
                                    $stmt_user_role->execute();
                                    while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC)) {
                                        $id_selected = $row['stores_id'];
                                        $title_selected = stripslashes($row['stores_name']); ?>
                                        <option value="<?php echo $id_selected; ?>" <?php if ($storesid == $id_selected) {
                                            echo 'selected';
                                        } ?>><?php echo $title_selected; ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">

                        <button type="submit" class="btn btn-light-primary px-6 "><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Search Form-->



        <?php

       if ($logged_user_role_id == '1') {
           $conditions = ' ';
       } else {
           $conditions = " AND u.org_id = '$logged_org_id' ";
       }
       if ($receivedate != '') {
           $receivedate_search = " AND u.receive_date = '$receivedate' ";
       }
       if ($storesid != '') {
           $storesid_search = " AND u.stores_id = '$storesid' ";
       }
    $sql = 'SELECT count(1) FROM '.DB_PREFIX."spare_receive u  WHERE u.flag = '1'  $conditions $receivedate_search $storesid_search";
    $numb_data = $conn->query($sql)->fetchColumn();

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

            $stmt_data = $conn->prepare('SELECT u.*,o.org_name,o.org_shortname,s.stores_name
        FROM '.DB_PREFIX.'spare_receive u 
        LEFT JOIN '.DB_PREFIX.'org_main o ON u.org_id = o.org_id 
        LEFT JOIN '.DB_PREFIX."stores_main s ON u.stores_id =  s.stores_id
        WHERE u.flag = '1'  $conditions $receivedate_search $storesid_search
        ORDER BY u.spare_id DESC
        $max");
            $stmt_data->execute(); ?>



        <div class="table-responsive">
            <table class="table table-bordered table-hover table-strip" id="tbData"
                style="margin-top: 13px !important; min-height: 300px;">
                <thead>
                    <tr>
                        <th class="text-center" width="20px">ลำดับ</th>
                        <th width="100px">วันที่รับ</th>
                        <th>ร้าน</th>
                        <th>รายการ</th>
                        <th>ผู้ทำรายการ</th>
                        <th>หน่วยงาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

            $i = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
                ++$i;
                $receive_id = $row['receive_id'];
                $receiveid = $row['receive_id'];
                $receiveid = base64_encode($receiveid);
                $receive_date = date_db_2form($row['receive_date']);

                $org_shortname = $row['org_shortname'];
                $stores_name = $row['stores_name'];
                $flag = $row['flag'];

                $add_users = getUsername($row['add_users']);

                $stmt_detail = $conn->prepare('SELECT GROUP_CONCAT(s.spare_name) AS gspare_name
                FROM '.DB_PREFIX.'spare_receive_data u 
                LEFT JOIN  '.DB_PREFIX.'spare_main s ON u.spare_id = s.spare_id
                LEFT JOIN '.DB_PREFIX."cunit t ON u.spare_unit = t.unit_id
                WHERE u.flag != '0' AND u.receive_id = '$receive_id' ");
                $stmt_detail->execute();
                $row_detail = $stmt_detail->fetch(PDO::FETCH_ASSOC);
                $gspare_name = str_replace(',', '</br>', $row_detail['gspare_name']); ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-center"><?php echo $receive_date; ?></td>
                        <td><?php echo $stores_name; ?></td>
                        <td><?php echo $gspare_name; ?></td>
                        <td><?php echo $add_users; ?></td>
                        <td><?php echo $org_shortname; ?></td>
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
                                            <a href="dashboard.php?module=spare&page=spare-receive-print&id=<?php echo $receiveid; ?>&act=<?php echo base64_encode('view'); ?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">รายละเอียด</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=spare&page=spare-receive&id=<?php echo $receiveid; ?>&act=<?php echo base64_encode('edit'); ?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไข</span>
                                            </a>
                                        </li>

                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link"
                                                onclick='confirm_receive_delete(<?php echo $receive_id; ?>)'>
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
            $page_link = "dashboard.php?module=$module&page=spare-receive-list&search=$search&receivedate=$receive_date_get&storesid=$storesid&pagenum";

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
$(document).ready(function() {


    $('#storesid').select2({});


});
$('#receivedate').datepicker({
    autoclose: true
});

function confirm_receive_delete(id) {
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
            $.post("core/spare/spare-receive-del.php", {
                id: id
            }, function(result) {
                //  $("test").html(result);
                //console.log(result.code);
                location.reload();
            });
        }
    })
}
</script>