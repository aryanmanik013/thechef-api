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
         <!--begin::Page Title-->
         <a href="{{route('admin.country.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          Countries                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $country->id ? 'Edit' : 'Add' }} Country</span> 
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
         <h3 class="card-title">{{ $country->id ? 'Edit' : 'Add' }} Country</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{ $country->id ? route('admin.country.update',$country->id) : route('admin.country.store') }}" id="unit-class-form" method="POST">
                 {{ $country->id ? method_field('PUT') : ''}}
         @csrf
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                  <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $country->name) }}" required="required">
                  @if($errors->has('name'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
                   <div class="col-lg-6">
                  <label>Phone Prefix<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Prefix" id="phone_prefix" name="phone_prefix" value="{{ old('phone_prefix', $country->phone_prefix) }}" required="required">
                  @if($errors->has('phone_prefix'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('phone_prefix')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
              <div class="form-group row">
               <div class="col-lg-6">
                  <label>ISO CODE 2<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="ISO CODE 2" id="iso_code_2" name="iso_code_2" value="{{ old('iso_code_2', $country->iso_code_2) }}" required="required">
                  @if($errors->has('iso_code_2'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('iso_code_2')}}</div>
                                  </div>
                  @endif
               </div>
                   <div class="col-lg-6">
                  <label>ISO CODE 3<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="ISO CODE 3" id="iso_code_3" name="iso_code_3" value="{{ old('iso_code_3', $country->iso_code_3) }}" required="required">
                  @if($errors->has('iso_code_3'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('iso_code_3')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
            <div class="form-group row">
                              <div class="col-lg-6">
                  <label>Currency Code<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Currency Code"  name="currency_code" value="{{ old('currency_code', $country->currency_code) }}" required="required">
                  @if($errors->has('currency_code'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('currency_code')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $country->status ==1 ? 'checked' : '' }} name="select" id="check" />
                  <span><span>
                  <input type="hidden" name="status" id="val" value="@if($country->id){{ old('status', $country->status) }} @else 0 @endif">
                  </span></span>
                  </label>
                  </span>
                  @if($errors->has('status'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('status')}}</div>
                                  </div>
                  @endif
               </div>
               </div>
         
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                     <a class="btn btn-secondary" href="{{route('admin.customer.index')}}">Cancel</a>
                  </div>
               </div>
            </div>
      </form>
      <!--end::Form-->
      </div>
      <!--begin::Row-->
   </div>
</div>
<!--end::Entry-->
<!--end::Content-->
@endsection
@push('scripts')
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
@endpush