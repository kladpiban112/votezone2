<!--begin::Subheader-->
<div class="subheader py-2 py-lg-12  subheader-transparent " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">

            <!--begin::Heading-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h2 class="text-white font-weight-bold my-2 mr-5">
                    <?php if($logged_org_name != ""){?>
                        <?php echo $logged_org_name;?>
                    <?php }else{?>
                        <?php echo $cfg_site_title;?>
                    <?php }?>
                </h2>
                <!--end::Title-->

                                    <!--begin::Breadcrumb-->
                    <div class="d-flex align-items-center font-weight-bold my-2">
                        <!--begin::Item-->
                        <a href="dashboard.php" class="opacity-75 hover-opacity-100">
                            <i class="flaticon2-shelter text-white icon-1x"></i>
                        </a>
                        <!--end::Item-->
                                                    <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="dashboard.php" class="text-white text-hover-white opacity-75 hover-opacity-100">
                                หน้าแรก                            </a>
                            <!--end::Item-->
                                                    <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="dashboard.php?module=<?php echo $module;?>" class="text-white text-hover-white opacity-75 hover-opacity-100">
                                <?php echo getModuleName($module);?>                        </a>
                            <!--end::Item-->
                                            </div>
    				<!--end::Breadcrumb-->
                            </div>
            <!--end::Heading-->

                    </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">



                <!--begin::Dropdown-->
                <!--<div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="Quick actions" data-placement="top">
                    <a href="#" class="btn btn-white font-weight-bold py-3 px-6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        เมนูด่วน
                    </a>
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
               
<ul class="navi navi-hover py-5">
    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="flaticon2-drop"></i></span>
            <span class="navi-text">New Group</span>
        </a>
    </li>
    

    <li class="navi-separator my-3"></li>

    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="flaticon2-magnifier-tool"></i></span>
            <span class="navi-text">Help</span>
        </a>
    </li>
    
</ul>

                    </div>
                </div>-->
                <!--end::Dropdown-->
                    </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->