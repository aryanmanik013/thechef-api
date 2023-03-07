@extends('admin.layouts.app')
@section('Title', 'Customer Details')
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
          <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <!--begin::Page Title-->
         <a href="{{route('admin.customer.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          Customers                          
         </span></a>
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">Customer Details</span>
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
                           <span class="text-uppercase">{{substr($customer->name, 0, 2)}}</span>
                        </div>
                        <div class="kt-widget__content">
                           <div class="kt-widget__head">
                              <div class="kt-widget__user">
                                 <a href="#" class="kt-widget__username">
                                 {{$customer->name}}                     
                                 </a>
                                 <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--unified-success">Customer </span>
                              </div>
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-new-email"></i> Email :{{$customer->email}} 
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-placeholder"></i> Phone : {{$customer->phone_prefix}}{{$customer->phone}}  
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
                  <div class="kt-portlet__head-toolbar" style="width:100%;margin-bottom:20px;">
                     <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab">
                           <i class="flaticon2-calendar-3"></i> Personal
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#kt_contacts_view_tab_2" role="tab">
                           <i class="flaticon2-list"></i> Addresses
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#kt_contacts_view_tab_3" role="tab">
                           <i class="flaticon2-list"></i> Orders
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="kt-portlet__body">
                  <div class="tab-content  kt-margin-t-20">
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
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
                                                <span class="form-control-plaintext kt-font-bolder">{{$customer->name}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Gender :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">@if(!empty($customer->gender_id)){{$customer->gender->name}} @else - @endif </span>  
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Phone :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$customer->phone_prefix}} {{$customer->phone}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Email :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$customer->email}}</span>
                                             </div>
                                          </div>
                                          <!--                          <div class="form-group row">-->
                                          <!--<label class="col-md-4 col-form-label">Login Type :</label>-->
                                          <!--                              <div class="col-md-6">-->
                                          <!--                                <span class="form-control-plaintext kt-font-bolder">  -  </span>-->
                                          <!--                              </div>-->
                                          <!--                          </div>-->
                                       </div>
                                       <div class="col-md-6">
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
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane" id="kt_contacts_view_tab_2" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                    <div class="row">
                                        @php $i=0; @endphp
                                        @foreach($addresses as $address)
                                        @php $i++; @endphp
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Address {{$i}}:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$address->name}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Phone :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$address->phone}} </span>  
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Address :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$address->address_line_1}}, {{$address->address_line_2}}, {{$address->landmark}}, {{$address->street_name}}, {{$address->city}}, {{$address->country_id?$address->country->name.',':''}} {{$address->state_id?$address->state->name.',':''}} {{$address->postcode}}</span>
                                             </div>
                                          </div>
                                      
                                       </div>
                                        @endforeach
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
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane" id="kt_contacts_view_tab_3" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                    <div class="row">
                                        
                                         @foreach($orders as $order)
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Order#{{$order->id}}</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Date :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{date('d-m-Y H:i', strtotime($order->created_at))}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Amount :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{number_format($order->total,2)}}</span>  
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Kitchen :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$order->kitchen->name}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Items :</label>
                                              <div class="col-md-6">
                                              @foreach($order->food as $food)
                                            
                                                <span class="form-control-plaintext kt-font-bolder"> {{$food->name}}  x  {{$food->quantity}}</span>
                                          
                                             @endforeach
                                                </div>
                                          </div>
                                         
                                       </div>
                                         @endforeach
                                       
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