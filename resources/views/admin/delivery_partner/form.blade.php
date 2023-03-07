@extends('admin.layouts.app')


<!--begin::Content-->

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

                <a href="{{route('admin.delivery-partner.index')}}"><span class="text-muted font-weight-bold mr-4"> Delivery Partner </span> </a>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

                <span class="text-muted font-weight-bold mr-4"> {{  $delivery_partner->id ? 'Edit' : 'Add' }} Delivery Partner </span> 

           
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

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
          
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
            <h3 class="card-title"> Delivery Partners </h3>
               <div class="card-toolbar">
                   <div>
                                        <button type="submit" class="btn btn-success mr-2" id="save" data-wizard-type="action-submit">
                                            Submit
                                        </button>
                                      
                                        <a class="btn btn-secondary" href="{{route('admin.delivery-partner.index')}}">Cancel</a>
                                    </div>
                            </div> 
            </div>
            <!--begin::Form-->
                  

        <div class="card-body">


                                <!--begin: Wizard-->
        <div class="wizard wizard-4" id="kt_wizard_v4" data-wizard-state="first" data-wizard-clickable="true">
            <!--begin: Wizard Nav-->
            <div class="wizard-nav">
                <div class="wizard-steps">
                    <!--begin::Wizard Step 1 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">
                                1
                            </div>
                            <div class="wizard-label">
                                <div class="wizard-title">
                                    Basic  Details
                                </div>
                                <div class="wizard-desc">
                                    Setup Basic  Details
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Wizard Step 1 Nav-->

                    <!--begin::Wizard Step 2 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">
                                2
                            </div>
                            <div class="wizard-label">
                                <div class="wizard-title">
                                    Bank Details 
                                </div>
                                <div class="wizard-desc">
                                    Setup bank details and payout 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Wizard Step 2 Nav-->

                    <!--begin::Wizard Step 3 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">
                                3
                            </div>
                            <div class="wizard-label">
                                <div class="wizard-title">
                                    Documents and Images
                                </div>
                                <div class="wizard-desc">
                                    Add Documents
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Wizard Step 3 Nav-->

                    <!--begin::Wizard Step 4 Nav-->
             <!--        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">
                                4
                            </div>
                            <div class="wizard-label">
                                <div class="wizard-title">
                                    Completed
                                </div>
                                <div class="wizard-desc">
                                    Review and Submit
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                             <form class="form" id="kt_form"  action="{{ $delivery_partner->id ? route('admin.delivery-partner.update',$delivery_partner->id) : route('admin.delivery-partner.store') }}" method="POST"   enctype="multipart/form-data">
                               @csrf
                               {{ $delivery_partner->id ? method_field('PUT') : '' }}
                                                    <!--begin: Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    
                                <div class="row">

                                     <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                            <label>Name<span class="text-danger">*</span> :</label>
                                            
                                        <input  maxlength="100" type="text" placeholder="Name" id="name" name="name" value="{{ old('name', $delivery_partner->name) }}" required="required" class="form-control" />
                                            @if($errors->has('name'))


                                            <div class="fv-plugins-message-container">
                                                    <div  class="fv-help-block">{{ $errors->first('name') }}</div>
                                                    </div>
                                                    
                                            @endif
                                          
                                        </div>
                                        </div>

                                            <div class="col-lg-6">
                                              <div class="form-group fv-plugins-icon-container">
                                              <label>Email<span class="text-danger">*</span> :</label>
                                              
                                          <input  maxlength="100" type="text" placeholder="Email" id="" name="email" value="{{ old('name', $delivery_partner->email) }}" required="required" class="form-control" />
                                              @if($errors->has('email'))

                                               <div class="fv-plugins-message-container">
                                                      <div  class="fv-help-block">{{ $errors->first('email') }}</div>
                                                      </div>
                                                      
                                              @endif
                                          </div>
                                      </div>
                                   </div>
                                     <div class="row">
                                        <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                          <label>Phone<span class="text-danger">*</span> :</label>
                                        <input  type="text" name="phone" placeholder="Phone"  class="form-control  form-control-lg"  value="{{ old('phone', $delivery_partner->phone) }}" >
                                          @if($errors->has('phone'))
                                           <div class="fv-plugins-message-container">
                                          <div  class="fv-help-block">{{ $errors->first('phone') }}</div>
                                          </div>
                                                  
                                          @endif
                                        </div>
                                     </div>
                                   <div class="col-lg-6">
                                       <div class="form-group fv-plugins-icon-container">
                                      <label>ID proof number <span class="text-danger">*</span> :</label>
                                       <input  type="text" name="kyc_id_number" placeholder="ID proof number"  class="form-control  form-control-lg"  value="{{ old('kyc_id_number', $delivery_partner->kyc_id_number) }}" >
                                       @if($errors->has('kyc_id_number'))
                                           <div class="fv-plugins-message-container">
                                              <div  class="fv-help-block">{{ $errors->first('kyc_id_number') }}</div>
                                            </div>
                                        @endif

                                          </div>

                                        </div>
                                     </div>

                               <div class="row">
                                <div class="col-lg-6">
                                   <div class="form-group fv-plugins-icon-container">

                                     <label>Status:</label>
                                  <span class="switch switch-outline switch-icon switch-success">

                                      <label>

                                      <input type="checkbox" {{ $delivery_partner->status ==1 ? 'checked' : '' }} name="checkbox" id="check" value="0" >

                                      <input type="hidden" name="status" id="val" value="@if($delivery_partner->id){{ old('status', $delivery_partner->status) }} @else 0 @endif">

                                      <span></span>

                                      </label>

                                      </span>   

                                           @if($errors->has('status'))
                                            <div class="fv-plugins-message-container">
                                               <div  class="fv-help-block">{{ $errors->first('status') }}
                                               </div>
                                              </div>
                                              @endif
                                     </div> 

                                   </div> 
                                              
                                    </div>
                                   <div class="row">

                                     <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                            <label>Address Line 1<span class="text-danger">*</span> :</label>
                                            
                                        <input type="text" placeholder="Address Line 1" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $delivery_partner->address_line_1) }}" class="form-control" />
                                            @if($errors->has('address_line_1'))


                                            <div class="fv-plugins-message-container">
                                                    <div  class="fv-help-block">{{ $errors->first('address_line_1') }}</div>
                                                    </div>
                                                    
                                            @endif
                                          
                                        </div>
                                        </div>

                                            <div class="col-lg-6">
                                              <div class="form-group fv-plugins-icon-container">
                                              <label>Address Line 2<span class="text-danger">*</span> :</label>
                                              
                                          <input  type="text" placeholder="Address Line 2" id="" name="address_line_2" value="{{ old('address_line_2', $delivery_partner->address_line_2) }}" class="form-control" />
                                              @if($errors->has('address_line_2'))

                                               <div class="fv-plugins-message-container">
                                                      <div  class="fv-help-block">{{ $errors->first('address_line_2') }}</div>
                                                      </div>
                                                      
                                              @endif
                                          </div>
                                      </div>
                                   </div>
                                   <div class="row">

                                     <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                            <label>Landmark<span class="text-danger">*</span> :</label>
                                            
                                        <input type="text" placeholder="Landmark" id="landmark" name="landmark" value="{{ old('landmark', $delivery_partner->landmark) }}" class="form-control" />
                                            @if($errors->has('landmark'))


                                            <div class="fv-plugins-message-container">
                                                    <div  class="fv-help-block">{{ $errors->first('landmark') }}</div>
                                                    </div>
                                                    
                                            @endif
                                          
                                        </div>
                                        </div>

                                            <div class="col-lg-6">
                                              <div class="form-group fv-plugins-icon-container">
                                              <label>Street Name<span class="text-danger">*</span> :</label>
                                              
                                          <input  type="text" placeholder="Street Name" id="" name="street_name" value="{{ old('street_name', $delivery_partner->street_name) }}" class="form-control" />
                                              @if($errors->has('street_name'))

                                               <div class="fv-plugins-message-container">
                                                      <div  class="fv-help-block">{{ $errors->first('street_name') }}</div>
                                                      </div>
                                                      
                                              @endif
                                          </div>
                                      </div>
                                   </div>
                                   <div class="row">

                                     <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                            <label>City<span class="text-danger">*</span> :</label>
                                            
                                        <input type="text" placeholder="City" id="city" name="city" value="{{ old('city', $delivery_partner->city) }}" class="form-control" />
                                            @if($errors->has('city'))


                                            <div class="fv-plugins-message-container">
                                                    <div  class="fv-help-block">{{ $errors->first('city') }}</div>
                                                    </div>
                                                    
                                            @endif
                                          
                                        </div>
                                        </div>

                                            <div class="col-lg-6">
                                              <div class="form-group fv-plugins-icon-container">
                                              <label>Country<span class="text-danger">*</span> :</label>
                                              <select name="country_id" class="form-control country" id="exampleSelect1">
                                                    <option value="">Select Country</option>
                                                    @foreach($country as $key => $value)
                                                    <option value="{{ $key }}" {{$key == old('country_id',$delivery_partner->country_id) ?'selected':' '}} >{{ $value }}
                                                    </option>
                                                    @endforeach
                                                  </select>
                                          
                                              @if($errors->has('address_line_2'))

                                               <div class="fv-plugins-message-container">
                                                      <div  class="fv-help-block">{{ $errors->first('address_line_2') }}</div>
                                                      </div>
                                                      
                                              @endif
                                          </div>
                                      </div>
                                   </div>
                                   <div class="row">

                                     <div class="col-lg-6">
                                          <div class="form-group fv-plugins-icon-container">
                                            <label>State<span class="text-danger">*</span> :</label>
                                            <select name="state_id" class="form-control state" id="exampleSelect1">
                                                    <option value="">Select State</option>
                                                    @if($delivery_partner->id)
                                                        @foreach($states as $key => $value)
                                                        <option value="{{ $key }}" {{$key == old('state_id',$delivery_partner->state_id) ?'selected':' '}} >{{ $value }}
                                                        </option>
                                                        @endforeach

                                                    @endif
                                            
                                                  </select>
                                        
                                            @if($errors->has('address_line_1'))


                                            <div class="fv-plugins-message-container">
                                                    <div  class="fv-help-block">{{ $errors->first('address_line_1') }}</div>
                                                    </div>
                                                    
                                            @endif
                                          
                                        </div>
                                        </div>

                                   </div>
                                </div>
                                <!--end: Wizard Step 1-->




                                <!--begin: Wizard Step 2-->
                          <div class="pb-5" data-wizard-type="step-content">

                          @if($delivery_partner->id)
                              @if(!empty($delivery_partner->bank))
                                    <div class="repeter-container"  style="width: 100%">
                             
                                         <div class="col-md-6 form-group "  id="payment-select-0" style="padding-left: 0px">
                                                <label>Payment Type <span class="text-danger">*</span>:</label>
                                                <select class="form-control" name="delivery_partner_bank[0][payment_method]" onchange="showPaymentForm(this,'0')" >
                                                  

                                                  <option {{$delivery_partner->bank->payment_method==1?'selected':''}} value="1">Bank</option>
                                                </select>
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                      <div class="form-group row align-items-center" id="bank-0" style="width: 100%; {{$delivery_partner->bank->payment_method==2?'display:none':''}}" >
                                     

                                            <div class="col-md-6 form-group ">
                                                <label>Bank Name <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][bank_name]" class="form-control"  placeholder="Name" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->bank_name) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Branch <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][branch]" class="form-control" placeholder="Branch" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->branch) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Account No <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][account_number]" class="form-control" placeholder="Account No" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->account_number) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                              <div class="col-md-6 form-group">
                                                <label>IFSC <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][ifsc]" class="form-control" placeholder="Ifsc" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->ifsc) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>


                                              <div class="col-md-6 form-group">
                                                <label>Swift :</label>
                                                <input type="text" name="delivery_partner_bank[0][swift]" class="form-control" placeholder="Swift" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->swift) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                         
                                         </div> 

                                         <div class="form-group row align-items-center" id="online-0" style="display:none">

                                             <div class="col-md-6 form-group">
                                                <label>Email :</label>
                                                <input type="text" class="form-control" name="delivery_partner_bank[0][email]" placeholder="Email" value="{{ old('delivery_partner_bank[0][bank_name]', $delivery_partner->bank->email) }}">
                                                <div class="d-md-none mb-2"></div>
                                            </div>


                                         </div>


                                    
                                     <!--        <div class="col-md-12 form-group">
                                                <button type="button" onclick="removeAccount(this,0)" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger float-right">
                                                <i class="la la-trash-o"></i>Delete</button>
                                            </div> -->
                                                        
<!-- 
                                    <div class="form-group row">
                                       
                                        <div class="col-lg-12">
                                            <button type="button" onclick="NewAccount(this,0);" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary float-right">
                                            <i class="la la-plus"></i>Add</button>
                                        </div>
                                    </div> -->
                        
                                 </div>


                              @endif

                           @else
                                 
                                   
                                        
                                    <div class="repeter-container" id="repeter-0" style="width: 100%">
                                   
                                         <div class="col-md-6 form-group "  id="payment-select-0" style="padding-left: 0px">
                                                <label>Payment Type <span class="text-danger">*</span>:</label>
                                                <select class="form-control" name="delivery_partner_bank[0][payment_method]" onchange="showPaymentForm(this,'0')" >
                                                  

                                                  <option value="1">Bank</option>
                                                 
                                                </select>
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                      <div class="form-group row align-items-center" id="bank-0" style="width: 100%" >

                                            <div class="col-md-6 form-group ">
                                                <label>Bank Name <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][bank_name]" class="form-control"  placeholder="Name" >
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Branch <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][branch]" class="form-control" placeholder="Branch">
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Account No <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][account_number]" class="form-control" placeholder="Account No">
                                                <div class="d-md-none mb-2"></div>
                                            </div>

                                              <div class="col-md-6 form-group">
                                                <label>IFSC <span class="text-danger">*</span>:</label>
                                                <input type="text" name="delivery_partner_bank[0][ifsc]" class="form-control" placeholder="Ifsc">
                                                <div class="d-md-none mb-2"></div>
                                            </div>


                                              <div class="col-md-6 form-group">
                                                <label>Swift :</label>
                                                <input type="text" name="delivery_partner_bank[0][swift]" class="form-control" placeholder="Swift">
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                      <!--        <div class="col-md-6 form-group">
                                                <label>Default :</label>
                                                <input type="radio" name="delivery_partner_bank[0][default]"  placeholder="Swift">
                                                <div class="d-md-none mb-2"></div>
                                            </div> -->
                                         </div> 

                                         <div class="form-group row align-items-center" id="online-0" style="display:none">

                                             <div class="col-md-6 form-group">
                                                <label>Email :</label>
                                                <input type="text" class="form-control" name="delivery_partner_bank[0][email]" placeholder="Email">
                                                <div class="d-md-none mb-2"></div>
                                            </div>


                                         </div>


                                    
                                     <!--        <div class="col-md-12 form-group">
                                                <button type="button" onclick="removeAccount(this,0)" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger float-right">
                                                <i class="la la-trash-o"></i>Delete</button>
                                            </div> -->
                                                        

                           <!--          <div class="form-group row">
                                       
                                        <div class="col-lg-12">
                                            <button type="button" onclick="NewAccount(this,0);" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary float-right">
                                            <i class="la la-plus"></i>Add</button>
                                        </div>
                                    </div> -->
                        
                                 </div>
                                 @endif

                                      <div class="mb-10 font-weight-bold text-dark"> Select Payout Group</div>
                                    <div class="form-group row">
                                       
                                      <div class="col-lg-6">
                                      <div class="form-group fv-plugins-icon-container">
                                                <label>Payout Group <span class="text-danger">*</span>:</label>
                                                <select class="form-control" name="payout_group_id" >
                                                  @foreach($payout_groups as $payout_group)

                                                  <option {{$payout_group->id==$delivery_partner->payout_group_id?'selected':'' }} value="{{$payout_group->id}}">{{$payout_group->name}}</option>
                                               @endforeach
                                                </select>

                                                    @if($errors->has('payout_group_id'))
                                            <div class="fv-plugins-message-container">
                                               <div  class="fv-help-block">{{ $errors->first('payout_group_id') }}
                                               </div>
                                              </div>
                                                  
                                          @endif
                                       </div>
                                          
                                      </div>

                                    </div> 


                        
                                  
                                </div>
                                <!--end: Wizard Step 2-->

                                <!--begin: Wizard Step 3-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <div class="mb-10 font-weight-bold text-dark">Attach Documents<span class="text-danger">*</span></div>
                                    <div class="row">


                                    <div class="col-lg-6">
                                  <div class="image-input image-input-outline" style="width: 300px;" id="kt_image_1">
                                            <div class="image-input-wrapper" style=" object-fit: contain; background-image: url({{!empty($proof)? $proof->getUrl():asset('assets/media/logos/no-image.png')}});width: 304px;height: 200px; background-size: 100% 100%">
                                                



                                            </div>
                                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                <input type="file" name="proof_image" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="profile_avatar_remove" />
                                            </label>
                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        </div>
                                        <span class="form-text text-muted">Upload ID proof  Allowed file types: png, jpg, jpeg.</span>

                                           <input type="hidden"  name="old_image" value="{{!empty($proof)?$proof->id:''}}">
                                   </div>
                          
                             <div class="col-lg-6">
                                  <div class="image-input image-input-outline" style="width: 300px;" id="kt_image_2">
                                            <div class="image-input-wrapper" style=" object-fit: contain; background-image: url({{!empty($profile)? $profile->getUrl():asset('assets/media/logos/no-image.png')}});width: 304px;height: 200px; background-size: 100% 100%">
                                                



                                            </div>
                                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                <input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="profile_avatar_remove" />
                                            </label>
                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        </div>
                                        <span class="form-text text-muted">Upload Profile Image  Allowed file types: png, jpg, jpeg. (144 x 144)</span>

                                           <input type="hidden"  name="old_image1" value="{{!empty($profile)?$profile->id:''}}">
                                   </div>
                          
                          
                                    </div>



                                </div>
                                <!--end: Wizard Step 3-->

                          

                                <!--begin: Wizard Actions-->
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary mr-2" data-wizard-type="action-prev">
                                            Previous
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success mr-2" data-wizard-type="action-submit">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-primary mr-2" data-wizard-type="action-next">
                                            Next
                                        </button>
                                        <a class="btn btn-secondary" href="https://www.thechef.tnmos.com/admin/delivery-partner">Cancel</a>
                                    </div>
                                </div>
                                <!--end: Wizard Actions-->
                            <div></div><div></div><div></div></form>
                            <!--end: Wizard Form-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Wizard Bpdy-->
        </div>

            
             </div>
              


            </div>


         </div>
               
      



            <!--end::Form-->
        </div>




    



<!--begin::Row-->
      </div>

</div>
<!--end::Entry-->


                
<!--end::Content-->


@endsection

@push('styles')

 <link href="{{ asset('assets/css/pages/wizard/delivery-wizard.css') }}" rel="stylesheet" type="text/css"/>


 @endpush
@push('scripts')

<script src="{{ asset('assets/js/pages/custom/wizard/delivery-wizard.js') }}"></script>



<script>
$(function() {
new KTImageInput('kt_image_1');
});
$(function() {
new KTImageInput('kt_image_2');
});
    $(document).ready(function() {

 $( "#save" ).click(function() {

 
    $('#kt_form').submit();

   });
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
<script type="text/javascript">




function showPaymentForm(element,row_id)
{
  if($(element).val()==2)
  {
   
    $(element).parents('div#payment-select-'+row_id).siblings('#online-'+row_id).show();
    $(element).parents('div#payment-select-'+row_id).siblings('#bank-'+row_id).hide();
  }
  else{
    $(element).parents('div#payment-select-'+row_id).siblings('#online-'+row_id).hide();
    $(element).parents('div#payment-select-'+row_id).siblings('#bank-'+row_id).show();

  }






}

function removeAccount(elm,row_id)
{


  $('#repeter-'+row_id).remove();
}

function NewAccount(elm,i)
{
  $(elm).hide();

      i++;

    html='';

html+='<div class="repeter-container" id="repeter-'+i+'" style="width: 100%">';

html+='<div class="col-md-6 form-group "  id="payment-select-'+i+'">';
html+='<label>Payment Type:</label>';
html+='<select class="form-control" name="delivery_partner_bank['+i+'][payment_method]" onchange="showPaymentForm(this,'+i+')" >';
              

html+='<option value="1">Bank</option>';
html+='<option value="2">online</option>';
html+='</select>';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';

html+='<div class="form-group row align-items-center" id="bank-'+i+'" style="width: 100%" >';
 

html+='<div class="col-md-6 form-group ">';
html+='<label>Bank Name:</label>';
html+='<input type="text" name="delivery_partner_bank['+i+'][bank_name]" class="form-control"  placeholder="Name">';
html+='<div class="d-md-none mb-2"></div>';html+='</div>';

html+='<div class="col-md-6 form-group">';
html+='<label>Branch :</label>';
             
html+='<input type="text" name="delivery_partner_bank['+i+'][branch]" class="form-control" placeholder="Branch">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';

html+='<div class="col-md-6 form-group">';
html+='<label>Account No :</label>';
html+='<input type="text" name="delivery_partner_bank['+i+'][account_number]" class="form-control" placeholder="Account No">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';

html+='<div class="col-md-6 form-group">';
html+='<label>IFSC :</label>';
html+='<input type="text" name="delivery_partner_bank['+i+'][ifsc]" class="form-control" placeholder="Ifsc">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';


html+='<div class="col-md-6 form-group">';
html+='<label>Swift :</label>';
html+='<input type="text" name="delivery_partner_bank['+i+'][swift]" class="form-control" placeholder="Swift">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';
html+='<div class="col-md-6 form-group">';
html+='<label>Default :</label>';
html+='<input type="radio" name="delivery_partner_bank['+i+'][default]"  placeholder="Swift">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';
html+='</div> ';

html+='<div class="form-group row align-items-center" id="online-'+i+'" style="display: none;">';

html+='<div class="col-md-6 form-group">';
html+='<label>Email :</label>';
html+='<input type="text" class="form-control" name="delivery_partner_bank['+i+'][email]" placeholder="Email">';
html+='<div class="d-md-none mb-2"></div>';
html+='</div>';


html+='</div>';



html+='<div class="col-md-12 form-group">';
html+='<a href="javascript:;" onclick="removeAccount(this,'+i+')" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger float-right">';
html+='<i class="la la-trash-o"></i>Delete</a>';
html+=' </div>';


html+=' <div class="form-group row">';

html+='<div class="col-lg-12">';
html+=' <a href="javascript:;" onclick="NewAccount(this,'+i+')" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary float-right">';
html+=' <i class="la la-plus"></i>Add</a>';
html+='</div>';
html+='</div>';

html+=' </div>';



         

   $('.append-account').append(html);


}




  $(document).ready(function() {

    $('#description').summernote({
            height: 300,
            tabsize: 2
        });


    $('#option').select2({

         width: "100%",
    });
     $('#category').select2();
      $('#brand').select2();
      $('#option-value').select2({

         width: "100%",
    });
});
    $( "#save" ).click(function() {

 
    $('#kt_form').submit();

   })
  
</script>
<script>
    $('.country').on('change', function(e){
    //alert();
 state={{$delivery_partner->state_id}}
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
</script>

@endpush