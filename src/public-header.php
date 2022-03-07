<div id="kt_header_mobile" class="header-mobile " >
	<!--begin::Logo-->
	<a href="index.php">
		<img alt="Logo" src="assets/images/dfix-logo.png" class="logo-default max-h-30px"/>
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
	<div class=" container  d-flex align-items-stretch justify-content-between">
		<!--begin::Left-->
		<div class="d-flex align-items-stretch mr-3">
			<!--begin::Header Logo-->
			<div class="header-logo">
				<a href="dashboard.php">
					<img alt="Logo" src="assets/images/dfix-logo.png" class="logo-default max-h-40px"/>
					<img alt="Logo" src="assets/images/dfix-logo.png" class="logo-sticky max-h-40px"/>
				</a>
			</div>
			<!--end::Header Logo-->

							<!--begin::Header Menu Wrapper-->
				<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
					<!--begin::Header Menu-->
					<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile  header-menu-layout-default " >
						<!--begin::Header Nav-->
						

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
							<span class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1">สวัสดี,</span>
						   	<span class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4"><?php echo $logged_user_name;?>ผู้ใช้งานทั่วไป</span>
	                        <span class="symbol symbol-35">
	                            <span class="symbol-label text-white font-size-h5 font-weight-bold bg-white-o-30">A</span>
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
		<div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5"><?php echo $logged_user_name;?>ผู้ใช้งานทั่วไป</div>
		<div class="text-muted"><?php echo $logged_user_role_title;?></div>
        
        <!--end::Text-->
    </div>
    <div class="separator separator-solid"></div>
    <!--end::Header-->

	        	    </div>
	                <!--end::Dropdown-->
	            </div>
	            <!--end::User-->
		    		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>