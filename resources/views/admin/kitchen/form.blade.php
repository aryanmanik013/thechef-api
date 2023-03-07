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
            <a href="{{route('admin.home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5></a>
            <!--end::Page Title-->
            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <!--begin::Page Title-->
            <a href="{{route('admin.kitchen.index')}}"><span class="text-muted font-weight-bold mr-4">Kitchens</span></a>
            <!--end::Page Title-->
            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4">{{ $kitchen->id ? 'Edit' : 'Add' }} Kitchen</span> 
            <!--end::Actions-->
        </div>
        <!--end::Info-->
    </div>
</div>
<!--end::Subheader-->
@endsection
@section('content')
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container ">
      <!--begin::Dashboard-->
        <!--begin::Row-->                
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">{{ $kitchen->id ? 'Edit' : 'Add' }} Kitchen </h3>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-sm btn-success font-weight-bold mr-2" id="save"><i class="flaticon2-cube"></i>Submit</a>
                    <a class="btn btn-secondary" href="{{route('admin.kitchen.index')}}" style="margin-left:5px;">Cancel</a>
                </div>
            </div>      
            <div class="card-body ">
                <!--begin: Wizard-->
                <div class="wizard wizard-4" id="kt_wizard_v4" data-wizard-state="first" data-wizard-clickable="true">
                    <!--begin: Wizard Nav-->
                    <div class="wizard-nav">
                        <div class="wizard-steps">
                            <!--begin::Wizard Step 1 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper">
                                <div class="wizard-number">1</div>
                                    <div class="wizard-label">
                                        <div class="wizard-title">General</div>
                                        <div class="wizard-desc">Create Kitchen</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                <div class="wizard-wrapper">
                                <div class="wizard-number">2</div>
                                    <div class="wizard-label">
                                        <div class="wizard-title">Address</div>
                                        <div class="wizard-desc">Contact Information</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 2 Nav-->
                            <!--begin::Wizard Step 3 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                <div class="wizard-wrapper">
                                <div class="wizard-number">3</div>
                                    <div class="wizard-label">
                                        <div class="wizard-title">Settings</div>
                                        <div class="wizard-desc">Bank Account & Others</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 3 Nav-->
                            <!--begin::Wizard Step 4 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                <div class="wizard-wrapper">
                                <div class="wizard-number">4</div>
                                    <div class="wizard-label">
                                        <div class="wizard-title">Album</div>
                                        <div class="wizard-desc">Media Files</div>
                                    </div>
                                </div>
                            </div> 
                            <!--end::Wizard Step 4 Nav-->
                        </div>
                    </div>
                    <!--end: Wizard Nav-->
                    <!--begin: Wizard Body-->
                    <div class="card card-custom card-shadowless rounded-top-0">
                        <div class="card-body p-0">
                            <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                <div class="col-xl-12">
                                <!--begin: Wizard Form-->
                                    <form class="form mt-0 mt-lg-10 fv-plugins-bootstrap fv-plugins-framework" id="kt_form" action="{{ $kitchen->id ? route('admin.kitchen.update',$kitchen->id) : route('admin.kitchen.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        {{ $kitchen->id ? method_field('PUT'):'' }}
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <div class="mb-10 font-weight-bold text-dark">Enter General Information</div>
                                            <div class="row">
                                            
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                    <label> Name <span class="text-danger">*</span> :</label>
                                                    <input  type="text" name="name"  class="form-control  form-control-lg"  value="{{ old('name', $kitchen->name) }}" >
                                                    @if($errors->has('name'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('name') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Email <span class="text-danger">*</span> :</label>
                                                  <input  type="text" name="email"  class="form-control  form-control-lg"  value="{{ old('email', $kitchen->email) }}" >
                                                   @if($errors->has('email'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('email') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Phone<span class="text-danger">*</span> :</label>
                                                  <input  type="text" name="phone"  class="form-control  form-control-lg"  value="{{ old('phone', $kitchen->phone) }}" >
                                                   @if($errors->has('phone'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('phone') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                             <div class="col-xl-6">
                                             
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Status</label>
                                                  <select class="form-control  form-control-lg" name="status" > 
                                                    <option {{ old('status',$kitchen->status)== '1' ? 'selected' : '' }} value="1"/> Enable </option>
                                                    <option {{ old('status',$kitchen->status)== '0' ? 'selected' : '' }} value="0"/>  Disable</option> 
                                                  </select>
                                                <div class="fv-plugins-message-container"></div></div> 
                                              </div>
                                              </div>
                                              @if(empty($kitchen->id))
                                              <div class="row">
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Password<span class="text-danger">{{ $kitchen->id ? '' : '*' }}</span>:</label>
                                                  <input  type="password" name="password"  class="form-control  form-control-lg" >
                                                 @if($errors->has('password'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('password') }}</div>
                                                        </div>
                                                    @endif
                                              </div>
                                              </div>
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Password Confirmation<span class="text-danger">{{ $kitchen->id ? '' : '*' }}</span>:</label>
                                                  <input  type="password" name="password_confirmation"  class="form-control  form-control-lg" >
                                                   @if($errors->has('password_confirmation'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('password_confirmation') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              </div>
                                        @endif
                                              
                                              <div class="row">
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Short Description<span class="text-danger">*</span>:</label>
                                                  <textarea max-length="50" required="required" class="form-control" id="description" name="description" placeholder="Descriptions" style="height: 250px">{{ old('description', !empty($kitchen_details->description)?$kitchen_details->getTranslation('description','en'):'') }}</textarea>
                                                  @if($errors->has('description'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('description') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>About<span class="text-danger">*</span>:</label>
                                                  <textarea max-length="50" required="required" class="form-control" id="about" name="about" placeholder="About" style="height: 250px">{{ old('about',!empty($kitchen_details->about)? $kitchen_details->getTranslation('about','en'):'') }}</textarea>
                                                  @if($errors->has('about'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('about') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                              <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Specialities<span class="text-danger">*</span>:</label>
                                                  <textarea max-length="50" required="required" class="form-control" id="specialities" name="specialities" placeholder="Specialities" style="height: 110px">{{ old('specialities',!empty($kitchen_details->specialities)? $kitchen_details->getTranslation('specialities','en'):'') }}</textarea>
                                                  @if($errors->has('specialities'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('specialities') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="col-xl-6">
                                                  <div class="row">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Additional Phone:</label>
                                                  <input  type="text" name="additional_phone"  class="form-control  form-control-lg"  value="{{ old('additional_phone', $kitchen->additional_phone) }}" >
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="checkbox checkbox-success">
                                                    <input style="margin-right:5px;" type="checkbox"  name="delivery" value="1" {{ $kitchen->delivery ==1 ? 'checked' : '' }}/>
                                                    <span style="margin-right:5px;"></span>
                                                    Deliverable Food
                                                </label>
                                                 
                                               </div>
                                               </div>
                                        @php /*    
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Contact Email<span class="text-danger">*</span>:</label>
                                                  <input  type="text" name="contact_email"  class="form-control  form-control-lg"  value="{{ old('contact_email', $kitchen->contact_email) }}" >
                                                   @if($errors->has('contact_email'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('contact_email') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                             
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Notification Email<span class="text-danger">*</span>:</label>
                                                  <input  type="text" name="notification_email"  class="form-control  form-control-lg"  value="{{ old('notification_email', $kitchen->notification_email) }}" >
                                                   @if($errors->has('notification_email'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('notification_email') }}</div>
                                                        </div>
                                                    @endif
                                                </div> */
                                            @endphp
                                              </div>
                                              </div>
                                              </div>
                                               <div class="row">
                              <!--                  <div class="col-xl-6">
                              <div class="form-group">
                           <label style="float:left;margin: 7px 10px 0 0;">Status:</label>
                     <span class="switch switch-outline switch-icon switch-success" style="float:left;">
                     <label>
                     <input type="checkbox" {{ $kitchen->status ==1 ? 'checked' : '' }} name="select" id="check" />
                     <span><span>
                     <input type="hidden" name="status" id="val" value="@if($kitchen->id){{ old('status', $kitchen->status) }} @else 0 @endif">
                     </span></span>
                     </label>
                     </span>
                  
                     </div>
                     </div>-->
                        
                   </div>
                  
                                              
                                              
                                              
                                              
                                            </div>
                                          <!--end: Wizard Step 1-->
                                        <!--begin: Wizard Step 2-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                          <div class="mb-10 font-weight-bold text-dark">Add Contact Information </div>
                                            <div class="row">
                                                  <div class="col-xl-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Location Map:</label>
                                                  <div class="input-group">
                                                    <input type="text" class="form-control " style="position:relative;" name="pac-input" id="pac-input">
                                                    <div class="input-group-append">
                                                      <span class="input-group-text"><i class="la la-search"></i></span>
                                                    </div>
                                                  </div>
                                                  <div id="map" style="width:100%;height:650px;"></div>
                                                  <input type="hidden" name="latitude" id="lat-span" value="{{ old('latitude', $kitchen->latitude) }}">
                                                  <input type="hidden" name="longitude" id="lon-span" value="{{ old('longitude', $kitchen->longitude) }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              <div class="col-xl-6">
                                                   <div class="row">
                                                         <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Address Line 1<span class="text-danger">*</span>:</label>
                                                  <input type="text" name="address_line_1" id="address_line_1" class="form-control" placeholder="Enter your address" value="{{ old('address_line_1', $kitchen->address_line_1) }}">
                                                  @if($errors->has('address_line_1'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('address_line_1') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Address Line 2:</label>
                                                  <input type="text" name="address_line_2" id="address_line_2" class="form-control" placeholder="Enter your address" value="{{ old('address_line_2', $kitchen->address_line_2) }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                            
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Street Name:</label>
                                                   <input type="text" name="street_name" class="form-control" placeholder="Enter your street name" value="{{ old('street_name', $kitchen->street_name) }}">
                                                <div class="fv-plugins-message-container"></div>
                                              </div>
                                              </div>
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Landmark:</label>
                                                  <input type="text" name="landmark" class="form-control" placeholder="Enter your landmark" value="{{ old('landmark', $kitchen->landmark) }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Postcode<span class="text-danger">*</span>:</label>
                                                  <input type="text" name="postcode" class="form-control" placeholder="Enter your postcode"  value="{{ old('postcode', $kitchen->postcode) }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                               <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                       <label>Country<span class="text-danger">*</span>:</label>
                                                  <select name="country_id" class="form-control country" id="exampleSelect1">
                                                    <option value="">Select Country</option>
                                                    @foreach($country as $key => $value)
                                                    <option value="{{ $key }}" {{$key == old('country_id',$kitchen->country_id) ?'selected':' '}} >{{ $value }}
                                                    </option>
                                                    @endforeach
                                                  </select>
                                                  @if($errors->has('country_id'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('country_id') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                       <label>State<span class="text-danger">*</span>:</label>
                                                  <select name="state_id" class="form-control state" id="exampleSelect1">
                                                    <option value="">Select State</option>
                                                    @if($kitchen->id)

                                                    @foreach($states as $key => $value)
                                           
                                                         <option value="{{ $key }}" {{$key == old('state_id',$kitchen->state_id) ?'selected':' '}} >{{ $value }}
                                                    </option>


                                                    @endforeach

                                                    @endif
                                            
                                                  </select>
                                                  @if($errors->has('state_id'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('state_id') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                            
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>City<span class="text-danger">*</span>:</label>
                                                  <input type="text" name="city" id="city" class="form-control" placeholder="Enter city" value="{{ old('city', $kitchen->city) }}">
                                                  @if($errors->has('city'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('city') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              </div>
                                              </div>
                                            </div>
                                        </div>
                                          <!--end: Wizard Step 2-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                            <div class="mb-10 font-weight-bold text-dark">Enter Payment Information</div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                  <div class="form-group fv-plugins-icon-container">
                                                  <label> Bank Name:</label>
                                                  <input  type="text" name="bank_name"  class="form-control  form-control-lg"  value="{{ old('bank_name', !empty($kitchen_banks)?$kitchen_banks->bank_name:'')}}" >
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                                </div>
                                        
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Branch:</label>
                                                  <input  type="text" name="branch"  class="form-control  form-control-lg"  value="{{ old('branch', !empty($kitchen_banks)?$kitchen_banks->branch:'') }}" >
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label> Payment Method:</label>
                                                  <input  type="text" name="payment_method"  class="form-control  form-control-lg"  value="{{ old('payment_method',!empty($kitchen_banks)?$kitchen_banks->payment_method:'') }}" >
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Account Number:</label>
                                                  <input  type="text" name="account_number"  class="form-control  form-control-lg" value="{{ old('account_number', !empty($kitchen_banks)?$kitchen_banks->account_number:'') }}">
                                                <div class="fv-plugins-message-container"></div>
                                              </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>IFSC:</label>
                                                  <input  type="text" name="ifsc"  class="form-control  form-control-lg" value="{{ old('ifsc', !empty($kitchen_banks)?$kitchen_banks->ifsc:'') }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>SWIFT:</label>
                                                  <input  type="text" name="swift"  class="form-control  form-control-lg" value="{{ old('swift', !empty($kitchen_banks)?$kitchen_banks->swift:'') }}">
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                    
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Payout Group<span class="text-danger">*</span>:</label>
                                                  <select name="payout_group_id" class="form-control" id="exampleSelect1">
                                                    <option value="">Select Group</option>
                                                    @foreach($payout_group as $key => $value)
                                                    <option value="{{ $key }}" {{$key == old('payout_group_id',$kitchen->payout_group_id) ?'selected':' '}} >{{ $value }}
                                                    </option>
                                                    @endforeach
                                                  </select>
                                                 @if($errors->has('payout_group_id'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('payout_group_id') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                               <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Payment Terms<span class="text-danger">*</span>:</label>
                                                  <textarea style="height: 250px" required="required" class="form-control summernote" id="payment_terms" name="payment_terms" placeholder="Payment Terms">{{ old('payment_terms', !empty($kitchen_details)?$kitchen_details->getTranslation('payment_terms','en'):'') }}</textarea>
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Delivery Policy<span class="text-danger">*</span>:</label>
                                                  <textarea style="height: 250px" required="required" class="form-control summernote" id="delivery_policy" name="delivery_policy" placeholder="Delivery Policy">{{ old('delivery_policy',!empty($kitchen_details)?$kitchen_details->getTranslation('delivery_policy','en'):'') }}</textarea> 
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                              </div>
                                            <div class="row">
                                              <div class="col-md-12">
                                             
                                              
                                              
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Order Policy<span class="text-danger">*</span>:</label>
                                                  <textarea style="height: 250px" required="required" class="form-control summernote" id="order_policy" name="order_policy" placeholder="Order Policy">{{ old('order_policy', !empty($kitchen_details)?$kitchen_details->getTranslation('order_policy','en'):'') }}</textarea>
                                                  <div class="fv-plugins-message-container"></div>
                                                </div>
                                              </div>
                                             </div>
                                              
                      
                                              
                                            </div>
                                         

                                          <div class="pb-5" data-wizard-type="step-content">
                                            <div class="mb-10 font-weight-bold text-dark">Featured (655 x 280)</div>
                                            <div class="row mb-10">
                                              
                                                <div class="col-xl-12">
                                                <div class="image-input image-input-outline" id="kitchen-image">
                                                  <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{!empty($featured)? $featured->getUrl():asset('assets/media/logos/no-image.png')}});background-size: 100% 100%;"></div>
                                                  <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image"> <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                  </label> 
                                                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                  </span> 
                                                </div> 
                                                <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span> 
                                                @if($errors->has('image'))
                                                        <div class="fv-plugins-message-container">
                                                            <div  class="fv-help-block">{{ $errors->first('image') }}</div>
                                                        </div>
                                                    @endif
                                              </div>
                                              </div>
                                             
                                             
                                            
                                                <div class="row mb-10">
                                                                     
                                                    <div class="col-lg-12">
                                                    <label>Slider (655 x 280)</label>

                                                      
                                                  <div class="input-images-1" style="padding-top: .5rem;"></div>
                                                  

                                                 </div>
               
                                            </div>
                                          
                                       
                                                <div class="row mb-10">
                                                                                       
                                                    <div class="col-lg-12">
                                                    <label>Gallery - Photos (655 x 280)</label>

                                                      
                                                  <div class="input-images-2" style="padding-top: .5rem;"></div>
                                                  

                                                 </div>
                                            
                                            </div>
                                          
                                          
                                           
                                              <div class="mb-10 font-weight-bold text-dark">Gallery - Videos<div class="float-right">
                                                                <a href="javascript:;" class="btn btn-icon btn-success add-vedio" style="padding: 10px;    height: auto;    width: auto;">
                                                                <i class="flaticon2-plus" style="font-size:10px;"></i>
                                                                </a>
                                                            </div></div>
                                                <div class="row mb-10 videos">
                                                     @if(isset($kitchen_videos))
                                                     @php $i = 0;@endphp
                                       
                                                     @foreach($kitchen_videos as $video)
                                                   @php $i++;@endphp
                                                    <div class="col-md-12  mt-5 video">
                                                        <div class="row">
                                                            <div class="col-xl-8">
                                                                <input  type="text" name="url[{{$i}}]"  class="form-control  form-control-lg" value="{{$video->url}}">
                                                            </div>
                                                            <div class="col-xl-3">
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="featured[{{$i}}]" value="1" {{$video->featured == 1 ? 'checked' : '' }}/>
                                                                <span></span>
                                                                &nbsp;&nbsp;&nbsp; Featured
                                                            </label>
                                                            </div>
                                                            <div class="col-xl-1">
                                                                <a href="javascript:;" class="btn btn-icon btn-danger remove-vedio" style="padding: 10px;    height: auto; float:right;   width: auto;float:right;">
                                                                <i class="flaticon2-cross" style="font-size:10px;"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                     @endforeach
                                                     
                                                       @endif
                                                </div>
                                            </div>

 <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary mr-2" data-wizard-type="action-prev">
                                            Previous
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success  mr-2" data-wizard-type="action-submit">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-primary mr-2" data-wizard-type="action-next">
                                            Next
                                        </button>
                                        <a class="btn btn-secondary" href="https://www.thechef.tnmos.com/admin/kitchen">Cancel</a>
                                    </div>
                                </div>

                                          </form>
                                          <!--end: Wizard Form-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Wizard Bpdy-->
        </div>
        <!--end: Wizard-->
    </div>
</div>
    </div>
    <!--end::Container-->
  </div>

@endsection

@push('styles')
 <link href="{{ asset('assets/css/image-uploader.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" />

 @endpush
@push('scripts')

<script src="{{ asset('assets/js/pages/custom/wizard/wizard-4.js?v=7.0.6') }}"></script>
 <script src="{{ asset('assets/js/image-upload.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('assets/js/bootstrap-multiselect.js') }}" type="text/javascript"></script> 
<script>
$(function() {
new KTImageInput('kitchen-image');
});
    
</script>

<script type="text/javascript">
   $(document).ready(function() {

   
   $('#check').click(function(){
   
        if ($('#check').is(":checked"))
        {
               $("#val").attr( "value", "1" );
        } 
   
        else{
   
        $("#val").attr( "value", "0" );
   
        }
       });
   
   });
</script>


<script>
       @if($kitchen->id)

          @if(!empty($kitchen->getMedia('slider')))
        let preloaded1 = [
        @foreach($kitchen->getMedia('slider') as $slider)
            {id: {{$slider->id}}, src:'{{$slider->getUrl()}}'},
           
        @endforeach
        ];


        $('.input-images-1').imageUploader({
            preloaded: preloaded1,
            imagesInputName: 'slider_images',
            preloadedInputName: 'old',
            preloadedDeleteUrl: "{{route('admin.image-kitchen-slider-delete')}}"
        });
        @else
        $('.input-images-1').imageUploader();

        @endif


        @else

        $('.input-images-1').imageUploader();

        @endif
        
        
               @if($kitchen->id)

          @if(!empty($kitchen->getMedia('gallery')))
        let preloaded = [
        @foreach($kitchen->getMedia('gallery') as $gallery)
            {id: {{$gallery->id}}, src:'{{$gallery->getUrl()}}'},
           
        @endforeach
        ];


        $('.input-images-2').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'gallery_images',
            preloadedInputName: 'old',
            preloadedDeleteUrl: "{{route('admin.image-kitchen-gallery-delete')}}"
        });
        @else
        $('.input-images-2').imageUploader();

        @endif


        @else

        $('.input-images-2').imageUploader();

        @endif
</script>
<script type="text/javascript">
  
  $(document).ready(function() {
 
   
    $( "#save" ).click(function() {

 
    $('#kt_form').submit();

   });
 
      $('.country').on('change', function(e){
    //alert();
 state={{$kitchen->state_id}}
   value=$('.country').val();
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'POST',
          data:{country_id:value},
          dataType : 'JSON', 
          url : '{{route('admin.getstates')}}',
          success: function(response){ 
           
           if(response)
            {
                console.log(response)
                $(".state").empty();
                $(".state").append('<option value="">Select</option>');
                $.each(response,function(key, value)
                {
                    if(state==key)
                    {
                        $(".state").append('<option value="' + key + '" selected>' + value + '</option>');
                    }
                    else
                    {
                        $(".state").append('<option value="' + key + '">' + value + '</option>');   
                    }
                 
                });
            }
          } 
        }); 



  });
  });
</script>


<script type="text/javascript">
      var lat='{{ $kitchen->latitude}}';
    var lng='{{ $kitchen->longitude}}';
       if(lat == '')
       {
        lat=-33.8688;
        lng=151.2195;
       }

  function initAutocomplete() {

    var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: Number(lat), lng: Number(lng)},
    zoom: 13,
    mapTypeId: 'roadmap'
        });
        
       if(lat != '' && lng != '')
       {
       var location = new google.maps.LatLng(Number(lat), Number(lng));

      }
        var input = document.getElementById('pac-input');

        var searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener('bounds_changed', function() {

          searchBox.setBounds(map.getBounds());

        });
      var markers = [];
         if(lat != '' && lng !='')
       {

      var marker = new google.maps.Marker({
        position: location,
          draggable: true,
       map: map,
       
        });
       }
     google.maps.event.addListener(marker, 'dragend', function(marker) {
        console.log(marker);
        var latLng = marker.latLng;


        $('#lat-span').val(latLng.lat());

        $('#lon-span').val(latLng.lng());

     });
   
        searchBox.addListener('places_changed', function() {

          var places = searchBox.getPlaces();

             console.log(places.geometry);

          if (places.length == 0) {

            return;

          }
          markers.forEach(function(marker) {
          marker.setMap(null);
          });

          markers = [];

          var bounds = new google.maps.LatLngBounds();

          places.forEach(function(place) {

            if (!place.geometry) {

              console.log("Returned place contains no geometry");

              return;

            }

            else{

               address=place.address_components;
               console.log('address');
               console.log(address);
             for (var i = 0; i < place.address_components.length; i++) {
                  if(place.address_components[i].types[0] == "sublocality_level_1"){
                $('#address_line_1').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'locality'){
                $('#address_line_2').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'administrative_area_level_2'){
                $('#city').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'country'){
                $('#country').val(place.address_components[i].long_name);
                
            }
             if(place.address_components[i].types[0] == '"administrative_area_level_1"'){
                $('#state').val(place.address_components[i].long_name);
            }
        }

                $('#lat-span').val(place.geometry['location'].lat());

                $('#lon-span').val(place.geometry['location'].lng());

            }

            var icon = {

              url: place.icon,

              size: new google.maps.Size(71, 71),

              origin: new google.maps.Point(0, 0),

              anchor: new google.maps.Point(17, 34),

              scaledSize: new google.maps.Size(25, 25)

            };



            // Create a marker for each place.

              var marker = new google.maps.Marker({

              map: map,

              draggable: true,

              // icon: icon,

              title: place.name,

              animation: google.maps.Animation.DROP,

              position: place.geometry.location

            });

   

     google.maps.event.addListener(marker, 'dragend', function(marker) {
        console.log(marker);
        var latLng = marker.latLng;


        $('#lat-span').val(latLng.lat());

        $('#lon-span').val(latLng.lng());

     });

     var geocoder = new google.maps.Geocoder();

      google.maps.event.addListener(map, 'click', function(event) {

  geocoder.geocode({

    'latLng': event.latLng

  }, function(results, status) {

    if (status == google.maps.GeocoderStatus.OK) {

      if (results[0]) {

        //alert(results[0].formatted_address);

      }

    }

  });

});



            if (place.geometry.viewport) {

              // Only geocodes have viewport.

              bounds.union(place.geometry.viewport);

            } else {

              bounds.extend(place.geometry.location);

            }

          });

          map.fitBounds(bounds);

        });

      }


</script>
<script>

      @if(isset($kitchen_videos))
      let i={{$kitchen_videos->count()}}
      @else
      let i=0
      @endif
     $(document).on('click','.add-vedio',function(){
       
      var html='';
        html+= '<div class="col-md-12 mt-5 video">';
        html+=  '<div class="row">';
        html+='<div class="col-xl-8">';
        html+='<input  type="text" name="url['+(i+1)+']"  class="form-control  form-control-lg" value="">';
        html+='</div>';
        html+='<div class="col-xl-3">';
        html+='<label class="checkbox">';
        html+='<input type="checkbox" name="featured['+(i+1)+']" value="1"/>';
        html+='<span></span>';
        html+='&nbsp;&nbsp;&nbsp; Featured';
        html+='</label>';
        html+='</div>';
        html+='<div class="col-xl-1">';
        html+='<a href="javascript:;" class="btn btn-icon btn-danger remove-vedio" style="padding: 10px;    height: auto;    width: auto;">';
        html+='<i class="flaticon2-cross" style="font-size:10px;"></i>';
        html+='</a>';
        html+='</div>';
        html+='</div>';
        html+='</div>';
        $('.videos').append(html);
   i++;
    });
</script>
<script>
    
     $(document).on('click','.remove-vedio',function(){
      $(this).parent().parent().parent().remove();
     i--;
    });
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoaPc2YrVLHUy7rZIj44I3EIuM4lqcZs4&libraries=places&callback=initAutocomplete"

         async defer></script>
@endpush