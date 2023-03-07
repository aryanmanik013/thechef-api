<!--SAMAH-->
@extends('admin.layouts.app')
<!--begin::Content-->
@section('subheader')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
            <a  href="{{ route('admin.home') }}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5></a> 
            <!--end::Page Title-->
            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <a  href="{{route('admin.order.index')}}"><span class="text-muted font-weight-bold mr-4">Order</span></a> 
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4"> Order</span>
            <!--end::Actions-->
        </div>
        <!--end::Info-->
    </div>
</div>
 <!--end::Subheader-->
@endsection
@section('content')
<!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                                            <!--begin::Subheader-->


                    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Dashboard-->
<!--begin::Row-->
<div class="row">
        
   

    <div class="col-lg-12 order-1 order-xxl-2">
        
<div class="flex-column-fluid">
        <!--begin::Container-->
        <div class="  ">
    
   
        <!--begin: Wizard-->
        
            <!--begin: Wizard Nav-->
           
            <!--end: Wizard Nav-->

            <!--begin: Wizard Body-->
            
                    <div class="row">
                        <div class="col-xl-12">
                            <!--begin: Wizard Form-->
                            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--tabs">
   <div class="kt-portlet__head" style="border-bottom:none;">
      <div class="kt-portlet__head-label">
         
         <h3 class="kt-portlet__head-title">
            Order &nbsp;
         </h3>
         <span class="kt-portlet__head-icon">
         <i class="kt-font-brand flaticon2-tools-and-utensils" style="font-size: 20px;margin-top:5px;float:left;"></i>
         </span>
      </div>
      <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <!--@if($order->order_status_id!=5)
                        <a href=""  data-toggle="modal" data-target="#cancel-order" class="btn btn-close btn-icon-sm">
                    <i class="la la-close"></i>
                       Cancel
                    </a>
                    @else
                       <a href="#0"   class="btn btn-close btn-icon-sm">
                  
                       Cancelled
                    </a>
                    @endif-->
                    <a href="{{ route('admin.invoice',$order->id)}}" class="btn btn-brand btn-icon-sm">
                    <i class="la la-eye"></i>
                       Invoice
                    </a>
                   
                                    </div>
    </div>
   </div>
   
</div>
<!--Begin:: Portlet-->
<div class="kt-portlet kt-portlet--tabs">
   <div class="kt-portlet__head">
      <div class="kt-portlet__head-toolbar">
         <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab" aria-selected="true">
               <i class="flaticon2-calendar-3"></i> Order Info
               </a>
            </li>
            @if($order->payment_method!='COD')
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#kt_contacts_view_tab_3" role="tab" aria-selected="false">
               <i class="flaticon-piggy-bank"></i> Payment Info
               </a>
            </li>
            @endif
             

            
         </ul>
         
         
      </div>
      <div class="row" style="margin-top: 18px; width: 45%;">
          <div class="row col-md-6">
                 <label  style="font-weight :500;font-size:13px;text-align:right">Status : </label>
               <span class="col-md-8"><span class="kt-badge kt-badge--info kt-badge--inline ">{{$order->status?$order->status->name:'Pending' }}</span></span>    
             </div>
              <div class="row col-md-5">
                 <label style="font-weight :500;font-size:13px;text-align:right">Payment : </label>
               <span class="col-md-4"><span class="kt-badge kt-badge--success kt-badge--inline ">{{$order->payment_method }}</span></span>    
             </div>
      </div>
             
   </div>
   <div class="kt-portlet__body">
      <div class="tab-content  kt-margin-t-20">
         <!--Begin:: Tab Content-->
         <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
            <div class="kt-form__body">
               <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon2-calendar-3"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">ORDER DETAILS </h3>
                                 </div>
                                 
                              </div>
                              
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <label class="col-md-4 col-form-label"> Order Number : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder"> {{$order->invoice_prefix.$order->id }}</span>
                                    </div>
                                 </div>
                                <div class="row">
                                    <label class="col-md-4 col-form-label">Order Type : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder" style="color:#13940b">
                                        @if($order->delivery_type==0)
                                            Take Away
                                        @elseif($order->delivery_type==1)
                                            Delivery
                                        @else
                                            Delivery Partner
                                        @endif
                                       </span>
                                    </div>
                                 </div> 
                                 @if($canceled_history)
                                 <div class="row">
                                    <label class="col-md-4 col-form-label">Cancellation Reason: </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder" style="color:#496027"> <span>{{$canceled_history->comment}} </span></span>                                       
                                    </div>
                                 </div>
                                @endif
                                 
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon-users"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">CUSTOMER DETAILS </h3>
                                 </div>
                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <label class="col-md-4 col-form-label"> Customer Name : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder">{{ $order->name}}</span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-4 col-form-label">Email : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder">{{ $order->email}} </span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-4 col-form-label">Contact Number  : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder"> {{ $order->phone}} </span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon-time"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">Delivery Partner </h3>
                                 </div>
                             <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                             
                                 </div>
                                
                              </div>

                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Name : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{$order->delivery_partner_id ?  $order->deliveryPartner->name : '-'}}</span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Phone : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{ !empty($order->delivery_partner_id) ? $order->deliveryPartner->phone : '-' }}</span>
                                    </div>
                                 </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Email : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{ !empty($order->delivery_partner_id) ? $order->deliveryPartner->email : '-' }}</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                         <div class="col-md-6">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon-time"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">Delivery Address </h3>
                                 </div>
                             <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                
                                 </div>
                                
                              </div>

                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Name : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{ $order->shipping_name}}</span>
                                    </div>
                                 </div>
                         
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Address : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder"> {{ $order->shipping_name}}<br>{{ $order->shipping_address_1}},{{ $order->shipping_address_2}} <br>
                                            {{ !empty($order->shipping_city)?$order->shipping_city.',':''}}{{ !empty($order->shipping_landmark)?$order->shipping_landmark.',':''}}<br>
                                                 {{(!empty($order->shipping_state_id)) ? $order->state->name.',' : ''}} {{(!empty($order->shipping_country_id)) ? $order->country->name : ''}} {{ (!empty($order->shipping_postcode)) ? '-'.$order->shipping_postcode :''}}
                                          <br>  </span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Phone : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{ !empty($order->shipping_phone) ? $order->shipping_phone : $order->phone }}</span>
                                    </div>
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <div class="row">
                        <div class="col-md-12">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon-time"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">kitchen Details </h3>
                                 </div>
                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Name : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{$order->kitchen->name}}</span>
                                    </div>
                                 </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Description : </label>
                                    <div class="col-md-9">
                               
                                    
                                       <span class="form-control-plaintext kt-font-bolder">
                                       {{$order->kitchen->description}}
                                        </span>

                                   
                                
                                    </div>
                                 </div>
                         
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Address : </label>
                                    <div class="col-md-9">
                                        <span class="form-control-plaintext kt-font-bolder"> {{ $order->kitchen->name}}<br>{{ $order->kitchen->address_line_1}},{{ $order->kitchen->address_line_2}} <br>
                                            {{ !empty($order->kitchen->city)?$order->kitchen->city.',':''}}{{ !empty($order->kitchen->landmark)?$order->kitchen->landmark.',':''}}<br>
                                                 {{(!empty($order->kitchen->state_id)) ? $order->kitchen->state->name.',' : ''}} {{(!empty($order->kitchen->country_id)) ? $order->kitchen->country->name : ''}} {{ (!empty($order->kitchen->postcode)) ? '-'.$order->kitchen->postcode :''}}
                                          <br>  </span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-3 col-form-label">Phone : </label>
                                    <div class="col-md-9">
                                       <span class="form-control-plaintext kt-font-bolder">{{$order->kitchen->phone}}</span>
                                    </div>
                                 </div>


                                <div class="row">
                              
                                    <div class="col-md-12">
                                       <a href="#" data-toggle="modal" data-target="#location_modal"><span class="form-control-plaintext kt-font-bolder">View Location</span></a>
                                    </div>
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                        

                    </div>

           
                     <div class="row">
                        <div class="col-md-12">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon2-protection"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">Item Details </h3>
                                 </div>
                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <table class="table table-bordered " style="width:100%">
                                          <thead class="thead-light">
                                             <tr>
                                                <th width="20" style="font-weight:bold">Product</th>
                                                <th width="20" style="font-weight:bold">Quantity</th>
                                                <th width="20" style="font-weight:bold">Unit Price</th>
                                                 <th width="20" style="font-weight:bold">Total</th>
                                                <th width="20" style="font-weight:bold">Note</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($foods as $food)
                                             <tr>
                                                      
                                        <td><p>{{$food->name}}</p>
                                     
                                          </td>
                                        
                                          <td><p>{{$food->quantity}}</p></td>
                                          <td><p>{{number_format($food->price,2)}}</p></td>
                                         
                                          <td><p>{{number_format($food->total,2)}}</p></td>
                                           <td><p>{{$food->note}}</p></td>
                                                </tr>
                                                @endforeach
                                        </tbody>
                                       </table>
                                    </div>
                                 </div>






                                 <div class="row" style="margin-top: 40px;">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4">
                                       <div class="kt-portlet" style="background-color: #ebedf2;">
                                          <div class="kt-portlet__head kt-portlet__head--right kt-portlet__head--noborder  kt-ribbon kt-ribbon--clip kt-ribbon--left kt-ribbon--info">

                                                <span class="kt-ribbon__inner">Price</span>
                                          
                                             <div class="kt-portlet__head-label">
                                             </div>
                                          </div>
                                          <div class="kt-portlet__body kt-portlet__body--fit-top">

                                            @foreach($ordertotal as $total)
                                   <div class="row">
                                                <label class="col-md-6 col-form-label" style="font-weight:bold">{{$total->title}} : </label>
                                                <div class="col-md-6">
                                                    <span class="form-control-plaintext kt-font-bold">{{$order->country->currency_code}}.{{number_format($total->value,2)}}</span>
                                                </div>
                                             </div>
                                        
                                    @endforeach
                                                                                            
                                        
                                                                                          
                                     
                                             
                                            </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                    <i class="flaticon2-protection"></i>
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">Order History </h3>
                                 </div>
                                 <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                       <button type="button" class="btn btn-success btn-icon-sm" style="margin-bottom: 10px" data-toggle="modal" data-target="#history-modal"><i class="la la-plus"></i>Add Order History</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="kt-portlet__body">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <table class="table table-bordered">
                                          <thead class="thead-light">
                                             <tr>
                                                <th style="font-weight:bold">Date Added</th>
                                                <th style="font-weight:bold">Comment</th>
                                                <th style="font-weight:bold">Status</th>
                                                <th style="font-weight:bold">Customer Notified</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                @foreach($histories as $history)
                                          <tr>
                                        <td><p>{{ Carbon\Carbon::parse($history->created_at)->format('d-m-Y') }}</p></td>
                                        <td><p>{{ $history->comment }}</p></td>
                                        <td><p>{{ $history->status->name }}</p></td>
                                        <td><p>{{ $history->notify_sms==1 ?'SMS Notification:YES' :'SMS Notification:NO' }}</p>
                                          <p>{{ $history->notify_push==1 ? 'push Notification: YES' :'push Notification: NO' }}</p>
                                          <p>{{ $history->notify_email==1 ? 'Email Notification: YES' :'Email Notification: NO' }}</p>


                                        </td>
                                    </tr>
                                    @endforeach
                                            </tr>
                                              
                                    </tbody>
                                       </table>
                                    </div>
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
         </div>
         <!--End:: Tab Content-->
         <!--Begin:: Tab Content-->
         <div class="tab-pane" id="kt_contacts_view_tab_3" role="tabpanel">
            <div class="kt-form__body">
               <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="kt-portlet" style="border: 1px solid #1212b530;">
                              <div class="kt-portlet__head">
                                 <div class="kt-portlet__head-label">
                                  
                                    &nbsp;&nbsp;
                                    <h3 class="kt-portlet__head-title">Payment Details </h3>
                                 </div>
                              </div>
                              <div class="kt-portlet__body">
                                  <div class="row">
                                    <label class="col-md-4 col-form-label"> Method : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder"> <span style="width: 112px;"><span class="kt-badge  kt-badge--success ">{{$order->payment_method }}</span></span> </span>
                                    </div>
                                 </div>
                                 <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                                                                    <div class="row">
                                    <label class="col-md-4 col-form-label"> Status : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder"> <span style="width: 112px;"><span class="kt-badge  kt-badge--success ">{{$order->status?$order->status->name:'Pending' }}</span></span> </span>
                                    </div>
                                 </div>
                                  <div class="row">
                                    <label class="col-md-4 col-form-label"> Name : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder">{{$order->name}}</span>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <label class="col-md-4 col-form-label"> Phone Number : </label>
                                    <div class="col-md-8">
                                       <span class="form-control-plaintext kt-font-bolder">{{$order->phone}} </span>
                                    </div>
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
         </div>
         <!--End:: Tab Content-->

   </div>
</div>
<div class="modal fade" id="cancel-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="">Cancel Order</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                </button>

            </div>

            <div class="modal-body">

                
                                  <p>Are you sure to cancel the order?</p> 

            </div>

            <div class="modal-footer">
             <button type="button" class="btn btn-success btn_cancel_order "><i class="flaticon-like"></i>Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="history-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Order History</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
         </div>
         <div class="modal-body">
            <form id="orderhistory" action="{{route('admin.history.store')}}" method="POST">
                <input type="hidden" name="order_id" value="{{$order->id}}">
               <div class="kt-scroll ps" data-scroll="true" style="height: 300px; overflow: hidden;">
                  <!--Products -->
                  <div class="kt-portlet">
                     <div class="kt-portlet__body" kt-hidden-height="300" style="">
                        <div class="kt-portlet__content">
                           <div class="form-group row">
                              <div class="col-lg-3">
                                 <label> Order Status :<span class="required" style="color:red">*</span></label>
                              </div>
                              <div class="col-lg-9">
                                 <select class="form-control" id="order_status" name="order_status_id" required="">
                                    <option value="">Select</option>
                                       @foreach($statuses as $status)
                                                <option value="{{ $status->id}}">{{ $status->name }}</option>
                                                @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row " id="reason" style="display:none">
                              <div class="col-lg-3">
                                 <label> Cancellation Reason :<span class="required" style="color:red">*</span></label>
                              </div>
                              <div class="col-lg-9">
                                 <select class="form-control" name="reason_id">
                                    <option value="">Select</option>
                                   <option value="1">Unable to process</option>
                                   <option value="2">Placed by Mistake</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-lg-3" style="margin-top: 4px;">
                                 <label>Notify :</label>
                              </div>
                              <div class="col-lg-2">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_sms" id="notify_sms" value="1"> SMS
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_email" id="notify_email" value="1"> Email
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_push" id="notify_push" value="1">Push Notification
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-lg-3">
                                 <label>Comment :</label>
                              </div>
                              <div class="col-lg-9">
                                 <textarea class="form-control" name="comment"></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Products -->
               <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
            
       </div>
         <div class="modal-footer">
            <button class="btn btn-success" id="success" type="submit"><i class="flaticon-plus"></i> Save</button>
            <button class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i> Cancel</button>
         </div>
           </form>
         
      </div>
   </div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal2">Delivery Partner Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                
                                       <div class="kt-portlet" style="border: 1px solid #1212b530;">
                                          
                                          <div class="kt-portlet__body">
                                             <div class="row">
                                                <label class="col-md-3 col-form-label">Name : </label>
                                                <div class="col-md-9">
                                                   <span class="form-control-plaintext kt-font-bolder">riya</span>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <label class="col-md-3 col-form-label">Assign Time : </label>
                                                <div class="col-md-9">
                                                   <span class="form-control-plaintext kt-font-bolder">03-09-2020 05:15 AM</span>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <label class="col-md-3 col-form-label">Phone : </label>
                                                <div class="col-md-9">
                                                   <span class="form-control-plaintext kt-font-bolder">9190909890</span>
                                                </div>
                                             </div>
                                              <div class="row">
                                                <label class="col-md-3 col-form-label">Email : </label>
                                                <div class="col-md-9">
                                                   <span class="form-control-plaintext kt-font-bolder">riya@gmail.com</span>
                                                </div>
                                             </div>
                                             
                                          </div>
                                       </div>
                   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal">Close</button>
        
                                    </div>
                                </div>
                            </div>
                        </div>

        <div class="modal fade" id="location_modal" tabindex="-1" role="dialog" aria-labelledby="modal2" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Kitchen Location</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                
                                       <div class="kt-portlet" style="border: 1px solid #1212b530;">
                                          
                                          <div class="kt-portlet__body">
                                          <div id="map" style="width:100%;height:300px;"></div>
                                             
                                          </div>
                                       </div>
                   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal">Close</button>
        
                                    </div>
                                </div>
                            </div>
                        </div>







<div class="modal fade" id="delivery_assign_notify" tabindex="-1" role="dialog"  aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

         <div class="modal-body">
            <form id="order_assign" action="" method="POST">
                <input type="hidden" name="order_id" value="{{$order->id}}">
               <div class="kt-scroll ps" data-scroll="true" style="overflow: hidden;">
                  <!--Products -->
                  <div class="kt-portlet">
                     <div class="kt-portlet__body" kt-hidden-height="300" style="">
                        <div class="kt-portlet__content">
  
              
                           <div class="form-group row">
                              <div class="col-lg-3" style="margin-top: 4px;">
                                 <label>Notify :</label>
                              </div>
                              <div class="col-lg-2">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_sms" id="notify_sms" value="1"> SMS
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_email" id="notify_email" value="1"> Email
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4">
                                 <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                    <input type="checkbox" name="notify_push" id="notify_push" value="1">Push Notification
                                    <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-lg-3">
                                 <label>Comment :</label>
                              </div>
                              <div class="col-lg-9">
                                 <textarea class="form-control" name="comment"></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Products -->
          
            
       </div>
         <div class="modal-footer">
            <button class="btn btn-success" id="success" type="submit"><i class="flaticon-plus"></i>Assign</button>
            <button class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i> Cancel</button>
         </div>
           </form>
         
      </div>
   </div>
</div>



@endsection

@push('scripts')
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoaPc2YrVLHUy7rZIj44I3EIuM4lqcZs4&callback=initMap"

         async defer></script>
<script type="text/javascript">

var lat=parseFloat('{{ $order->kitchen->latitude}}');
var lng=parseFloat('{{ $order->kitchen->longitude}}');


if(lat == '')
{
    lat=-33.8688;
    lng=151.2195;
}

// Initialize and add the map
function initMap() {

  var location = {lat:lat, lng: lng};
  console.log(location);
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 7, center: location});

  var marker = new google.maps.Marker({position: location, map: map});
}
    

  $('#orderhistory').on('submit', function(e){
    e.preventDefault();
    $this = $(this);
 
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
        type: 'POST',
        dataType: 'JSON',
        data: $this.serialize(),
        url : '{{route('admin.updateStatus')}}',
        success: function(response){   
          
            $('#history-modal').hide();
                Swal.fire({
                        text: "Order History Added Succesfully",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    })
               setTimeout(function()
              {
                 location.reload()
              },2000);
          
        },
        error: function(response) {
          
          $('#history-modal').hide();
                Swal.fire({
                        text: "Something Went wrong",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    })
               setTimeout(function() {
             location.reload()
              },2000);
         
        }
    }); 
});

var order_id='{{$order->id}}';
        $(document).on('click','.btn_cancel_order',function(){
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'GET',
			          data:{order_id:order_id,order_status_id:5},
			          dataType : 'JSON', 
			         url : '{{ route('admin.order_cancel') }}',
			          success: function(response){ 
			              console.log(response.status);
			              if(response=='success')
			              {
				               $('#cancel-order').modal('hide');
				          
				               toastr.success("Order Cancelled", "Success"); 
				                  location.reload();
			              }
			              else if(response=='fail')
			              {
				               $('#cancel-order').modal('hide');
				             
				                toastr.warning("Something Went Worng", "Warning");   
			              }
			          } 
		        }); 



   		 });
    
</script>

@endpush
