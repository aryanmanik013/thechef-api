<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
   <!--begin::Menu Container-->
   <div
      id="kt_aside_menu"
      class="aside-menu my-4 "
      data-menu-vertical="1"
      data-menu-scroll="1" data-menu-dropdown-timeout="500" >
      <!--begin::Menu Nav-->
      <ul class="menu-nav ">
      <li class="menu-item   {{ request()->is('admin') ? 'menu-item-active' : '' }}" aria-haspopup="true"  >
         <a  href="{{ route('admin.home') }}" class="menu-link ">
            <span class="svg-icon menu-icon">
               <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <polygon points="0 0 24 0 24 24 0 24"/>
                     <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"/>
                     <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"/>
                  </g>
               </svg>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">
            Dashboard
            </span>
         </a>
      </li>
       @if(auth()->user()->can('View Category')||Auth::guard('admin')->user()->id==1 || auth()->user()->can('View PayoutGroup')||Auth::guard('admin')->user()->id==1)
           <li class="menu-item  menu-item-submenu {{ request()->is('admin/food_category') || request()->is('admin/food_category/*')|| request()->is('admin/payout_group') || request()->is('admin/payout_group/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
               <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Barcode-read.svg-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <rect x="0" y="0" width="24" height="24"/>
                     <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16"/>
                     <path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" fill="#000000" fill-rule="nonzero"/>
                  </g>
               </svg>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Catalog</span>
            <i class="menu-arrow"></i>
         </a>
         <div class="menu-submenu ">
            <i class="menu-arrow">
            </i>
            <ul class="menu-subnav">

              <li class="menu-item  menu-item-parent" aria-haspopup="true" ><span class="menu-link"><span class="menu-text"></span></span>
              </li>
 @if(auth()->user()->can('View Category')||Auth::guard('admin')->user()->id==1)
              <li class="menu-item  menu-item-submenu {{ request()->is('admin/food_category') || request()->is('admin/food_category/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.food_category.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Category</span>
              </a>
              </li>
              @endif
               @if(auth()->user()->can('View PayoutGroup')||Auth::guard('admin')->user()->id==1)
                     <li class="menu-item  menu-item-submenu {{ request()->is('admin/payout_group') || request()->is('admin/payout_group/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.payout_group.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Payout Group</span>
              </a>
              </li>

                @endif

       
              </ul>
      </div>
      </li>

       @endif
   


 @if(auth()->user()->can('View Food')||Auth::guard('admin')->user()->id==1 || auth()->user()->can('View Kitchen')||Auth::guard('admin')->user()->id==1 || auth()->user()->can('View InappropriateReport')||Auth::guard('admin')->user()->id==1)
           <li class="menu-item  menu-item-submenu {{ request()->is('admin/kitchen') || request()->is('admin/kitchen/*')|| request()->is('admin/kitchen-food') || request()->is('admin/kitchen-food/*')|| request()->is('admin/inappropriate-report') || request()->is('admin/inappropriate-report/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
               <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Barcode-read.svg-->
            <i class="fas fa-utensils" style="color:#fff;"></i>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Kitchen</span>
            <i class="menu-arrow"></i>
         </a>
         <div class="menu-submenu ">
            <i class="menu-arrow">
            </i>
            <ul class="menu-subnav">

              <li class="menu-item  menu-item-parent" aria-haspopup="true" ><span class="menu-link"><span class="menu-text"></span></span>
              </li>
  
               @if(auth()->user()->can('View Kitchen')||Auth::guard('admin')->user()->id==1)
              <li class="menu-item  menu-item-submenu {{ request()->is('admin/kitchen') || request()->is('admin/kitchen/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.kitchen.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Kitchens</span>
              </a>
              </li>
  @endif
               @if(auth()->user()->can('View Food')||Auth::guard('admin')->user()->id==1)

              <li class="menu-item  menu-item-submenu {{ request()->is('admin/kitchen-food') || request()->is('admin/kitchen-food/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.kitchen-food.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Food</span>
              </a>
              </li>
  @endif
               @if(auth()->user()->can('View InappropriateReport')||Auth::guard('admin')->user()->id==1)
               <li class="menu-item  menu-item-submenu {{ request()->is('admin/inappropriate-report') || request()->is('admin/inappropriate-report/*')? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.inappropriate-report.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Inappropriate Report</span>
              </a>
              </li>

                @endif

       
              </ul>
      </div>
      </li>
   @endif
               @if(auth()->user()->can('View Order')||Auth::guard('admin')->user()->id==1)
     <li class="menu-item  menu-item-submenu {{ request()->is('admin/order') || request()->is('admin/order/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.order.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><i class="fa fa-file" style="color:#fff;"></i><!--end::Svg Icon--></span>
<span class="menu-text">Orders</span></a>

</li>

  @endif
   @if(auth()->user()->can('View Report')||Auth::guard('admin')->user()->id==1) 
        <li class="menu-item  menu-item-submenu  {{request()->is('admin/cancelledReport') || request()->is('admin/cancelledReport')|| request()->is('admin/report') || request()->is('admin/reportFilter')||request()->is('admin/couponReport') || request()->is('admin/couponReportFilter') ? 'menu-item-active menu-item-open' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary svg-icon-2x">
               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Clipboard-list.svg-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <rect x="0" y="0" width="24" height="24"/>
                     <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                     <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                     <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
                     <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
                     <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
                     <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
                     <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
                     <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
                  </g>
               </svg>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Reports</span>
            <i class="menu-arrow"></i>
         </a>
         <div class="menu-submenu ">
            <i class="menu-arrow">
            </i>
            <ul class="menu-subnav">

              <li class="menu-item  menu-item-parent" aria-haspopup="true" ><span class="menu-link"><span class="menu-text"></span></span>
              </li>

              <li class="menu-item  menu-item-submenu" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.report')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Reports</span>
              </a>
              </li>
                <li class="menu-item  menu-item-submenu" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.cancelledReport')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Cancelled Reports</span>
              </a>
              </li>

              <li class="menu-item  menu-item-submenu" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.couponReport')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Coupon Reports</span>
              </a>
              </li>


              </ul>
      </div>
      </li>
      @endif



       
               @if(auth()->user()->can('View DeliveryPartner')||Auth::guard('admin')->user()->id==1)


        <li class="menu-item  menu-item-submenu {{ request()->is('admin/delivery-partner') || request()->is('admin/delivery-partner/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.delivery-partner.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><i class="fa fa-user-friends" style="color:#fff;"></i><!--end::Svg Icon--></span>
<span class="menu-text">Delivery Partners</span></a>

</li>



  @endif
               @if(auth()->user()->can('View Customer')||Auth::guard('admin')->user()->id==1)








     <li class="menu-item  menu-item-submenu {{ request()->is('admin/customer') || request()->is('admin/customer/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="{{route('admin.customer.index')}}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary svg-icon-2x">
               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\User.svg-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <polygon points="0 0 24 0 24 24 0 24"/>
                     <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                     <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                  </g>
               </svg>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Customers </span>
         </a>
        
      </li>
        @endif
               @if(auth()->user()->can('View Users')||Auth::guard('admin')->user()->id==1)
        <li class="menu-item  menu-item-submenu {{ request()->is('admin/user') || request()->is('admin/user/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="{{route('admin.user.index')}}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary svg-icon-2x">
               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\User.svg-->
               <i class="fa fa-users" style="color:#fff;"></i>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Users </span>
         </a>
        
      </li>

  @endif
               @if(auth()->user()->can('View Banner')||Auth::guard('admin')->user()->id==1)

        <li class="menu-item  menu-item-submenu {{ request()->is('admin/banner') || request()->is('admin/banner/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.banner.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><i class="fa fa-image" style="color:#fff;"></i><!--end::Svg Icon--></span>
         <span class="menu-text">Banners</span></a>
         </li>
        @endif
               @if(auth()->user()->can('View Coupon')||Auth::guard('admin')->user()->id==1)
        <li class="menu-item  menu-item-submenu  {{ request()->is('admin/coupon') || request()->is('admin/coupon/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.coupon.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><i class="fa fa-money-bill-alt" style="color:#fff;"></i><!--end::Svg Icon--></span>
         <span class="menu-text">Coupon</span></a>
         </li>
@endif
  @if(auth()->user()->can('View Settings')||Auth::guard('admin')->user()->id==1)
      <li class="menu-item  menu-item-submenu {{ request()->is('admin/settings') || request()->is('admin/settings/*')|| request()->is('admin/country') || request()->is('admin/country/*')|| request()->is('admin/state') || request()->is('admin/state/*')||request()->is('admin/delivery-charge/*')|| request()->is('admin/delivery-charge')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary svg-icon-2x">
               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Clipboard-list.svg-->
<i class="fa fa-cogs" style="color:#fff;"></i>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Settings</span>
            <i class="menu-arrow"></i>
         </a>
         <div class="menu-submenu ">
            <i class="menu-arrow">
            </i>
            <ul class="menu-subnav">

              <li class="menu-item  menu-item-parent" aria-haspopup="true" ><span class="menu-link"><span class="menu-text"></span></span>
              </li>
                
             
              <li class="menu-item  menu-item-submenu {{ request()->is('admin/settings') || request()->is('admin/settings/*') ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.settings.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">General</span>
              </a>
              </li>
       
                <li class="menu-item  menu-item-submenu {{ request()->is('admin/country') || request()->is('admin/country/*')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.country.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Country</span>
              </a>
              </li>
             
                     <li class="menu-item  menu-item-submenu {{ request()->is('admin/state') || request()->is('admin/state/*')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.state.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">State</span>
              </a>
              </li>

               <li class="menu-item  menu-item-submenu {{ request()->is('admin/delivery-charge/*')|| request()->is('admin/delivery-charge')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.delivery-charge.index')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Delivery charge</span>
              </a>
              </li>


              </ul>
      </div>
      </li>
@endif
               @if(auth()->user()->can('View PayoutRequest')||Auth::guard('admin')->user()->id==1)

     <li class="menu-item  menu-item-submenu {{ request()->is('admin/kitchen_payout_requests/*')|| request()->is('admin/kitchen_payout_requests') || request()->is('admin/delivery_partner_payout_requests/*')|| request()->is('admin/delivery_partner_payout_requests')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
         <a  href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary svg-icon-2x">
               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Clipboard-list.svg-->
              <i class="fa fa-coins" style="color:#fff;"></i>
               <!--end::Svg Icon-->
            </span>
            <span class="menu-text">Payout Requests</span>
            <i class="menu-arrow"></i>
         </a>
         <div class="menu-submenu ">
            <i class="menu-arrow">
            </i>
            <ul class="menu-subnav">

              <li class="menu-item  menu-item-parent" aria-haspopup="true" ><span class="menu-link"><span class="menu-text"></span></span>
              </li>
              <li class="menu-item  menu-item-submenu {{ request()->is('admin/kitchen_payout_requests/*')|| request()->is('admin/kitchen_payout_requests')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.kitchen_payout_requests')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Kitchen</span>
              </a>
              </li>
                <li class="menu-item  menu-item-submenu {{ request()->is('admin/delivery_partner_payout_requests/*')|| request()->is('admin/delivery_partner_payout_requests')  ? 'menu-item-active  menu-item-open ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover">
              <a  href="{{route('admin.delivery_partner_payout_requests')}}" class="menu-link menu-toggle">
              <i class="menu-bullet menu-bullet-dot">
              <span>
                  
              </span>
              </i>
              <span class="menu-text">Delivery</span>
              </a>
              </li>
              
          


              </ul>
      </div>
      </li>
  @endif
               @if(auth()->user()->can('View FAQ')||Auth::guard('admin')->user()->id==1)
      
        <li class="menu-item  menu-item-submenu {{ request()->is('admin/faq') || request()->is('admin/faq/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.faq.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <rect x="0" y="0" width="24" height="24"/>
          <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
          <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
      </g>
  </svg><!--end::Svg Icon--></span>
  <span class="menu-text">FAQ</span></a>

  </li>
  @endif
               @if(auth()->user()->can('View Review')||Auth::guard('admin')->user()->id==1)
      <li class="menu-item  menu-item-submenu {{ request()->is('admin/review') || request()->is('admin/review/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.review.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
         <polygon points="0 0 24 0 24 24 0 24"></polygon>
         <path d="M12,4.25932872 C12.1488635,4.25921584 12.3000368,4.29247316 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 L12,4.25932872 Z" fill="#000000" opacity="0.3"></path>
         <path d="M12,4.25932872 L12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.277344,4.464261 11.6315987,4.25960807 12,4.25932872 Z" fill="#000000"></path>
         </g>
         </svg><!--end::Svg Icon--></span>
<span class="menu-text">Reviews</span></a>

</li>
  @endif
               @if(auth()->user()->can('View PushNotification')||Auth::guard('admin')->user()->id==1)
   <li class="menu-item  menu-item-submenu {{ request()->is('admin/notification') || request()->is('admin/notification/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.notification.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><i class="fa fa-bell" style="color:#fff;"></i><!--end::Svg Icon--></span>
<span class="menu-text">Push Notification</span></a>

</li>
  @endif
               @if(auth()->user()->can('View SmsNotification')||Auth::guard('admin')->user()->id==1)
   <li class="menu-item  menu-item-submenu {{ request()->is('admin/sms-notification') || request()->is('admin/sms-notification/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.sms-notification.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><i class="fa fa-envelope" style="color:#fff;"></i><!--end::Svg Icon--></span>
<span class="menu-text">SMS Notification</span></a>

</li>
  @endif
               @if(auth()->user()->can('View UserRoles')||Auth::guard('admin')->user()->id==1)
 <li class="menu-item  menu-item-submenu {{ request()->is('admin/role') || request()->is('admin/role/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.role.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><i class="fa fa-user-cog" style="color:#fff;"></i><!--end::Svg Icon--></span>
         <span class="menu-text">User Roles & Access Permissions</span></a>
          </li>
           @endif
              
               @if(auth()->user()->can('View Feedback')||Auth::guard('admin')->user()->id==1)
        <li class="menu-item  menu-item-submenu {{ request()->is('admin/feedback') || request()->is('admin/feedback/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.feedback.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
         <rect x="0" y="0" width="24" height="24"/>
         <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"/>
         <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"/>
         </g>
         </svg><!--end::Svg Icon--></span>
         <span class="menu-text">Feedback</span></a>
         </li>
  @endif
               @if(auth()->user()->can('View Information')||Auth::guard('admin')->user()->id==1)

        <li class="menu-item  menu-item-submenu {{ request()->is('admin/information') || request()->is('admin/information/*')? 'menu-item-active ' : '' }}" aria-haspopup="true"  data-menu-toggle="hover"><a  href="{{route('admin.information.index')}}" class="menu-link menu-toggle"><span class="svg-icon menu-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><i class="fa fa-info" style="color:#fff;"></i><!--end::Svg Icon--></span>
         <span class="menu-text">Information</span></a>
         </li>



@endif




      

   

      
         </ul>
         <!--end::Menu Nav-->
   </div>
   <!--end::Menu Container-->
</div>