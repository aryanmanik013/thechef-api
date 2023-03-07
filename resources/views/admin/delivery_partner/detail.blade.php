@extends('admin.layouts.app')
@section('Title', 'Delivery Partner Details')
@section('subheader')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
   <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
         <!--begin::Page Title-->
          <a href="{{route('admin.home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
            Dashboard                            
         </h5></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">Delivery Partner Details</span>
         <!--end::Actions-->
      </div>
      <!--end::Info-->
      <!--begin::Toolbar-->
      <div class="d-flex align-items-center">
         <!-- toolbar -->
      </div>
      <!--end::Toolbar-->
   </div>
</div>
<!--end::Subheader-->
@endsection
@section('content')
<div class="container">
   <!--Begin:: Portlet-->
   <div class="row">
      <div class="col-lg-12 order-1 order-xxl-2">
         <div class="card card-custom">
            <div class="kt-portlet">
               <div class="kt-portlet__body">
                  <div class="card-body">
                     <div class="kt-widget__top">
                        <div class="kt-widget__media kt-hidden">
                           <img src="" alt="image">
                        </div>
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-bolder kt-font-light">
                           @if(!empty($delivery_partner->getMedia('profile')->first()))
               <img src="{{$delivery_partner->getMedia('profile')->first()->getUrl()}}" style="width: 100%;"/>
            @else
                           <span class="text-uppercase">{{substr($delivery_partner->name, 0, 2)}}</span>
                           @endif
                        </div>
                        <div class="kt-widget__content">
                           <div class="kt-widget__head">
                              <div class="kt-widget__user">
                                 <a href="#" class="kt-widget__username">
                                 {{$delivery_partner->name}}                     
                                 </a>
                                 <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--unified-success">Delivery Partner </span>
                              </div>
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-new-email"></i> Email :{{$delivery_partner->email}} 
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-placeholder"></i> Phone :  {{$delivery_partner->phone}} 
                           </div>
                           <div class="kt-widget__info">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--End:: Portlet-->
            <!--Begin:: Portlet-->
            <div class="card-body">
               <div class="kt-portlet__head">
                  <div class="kt-portlet__head-toolbar">
                     <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab">
                           <i class="la la-user"></i> Personal
                           </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_4" role="tab">
                                <i class="la la-home"></i> 

                                Address
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_2" role="tab">
                                <i class="flaticon-piggy-bank"></i> 

                                Bank Details/Payouts
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_3" role="tab">
                                <i class="la la-file"></i> 

                                Documents
                            </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="kt-portlet__body" style="width:100%;float:left;">
                  <div class="tab-content  kt-margin-t-20">
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
                       
                         
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body" style="width:100%;float:left;margin-top:20px;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Personal Info:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->name}}</span>
                                             </div>
                                          </div>
                                     
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Phone :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$delivery_partner->phone_prefix}} {{$delivery_partner->phone}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Email :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$delivery_partner->email}}</span>
                                             </div>
                                          </div>
                                        <div class="form-group row">
                                             <label class="col-md-4 col-form-label">ID Proof :</label>
                                             <div class="col-md-6"> 
                                                <span class="form-control-plaintext kt-font-bolder"> {{$delivery_partner->kyc_id_number ? $delivery_partner->kyc_id_number : '-'}}</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                         
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                       
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane active" id="kt_contacts_view_tab_4" role="tabpanel">
                       
                         
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body" style="width:100%;float:left;margin-top:20px;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Address:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Address Line 1 :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->address_line_1}}</span>
                                             </div>
                                          </div>
                                        <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Address Line 2 :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->address_line_2}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Landmark:</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->landmark}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label">Street Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->street_name}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label">City :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->city}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label">State :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->state_id ? $delivery_partner->state->name : ''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label">Country :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->country_id ? $delivery_partner->country->name : ''}}</span>
                                             </div>
                                          </div>
                                      
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                         
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                       
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane" id="kt_contacts_view_tab_2" role="tabpanel">


                      <div class="kt-section kt-section--first">
                                 <div class="kt-section__body" style="width:100%;float:left;margin-top:20px;">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Bank Deatils:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                          @if(!empty($delivery_partner->bank))

                                             <label class="col-md-4 col-form-label"> Bank Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->bank->bank_name}}</span>
                                             </div>

                                                <label class="col-md-4 col-form-label"> Branch :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->bank->branch}}</span>
                                             </div>

                                                  <label class="col-md-4 col-form-label">Account Number  :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->bank->account_number}}</span>
                                             </div>


                                                  <label class="col-md-4 col-form-label">IFSC  :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->bank->ifsc}}</span>
                                             </div>

                                                    <label class="col-md-4 col-form-label">Swift  :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->bank->swift}}</span>
                                             </div>


                                             @endif
                                           @if(!empty($delivery_partner->payoutGroup))

                                          <label class="col-md-4 col-form-label">Payout Group:</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$delivery_partner->payoutGroup->name}}</span>
                                             </div>
                                             @endif


                                          </div>
                                     
                                  
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                         
                           </div>





                     </div>
                     <!--End:: Tab Content-->
                     <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                     <div class="kt-form__actions">
                     </div>
                  </div>
                  <!--End:: Tab Content-->
                  
                  
                  
                  <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_3" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                   <div class="row">
                                       <div class="col-md-12">
                                  
                                            <div class="mb-10 font-weight-bold text-dark"></div>
                                                <div class="row mb-10">
                                                  
                                                    <div class="col-xl-12">
                                                    <div class="image-input image-input-outline" id="kitchen-image">
                                                      <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{!empty($delivery_partner->getMedia('proof')->first())? $delivery_partner->getMedia('proof')->first()->getUrl():asset('assets/media/logos/no-image.png')}});background-size: 100% 100%;"></div>
                                                      
                                                      </label> 
                                                      <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                      </span> 
                                                    </div> 
                                                  
                                                   
                                                  </div>
                                                  </div>
                                                   
                                                 
                   
                                                </div>
                                            </div>  
                                        
                                          
                                           
                                         
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection