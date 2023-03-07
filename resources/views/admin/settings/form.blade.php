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
         <a href="{{route('admin.settings.index')}}">
         <span class="text-muted font-weight-bold mr-4">
            General Settings                         
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $settings->id ? 'Edit' : 'Add' }} Settings</span> 
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
            <h3 class="card-title">{{ $settings->id ? 'Edit' : 'Add' }} Settings</h3>
         </div>
         <!--begin::Form-->
         <form class="form" action="{{ $settings->id ? route('admin.settings.update',$settings->id) : route('admin.settings.store') }}" id="store-type-form" method="POST">
            @csrf
            {{ $settings->id ? method_field('PUT'):'' }}
            <div class="card-body">
               <div class="form-group row">
                  <div class="col-lg-6">
                      <label class="col-lg-3 col-form-label">Invoice Prefix:<span class="required"
                                        style="color:red">*</span></label>
                     <!--<label>Title<span class="text-danger">*</span> :</label>-->
                     <!--<input type="text" class="form-control" placeholder="Title" id="title" name="title" value="{{ old('title', $settings->title) }}" required="required" disabled="{{ $settings->id ? 'true' : 'false' }}">-->
                    
                  </div>
                  <div class="col-lg-6">
                     <!--<label>Value<span class="text-danger">*</span> :</label>-->
                     <input type="text" class="form-control" placeholder="Value"  name="value" value="{{ old('value', $settings->value) }}" required="required">
                     @if($errors->has('value'))
                     <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('value')}}</div>
                                  </div>
                     @endif
                  </div>
               </div>
              
            </div>
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                     <a class="btn btn-secondary" href="{{route('admin.settings.index')}}">Cancel</a>
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