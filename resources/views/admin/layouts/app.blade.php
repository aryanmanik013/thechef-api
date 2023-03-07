<!DOCTYPE html>

<html lang="en" >
    <!--begin::Head-->
    <head><base href="">
        <meta charset="utf-8"/>
        <title>Thechefapp</title>
        <meta name="description" content="Updates and statistics"/>
         <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->
        <link href="{{ asset('assets/css/themes/layout/brand/dark.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>

                    <!--begin::Page Vendors Styles(used by this page)-->
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>
                        <!--end::Page Vendors Styles-->

 <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.8') }}" rel="stylesheet" type="text/css"/>
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/style.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
       <!--end::Global Theme Styles-->
         <link href="{{ asset('assets/css/pages/wizard/wizard-4.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <!--begin::Layout Themes(used by all pages)-->

         <link href="{{ asset('assets/css/themes/layout/header/base/light.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
         <link href="{{ asset('assets/css/themes/layout/header/menu/light.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
          <!--<link href="{{ asset('assets/css/themes/layout/brand/dark.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>-->
         <link href="{{ asset('assets/css/themes/layout/aside/dark.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>
          <link href="{{ asset('assets/css/bootstrap-multiselect.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
         <!--end::Layout Themes-->
     @stack('styles')

        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}"/>

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >

        <!--begin::Main-->
    <!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile align-items-center  header-mobile-fixed " >
    <!--begin::Logo-->
    <a href="{{ route('admin.home') }}">
        <img alt="Logo" src="{{ asset('assets/media/logos/logo-demo.png') }}" style="width:175px;"/>
    </a>
    <!--end::Logo-->

    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
                    <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->

                    <!--begin::Header Menu Mobile Toggle-->
            <!--<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">-->
            <!--    <span></span>-->
            <!--</button>-->
            <!--end::Header Menu Mobile Toggle-->

        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>       </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">

<!--begin::Aside-->
<div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto"  id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto " id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ route('admin.home') }}" class="brand-logo">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-demo.png') }}" style="width: 175px;"/>
        </a>
        <!--end::Logo-->

                    <!--begin::Toggle-->
            <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                <span class="svg-icon svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
    </g>
</svg><!--end::Svg Icon--></span>           </button>
            <!--end::Toolbar-->
            </div>
    <!--end::Brand-->




    <!--begin::Aside Menu-->



     @include('admin.partials._sidebar')

    <!--end::Aside Menu-->
</div>
<!--end::Aside-->




            <!--begin::Wrapper-->
      <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <!--begin::Header-->
            @include('admin.partials._header')

           
             <!--end::Header -->
             
                 @yield('subheader')
                 <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
               @yield('content')

              
           
            
             </div>
     






    <!--begin::Footer-->

  @include('admin.partials._footer')

                                    
<!--end::Footer-->
                        
      

<!--end::Page-->

<!--end::Main-->




<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">
            User Profile
           
        </h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->

    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('{{ asset('assets/media/logos/logo1.png') }}')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                    {{ Auth::guard('admin')->user()->name }}
                </a>
<!--                 <div class="text-muted mt-1">
                    Application Developer
                </div> -->
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <span class="navi-icon mr-1">
                                <span class="svg-icon svg-icon-lg svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"/>
        <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
    </g>
</svg><!--end::Svg Icon--></span>                           </span>
                            <span class="navi-text text-muted text-hover-primary"> {{ Auth::guard('admin')->user()->email }}</span>
                        </span>
                    </a>

                      <a class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5" href="#"onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       Sign Out
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>








                </div>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Separator-->
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Nav-->
        <div class="navi navi-spacer-x-0 p-0">
            <!--begin::Item-->
            <a href="{{route('admin.user.edit',Auth::guard('admin')->user()->id)}}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <span class="svg-icon svg-icon-md svg-icon-success"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000"/>
        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5"/>
    </g>
</svg><!--end::Svg Icon--></span>                       </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">
                            Credentials
                        </div>
                        <div class="text-muted">
                            Change Your Credentials
                            <!--<span class="label label-light-danger label-inline font-weight-bold">update</span>-->
                        </div>
                    </div>
                </div>
            </a>
            <!--end:Item-->

           
   



        </div>
        <!--end::Notifications-->
    </div>
    <!--end::Content-->
</div>
<!-- end::User Panel-->



                            <!--begin::Quick Panel-->
<div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
    <!--begin::Header-->
    <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
        <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_logs" >Audit Logs</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_notifications" >Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_settings" >Settings</a>
            </li>
        </ul>
        <div class="offcanvas-close mt-n1 pr-5">
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
            <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Content-->
    <div class="offcanvas-content px-10">
        <div class="tab-content">
            <!--begin::Tabpane-->
            <div class="tab-pane fade show pt-3 pr-5 mr-n5 active" id="kt_quick_panel_logs" role="tabpanel">
                <!--begin::Section-->
                <div class="mb-15">
                    <h5 class="font-weight-bold mb-5">System Messages</h5>
                    <!--begin: Item-->
                    <div class="d-flex align-items-center flex-wrap mb-5">
                        <div class="symbol symbol-50 symbol-light mr-5">
                            <span class="symbol-label">
                                <img src="assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt=""/>
                            </span>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                            <a href="#" class="font-weight-bolder text-dark-75 text-hover-primary font-size-lg mb-1">Top Authors</a>
                            <span class="text-muted font-weight-bold">Most Successful Fellas</span>
                        </div>
                        <span class="btn btn-sm btn-light font-weight-bolder py-1 my-lg-0 my-2 text-dark-50">+82$</span>
                    </div>
                    <!--end: Item-->

                    <!--begin: Item-->
                    <div class="d-flex align-items-center flex-wrap mb-5">
                        <div class="symbol symbol-50 symbol-light mr-5">
                            <span class="symbol-label">
                                <img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt=""/>
                            </span>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                            <a href="#" class="font-weight-bolder text-dark-75 text-hover-primary font-size-lg mb-1">Popular Authors</a>
                            <span class="text-muted font-weight-bold">Most Successful Fellas</span>
                        </div>
                        <span class="btn btn-sm btn-light font-weight-bolder  my-lg-0 my-2 py-1 text-dark-50">+280$</span>
                    </div>
                    <!--end: Item-->

                   

               

                
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="mb-5">
                    <h5 class="font-weight-bold mb-5">Notifications</h5>

                    <!--begin: Item-->
                    <div class="d-flex align-items-center bg-light-warning rounded p-5 mb-5">
                        <span class="svg-icon svg-icon-warning mr-5">
                            <span class="svg-icon svg-icon-lg"><!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"/>
        <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"/>
    </g>
</svg><!--end::Svg Icon--></span>                       </span>

                        <div class="d-flex flex-column flex-grow-1 mr-2">
                            <a href="#" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">Another purpose persuade</a>
                            <span class="text-muted font-size-sm">Due in 2 Days</span>
                        </div>

                        <span class="font-weight-bolder text-warning py-1 font-size-lg">+28%</span>
                    </div>
                    <!--end: Item-->





                </div>

                <!--end::Section-->
            </div>
            <!--end::Tabpane-->

            <!--begin::Tabpane-->
            <div class="tab-pane fade pt-2 pr-5 mr-n5" id="kt_quick_panel_notifications" role="tabpanel">
                <!--begin::Nav-->
                <div class="navi navi-icon-circle navi-spacer-x-0">
                    <!--begin::Item-->
                    <a href="#" class="navi-item">
                        <div class="navi-link rounded">
                            <div class="symbol symbol-50 mr-3">
                                <div class="symbol-label"><i class="flaticon-bell text-success icon-lg"></i></div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold font-size-lg">
                                    5 new user generated report
                                </div>
                                <div class="text-muted">
                                    Reports based on sales
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--end::Item-->
                  
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Tabpane-->

            <!--begin::Tabpane-->
            <div class="tab-pane fade pt-3 pr-5 mr-n5" id="kt_quick_panel_settings" role="tabpanel">
                <form class="form">
                    <!--begin::Section-->
                    <div>
                        <h5 class="font-weight-bold mb-3">Customer Care</h5>
                        <div class="form-group mb-0 row align-items-center">
                            <label class="col-8 col-form-label">Enable Notifications:</label>
                            <div class="col-4 d-flex justify-content-end">
                                <span class="switch switch-success switch-sm">
                                    <label>
                                        <input type="checkbox" checked="checked" name="select"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                   
                      
                    </div>
                    <!--end::Section-->

                    <div class="separator separator-dashed my-6"></div>

                    <!--begin::Section-->
                    <div class="pt-2">
                        <h5 class="font-weight-bold mb-3">Reports</h5>
                        <div class="form-group mb-0 row align-items-center">
                            <label class="col-8 col-form-label">Generate Reports:</label>
                            <div class="col-4 d-flex justify-content-end">
                                <span class="switch switch-sm switch-danger">
                                    <label>
                                        <input type="checkbox" checked="checked" name="select"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                     
                        <div class="form-group mb-0 row align-items-center">
                            <label class="col-8 col-form-label">Allow Data Collection:</label>
                            <div class="col-4 d-flex justify-content-end">
                                <span class="switch switch-sm switch-danger">
                                    <label>
                                        <input type="checkbox" checked="checked" name="select"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Section-->

                    <div class="separator separator-dashed my-6"></div>

                    <!--begin::Section-->
                    <div class="pt-2">
                        <h5 class="font-weight-bold mb-3">Memebers</h5>
                        <div class="form-group mb-0 row align-items-center">
                            <label class="col-8 col-form-label">Enable Member singup:</label>
                            <div class="col-4 d-flex justify-content-end">
                                <span class="switch switch-sm switch-primary">
                                    <label>
                                        <input type="checkbox" checked="checked" name="select"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                      
                        
                    </div>
                    <!--end::Section-->
                </form>
            </div>
            <!--end::Tabpane-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Quick Panel-->



                            <!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
        <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>
</div>
<!--end::Scrolltop-->



<!--begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1400
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#3699FF",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#E4E6EF",
                "dark": "#181C32"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1F0FF",
                "secondary": "#EBEDF3",
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
                "secondary": "#3F4254",
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
            "gray-200": "#EBEDF3",
            "gray-300": "#E4E6EF",
            "gray-400": "#D1D3E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#7E8299",
            "gray-700": "#5E6278",
            "gray-800": "#3F4254",
            "gray-900": "#181C32"
        }
    },
    "font-family": "Poppins"
};
        </script>
        <!--end::Global Config-->

        <!--begin::Global Theme Bundle(used by all pages)-->
           <script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.6') }}"></script>
           <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6') }}"></script>
           <script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.6') }}"></script>
                <!--end::Global Theme Bundle-->

        <!--begin::Page Vendors(used by this page)-->
            <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.6') }}"></script>
            <!--end::Page Vendors-->

        <!--begin::Page Scripts(used by this page)-->
            <script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6') }}"></script>
            <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.8') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/basic/paginations.js?v=7.0.8') }}"></script>
<!--<script src="{{ asset('assets/js/pages/crud/file-upload/image-input.js?v=7.0.6')}}"></script>-->

 <!-- <script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6')}}"></script> -->

 <script src="{{ asset('assets/js/bootstrap-multiselect.js?v=7.0.6')}}"></script>
    <script>
        $( document ).ready(function() {
            $('input[name="sort_order"]').attr("onkeypress", "return isNumber(event)");
            $('input[name="phone"]').attr("onkeypress", "return isNumber(event)");
            $('input[name="phone"]').attr("maxlength", "10");
            $('input[name="phone"]').attr("minlength", "10");
            $('input[name="account_number"]').attr("onkeypress", "return isNumber(event)");
            $('input[name="postcode"]').attr("onkeypress", "return isNumber(event)");
        });
    
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        function isDecimal(text,evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                if (text.value.indexOf('.') === -1) {
                  return true;
                } else {
                  return false;
                }
            } else {
                if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        }
    </script>
                 @stack('scripts')
            <!--end::Page Scripts-->
            </body>
    <!--end::Body-->
</html>
