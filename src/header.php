<div id="kt_header_mobile" class="header-mobile " >
	<!--begin::Logo-->
	<a href="index.php">
		<img alt="Logo" src="assets/images/ThaiAkitechPro.png" class="logo-default max-h-30px"/>
	</a>
	<!--end::Logo-->

	<!--begin::Toolbar-->
	<div class="d-flex align-items-center">

					<button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
				<span></span>
			</button>

		<button class="btn btn-icon btn-hover-transparent-white p-0 ml-3" id="kt_header_mobile_topbar_toggle">
			<span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>		</button>
	</div>
	<!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Header-->
<div id="kt_header" class="header  header-fixed " >
	<!--begin::Container-->
	<div class=" container-fluid  d-flex align-items-stretch justify-content-between">
		<!--begin::Left-->
		<div class="d-flex align-items-stretch mr-3">
			<!--begin::Header Logo-->
			<div class="header-logo">
				<a href="dashboard.php">
					<img alt="Logo" src="assets/images/Popwin.png" class="logo-default max-h-60px"/>
					<img alt="Logo" src="assets/images/Popwin.png" class="logo-sticky max-h-60px"/>
				</a>
			</div>
			<!--end::Header Logo-->

							<!--begin::Header Menu Wrapper-->
				<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
					<!--begin::Header Menu-->
					<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile  header-menu-layout-default " >
						<!--begin::Header Nav-->
						<ul class="menu-nav ">


							<?php 

							$logged_user_permiss = $logged_user_permiss;  // permission

							$sql_permiss = "SELECT * FROM users_permiss WHERE m_id IN($logged_user_permiss) AND flag = '1' ORDER BY m_order ASC ";
							$stmt_permiss = $conn->prepare ($sql_permiss);
							$stmt_permiss->execute();
															
							while ($rowp = $stmt_permiss->fetch(PDO::FETCH_ASSOC))
							{
								$m_id = $rowp['m_id'];
								$m_name = $rowp['m_name'];	
								$m_url = $rowp['m_url'];
								$m_icon = $rowp['m_icon'];	

								?>


							
							<?php 									
							$numb_sm = $conn->query("SELECT count(1) FROM ".DB_PREFIX."users_subpermiss WHERE m_id = '$m_id'  ")->fetchColumn();
							if($numb_sm > 0){ ?>
							<ul class="menu-nav ">
								<li class="menu-item   menu-item-submenu menu-item-rel menu-item-open menu-item-here"  data-menu-toggle="click" aria-haspopup="true"><a  href="javascript:;" class="menu-link menu-toggle"><span class="menu-text"><i class="<?php echo $m_icon;?>"></i>&nbsp;<?php echo $m_name;?></span><i class="menu-arrow"></i></a>
								<div class="menu-submenu menu-submenu-classic menu-submenu-left" > 
									<ul class="menu-subnav">

									<?php 

									$sql_subpermiss = "SELECT * FROM ".DB_PREFIX."users_subpermiss WHERE m_id = '$m_id' AND flag = '1' ORDER BY sm_order ASC ";
									$stmt_subpermiss = $conn->prepare ($sql_subpermiss);
									$stmt_subpermiss->execute();
																	
									while ($rowsm = $stmt_subpermiss->fetch(PDO::FETCH_ASSOC)){
										$sm_page = $rowsm['sm_page'];
										$sm_title = $rowsm['sm_title'];	
										$sm_icon = $rowsm['sm_icon'];
										?>
										<li class="menu-item "  aria-haspopup="true"><a  href="<?php echo $m_url;?>&page=<?php echo $sm_page;?>" class="menu-link "><span class="menu-text"><i class="<?php echo $sm_icon;?>"></i>&nbsp;<?php echo $sm_title;?></span><span class="menu-desc"></span></a></li>
									<?php } 
									?>
									

									</ul>
								</div>
								</li>
							</ul>


							<?php }else{?>


							<ul class="menu-nav ">
                            <li class="menu-item   menu-item-submenu menu-item-rel menu-item-here"  aria-haspopup="true"><a  href="<?php echo $m_url;?>" class="menu-link"><span class="menu-text"><i class="<?php echo $m_icon;?>"></i>&nbsp;<?php echo $m_name;?></span><i class="menu-arrow"></i></a></li>
                           
                            

							</ul>

							<?php } ?>


							<?php } // while permiss ?>


						<!--end::Header Nav-->
					</div>
					<!--end::Header Menu-->
				</div>
				<!--end::Header Menu Wrapper-->
					</div>
		<!--end::Left-->

		<!--begin::Topbar-->
		<div class="topbar">
		    	    	    
		    		        

		    		       

		<!--begin::User-->
	            <div class="dropdown">
	                <!--begin::Toggle-->
	                <div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
	                    <div class="btn btn-icon btn-hover-transparent-white d-flex align-items-center btn-lg px-md-2 w-md-auto">
							<span class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1">ยินดีต้อนรับ,</span>
						   	<span class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4"><?php echo $logged_user_name;?></span>
	                        <span class="symbol symbol-35">
							<?php if($logged_user_avatar == ""){?>
                    <img src="uploads/avatars/no_avatar.png" alt="image"/>
                            <?php }else{?>
                                <img src="uploads/avatars/<?php echo $logged_user_avatar;?>" alt="image"/>
								<?php   } ?>
	                            <!-- <span class="symbol-label text-white font-size-h5 font-weight-bold bg-white-o-30">A</span> -->
	                        </span>
	                    </div>
	                </div>
	                <!--end::Toggle-->

	                <!--begin::Dropdown-->
	        	    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
	        	            <!--begin::Header-->
    <div class="d-flex align-items-center p-8 rounded-top">
        <!--begin::Symbol-->
        <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
		
			<?php if($logged_user_avatar == ""){?>
                    <img src="uploads/avatars/no_avatar.png" alt="image"/>
                            <?php }else{?>
                                <img src="uploads/avatars/<?php echo $logged_user_avatar;?>" alt="image"/>
								<?php   } ?>
								

        </div>
        <!--end::Symbol-->

        <!--begin::Text-->
		<div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5"><?php echo $logged_user_name;?></div>
		<div class="text-muted"><?php echo $logged_user_role_title;?></div>
        
        <!--end::Text-->
    </div>
    <div class="separator separator-solid"></div>
    <!--end::Header-->

<!--begin::Nav-->
<div class="navi navi-spacer-x-0 pt-5">
    <!--begin::Item-->
    <a href="dashboard.php?module=users&page=users-edit&id=<?php echo base64_encode($logged_user_id);?>&act=<?php echo base64_encode('edit');?>" class="navi-item px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="flaticon2-calendar-3 text-success"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    ข้อมูลส่วนตัว
                </div>
                <div class="text-muted">
                    จัดการข้อมูลส่วนตัว
                </div>
            </div>
        </div>
    </a>
    <!--end::Item-->

   <?php if(($logged_user_role_id == 1) OR ($logged_user_role_id == 2)){?>
	<!--begin::Item-->
    <a href="dashboard.php?module=systems&page=org-edit&orgid=<?php echo base64_encode($logged_org_id);?>&act=<?php echo base64_encode('edit');?>" class="navi-item px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="far fa-building"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    ข้อมูลหน่วยงาน
                </div>
                <div class="text-muted">
                    ตั้งค่าข้อมูลหน่วยงาน
                </div>
            </div>
        </div>
    </a>
    <!--end::Item-->
   <?php } ?>

    



    <!--begin::Footer-->
    <div class="navi-separator mt-3"></div>
    <div class="navi-footer  px-8 py-5">
        <a href="logout.php" class="btn btn-light-danger font-weight-bold">ออกจากระบบ</a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Nav-->
	        	    </div>
	                <!--end::Dropdown-->
	            </div>
	            <!--end::User-->
		    		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>