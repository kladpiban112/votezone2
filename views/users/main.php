
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="fas fa-users"></i>&nbsp;ผู้ใช้งานระบบ 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=users&page=users-add" class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มผู้ใช้"><i class="fa fa-plus-circle" title="เพิ่มผู้ใช้" data-toggle="tooltip"></i>เพิ่มผู้ใช้</a>
					</div>
				</div>
			</div>



	<div class="card-body">

    <?php
       if($logged_user_role_id == '1'){
        $conditions = " ";
    }else{

        $conditions = " AND u.org_id = '$logged_org_id' ";
    }
        
    $numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."users u  WHERE u.user_id IS NOT NULL  $conditions ")->fetchColumn();

  
        if (!(isset($pagenum))) { $pagenum = 1; }
        if ($numb_data==0) { echo "No Data"; }
        else{
        $page_rows = 10;
        $last = ceil($numb_data/$page_rows);

        if ($pagenum < 1)
        {
        $pagenum = 1;
        }
        elseif ($pagenum > $last)
        {
        $pagenum = $last;
        }

        //สำหรับจัดการหน้า
        $numb_data = $numb_data;
        if($numb_data<=$page_rows)	{
            $Num_Pages =1;
        }else if(($numb_data % $page_rows)==0){
            $Num_Pages =($numb_data/$page_rows) ;
        }else{
            $Num_Pages =($numb_data/$page_rows)+1;
            $Num_Pages = (int)$Num_Pages;
        }

        $max = ' LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;	
     
        $stmt_data = $conn->prepare ("SELECT u.*,o.org_name,r.title AS role_title FROM ".DB_PREFIX."users u 
        LEFT JOIN ".DB_PREFIX."org_main o ON u.org_id = o.org_id 
        LEFT JOIN ".DB_PREFIX."users_roles r ON u.role_id = r.role_id
        WHERE u.user_id IS NOT NULL  $conditions
        ORDER BY u.user_id DESC
        $max");
        $stmt_data->execute();		


    ?>



<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>โปรไฟล์</th>
                        <th>ชื่อ-สกุล</th>
                        <th>username</th>
                        <th>หน่วยงาน</th>
                        <th class="text-center">สิทธิ์ใช้งาน</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">จัดการ</th>	
    </tr>
    </thead>
    <tbody>
            
            <?php

            $i  = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $userid = $row['user_id'];
                $userid_enc = base64_encode($userid);
                $fullname = $row['name'];
                $email = $row['email'];
                $cid = $row['cid'];
                $org_name = $row['org_name'];
                $role_title = $row['role_title'];
                $avatar = $row['avatar'];
                $active = $row['active'];

                ?>
                <tr>
                            <td class="text-center"><?php echo $i;?></td>
                            <td class="text-center"><div class="symbol symbol-50 symbol-lg-60">
                            <?php if($avatar == ""){?>
                    <img src="uploads/avatars/no_avatar.png" alt="image"/>
                            <?php }else{?>
                                <img src="uploads/avatars/<?php echo $avatar;?>" alt="image"/>
                                <?php   } ?>
                </div></td>
                            <td><?php echo $fullname;?></br><small>เลขบัตร : <?php echo $cid;?></small></td>
                            <td><?php echo $email;?></td>
                            <td><?php echo $org_name;?></td>
                            <td ><?php echo $role_title;?></td>
                            <td class="text-center">
                            <?php if($active == '1'){ ?>
                            <span class="label label-lg label-light-success label-inline">เปิดใช้งาน</span>
                            <?php }else if($active == '0'){ ?>
                                <span class="label label-lg label-light-danger label-inline">ปิดใช้งาน</span>
                            <?php } ?>
                            
                            </td>
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
                                            <a href="dashboard.php?module=users&page=users-add&id=<?php echo $userid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไข</span>
                                            </a>
                                        </li>

                                        <!--<li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ลบ</span>
                                            </a>
                                        </li> -->
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
$Prev_Page = $pagenum-1;
$Next_Page = $pagenum+1;
$page_link = "dashboard.php?module=$module&page=main&search=$search&pagenum";

if($pagenum==1)		//	กรณีอยู่หน้า 1 หรือยังไม่เลือกหน้า
{
    echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
            for($a=1;$a<=$p;$a++)
            {
                    if($pagenum+$a<$Num_Pages)
                    {
                    echo  "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
                    }
            }
    if($Num_Pages==2)
    {
        echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
        echo " <a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
    }
}
else		// กรณีอยู่หน้าอื่นๆ
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Prev_Page' title='หน้าก่อนหน้า'><i class='ki ki-bold-arrow-back icon-xs'></i></a> ";		//	แสดงเครื่องหมาย <<
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=1'>1</a> ";		//	แสดงหมายเลข 1
}

if($pagenum==2 )	//	ถ้าอยู่หน้า 2
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
        for($a=1;$a<=$p;$a++)
        {
            if($pagenum+$a<$Num_Pages)
            {		
                echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
            }
        }		
}

if($pagenum>2 && $pagenum<$Num_Pages)	//	ถ้าอยู่หน้ามากกว่า 2 แต่น้อยกว่าหน้าสุดท้าย
{
    for($a=$p;$a>=1;$a--)		//	หา $p หน้าด้านซ้าย
    {
        if($pagenum-$a>1)	//	$p หน้าด้านซ้ายต้องมากกว่า 1
        {
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum-$a)." '>".($pagenum-$a)."</a>";
        }
    }
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	หน้าปัจจุบัน
    for($a=1;$a<=$p;$a++)		//	หา $p หน้าด้านขวา
    {
        if($pagenum+$a<$Num_Pages)		//	$p หน้าด้านขวาต้องน้อยกว่าหน้าสุดท้าย
        {
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
        }
    }
}

if($pagenum==$Num_Pages && $Num_Pages!=1 && $Num_Pages!=2)		//	ถ้าเลือกหน้าสุดท้าย
{
    for($a=$p;$a>=1;$a--)		//	หา $p หน้าด้านซ้าย
    {
        if($pagenum-$a>1)
        {
        echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum-$a)." '>".($pagenum-$a)."</a>";
        }
    }
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	แสดงหน้าปัจจุบัน
}

else if($Num_Pages!=1 && $Num_Pages!=2)	//	กรณีไม่ได้เลือกหน้าสุดท้าย
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
    echo " <a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
}


?>



    </div>

    <div class="d-flex align-items-center py-3">
        <span class="text-muted">หน้า <?php echo $pagenum;?> / <?php echo $last;?> </span>
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



