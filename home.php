<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once "core/config.php";
require_once ABSPATH."/functions.php";
//require_once ABSPATH."/checklogin.php";

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$module = filter_input(INPUT_GET, 'module', FILTER_SANITIZE_STRING);
if(!$page) $page = 'home-main';
if(!$module) $module = '';
$msg = filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING);
$pagenum = filter_input(INPUT_GET, 'pagenum', FILTER_SANITIZE_NUMBER_INT);

?>

<!DOCTYPE html>
<html lang="th" >
    <!--begin::Head-->
    <head><base href="">
        <meta charset="utf-8"/>
        <title><?php echo $cfg_site_title;?></title>
        <meta name="description" content="Updates and statistics"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<link rel="shortcut icon" href="assets/images/ThaiAkitechPro.ico"/>
        <?php require_once("src/global-header.php");?> 

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body" style="background-image: url(assets/media/bg/bg-10.jpg)"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading"  >

    	<!--begin::Main-->
	<!--begin::Header Mobile-->
<?php require_once("src/public-header.php");?>
<!--end::Header-->

				<!--begin::Content-->
				<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                                            <?php
                                            require_once("src/breadcrumb.php");
                                            ?>

					<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container ">
<!--begin::Dashboard-->
<!--begin::Row-->
<div class="row">
    <div class="col-xl-12">
        <!--begin::Mixed Widget 10-->
<!--<div class="card card-custom card-stretch gutter-b">
    <div class="card-body d-flex flex-column">
        <div class="flex-grow-1 pb-5" style="height: 500px;">-->

            <?php 
				// ADMIN pages
				$module = "public";
				$page = "repair-add";
				if (!file_exists("views/".$module."/".$page.".php")) {
					include ("views/404.php");
				}else{
					switch ($page){       

						case $page:
							include ("views/".$module."/".$page.".php");
							break;					
													
						default:
							include ("views/home-main.php");
							break;						
					}
				} 
				?>


       <!-- </div>
    </div>
</div>-->
<!--end::Mixed Widget 10-->
</div>
<!--end::Row-->
<!--end::Dashboard-->
					</div>
		<!--end::Container-->
	</div>
<!--end::Entry-->
				</div>
				<!--end::Content-->

<!--begin::Footer-->
<?php
include("src/footer.php");
?>
<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
<!--end::Main-->






                            <!--begin::Scrolltop-->
							<div id="kt_scrolltop" class="scrolltop">
	<span class="svg-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
        <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span></div>
<!--end::Scrolltop-->


                
<?php require_once("src/global-footer.php");?> 
        
            </body>
    <!--end::Body-->
</html>
