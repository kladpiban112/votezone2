
<!DOCTYPE html>
<html lang="th" >
    <!--begin::Head-->
    <head><base href="">
        <meta charset="utf-8"/>
        <title>VOTEZONE | ระบบจัดการเขตเลือกตั้ง</title>
        <meta name="description" content="Login page example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Mitr:wght@200;300;400&display=swap"/>        <!--end::Fonts-->


                    <!--begin::Page Custom Styles(used by this page)-->
                             <link href="assets/css/pages/login/classic/login-4.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                        <!--end::Page Custom Styles-->

        <!--begin::Global Theme Styles(used by all pages)-->
                    <link href="assets/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/css/style.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
                <!--end::Layout Themes-->

                <link rel="shortcut icon" href="assets/images/ThaiAkitechPro.ico"/>

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body" style="background-image: url(assets/media/bg/bg-9.jpg)"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading"  >

    	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
	<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-9.jpg');">
		<div class="login-form text-center p-7 position-relative overflow-hidden">
			<!--begin::Login Header-->
			<div class="d-flex flex-center mb-8">
				<a href="#">
					<img src="assets/images/ThaiAkitechPro.png" class="max-h-200px" alt=""/>
				</a>
			</div>
			<!--end::Login Header-->

			<!--begin::Login Sign in form-->
			<div class="login-signin">
				<div class="mb-10">
					<h2 style="color : #000; font-family: Kanit;">VOTEZONE</h2>
					<div class="opacity-100 font-weight-bold" style="color : #000; font-family: Kanit;">ระบบจัดการเขตเลือกตั้ง</div>
				</div>
				<form class="form" id="kt_login_signin_form">
                <input class="" type="hidden" name="act" id="act"  value="login"/>
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="text" name="usrname" id="usrname"  autocomplete="off" />
					</div>
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="password" name="pwd" id="pwd"  autocomplete="off" />
					</div>
					<!--<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
						<div class="checkbox-inline">
							<label class="checkbox m-0 text-muted">
								<input type="checkbox" name="remember" />
								<span></span>
								Remember me
							</label>
						</div>
						<a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>
					</div>-->
					<button  class="btn btn-warning font-weight-bold px-9 py-4 my-3 mx-4" id="btnLogin">เข้าสู่ระบบ</button>
				</form>
				<div class="mt-10">
					
					<!--<a href="#" id="" class="text-muted text-hover-primary font-weight-bold">กลับหน้าหลัก</a>-->
				</div>
			</div>
			<!--end::Login Sign in form-->

			<!--begin::Login Sign up form-->
			<div class="login-signup">
				<div class="mb-20">
					<h3>Sign Up</h3>
					<div class="text-muted font-weight-bold">Enter your details to create your account</div>
				</div>
				<form class="form" id="kt_login_signup_form">
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Fullname" name="fullname" />
					</div>
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
					</div>
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
					</div>
					<div class="form-group mb-5">
						<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" />
					</div>
					<div class="form-group mb-5 text-left">
						<div class="checkbox-inline">
							<label class="checkbox m-0">
								<input type="checkbox" name="agree" />
								<span></span>
								I Agree the <a href="#" class="font-weight-bold ml-1">terms and conditions</a>.
							</label>
						</div>
						<div class="form-text text-muted text-center"></div>
					</div>
					<div class="form-group d-flex flex-wrap flex-center mt-10">
						<button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
						<button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
					</div>
				</form>
			</div>
			<!--end::Login Sign up form-->

			<!--begin::Login forgot password form-->
			<div class="login-forgot">
				<div class="mb-20">
					<h3>Forgotten Password ?</h3>
					<div class="text-muted font-weight-bold">Enter your email to reset your password</div>
				</div>
				<form class="form" id="kt_login_forgot_form">
					<div class="form-group mb-10">
						<input class="form-control form-control-solid h-auto py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off"/>
					</div>
					<div class="form-group d-flex flex-wrap flex-center mt-10">
						<button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request</button>
						<button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
					</div>
				</form>
			</div>
			<!--end::Login forgot password form-->
		</div>
	</div>
</div>
<!--end::Login-->
	</div>
<!--end::Main-->


        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1200
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#6993FF",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#F3F6F9",
                "dark": "#212121"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1E9FF",
                "secondary": "#ECF0F3",
                "success": "#C9F7F5",
                "info": "#EEE5FF",
                "warning": "#FFF4DE",
                "danger": "#FFE2E5",
                "light": "#F3F6F9",
                "dark": "#D6D6E0"
            },
            "inverse": {
                "white": "#ffffff",
                "primary": "#ffffff",
                "secondary": "#212121",
                "success": "#ffffff",
                "info": "#ffffff",
                "warning": "#ffffff",
                "danger": "#ffffff",
                "light": "#464E5F",
                "dark": "#ffffff"
            }
        },
        "gray": {
            "gray-100": "#F3F6F9",
            "gray-200": "#ECF0F3",
            "gray-300": "#E5EAEE",
            "gray-400": "#D6D6E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#80808F",
            "gray-700": "#464E5F",
            "gray-800": "#1B283F",
            "gray-900": "#212121"
        }
    },
    "font-family": "Taviraj"
};
        </script>

        
        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="assets/plugins/global/plugins.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/js/scripts.bundle.js?v=7.0.6"></script>
				<!--end::Global Theme Bundle-->


                    <!--begin::Page Scripts(used by this page)-->
                            <script src="assets/js/pages/custom/login/login-general.js?v=7.0.6"></script>
                        <!--end::Page Scripts-->

                                
<script>
$('#btnLogin').click(function(e){
        e.preventDefault();
        if ($('#usrname').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุ Username หรือ Email',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#pwd').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุ Password',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {
        var usrname = $("#usrname").val();
        var pwd = $("#pwd").val();
        var act = $("#login").val();
        $.ajax({
            type: "POST",
            url: "core/login.php",
            dataType: "json",
            data: {
                usrname:usrname,
                pwd:pwd,
                act:act
                },
            success: function(data) {  
            //   if (data.code == "200") {
             if (data.code == "200") {
                Swal.fire({
                icon: 'success',
                title: 'ลงชื่อเข้าใช้งานสำเร็จ',
                showConfirmButton: false,
                timer: 1500
                }).then((value) => {
                    //liff.closeWindow();
                    window.location.replace("dashboard.php");
                }); 
                } else if (data.code == "404") {
                  //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                   Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถลงชื่อเข้าใช้งานได้',
                    text: 'กรุณาลองใหม่อีกครั้ง'
                    })
                    .then((value) => {
                      //liff.closeWindow();
                      console.log(data);
                  });
                }
            }
        });

        }
    
      }); //  click


</script>

            </body>
    <!--end::Body-->
</html>
