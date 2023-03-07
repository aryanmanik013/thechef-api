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
         <a href="{{route('admin.state.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          States                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $state->id ? 'Edit' : 'Add' }} State</span> 
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
         <h3 class="card-title">{{ $state->id ? 'Edit' : 'Add' }} State</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{$state->id ? route('admin.state.update',$state->id) : route('admin.state.store') }}" id="unit-class-form" method="POST">
         {{ $state->id ? method_field('PUT') : '' }}
         @csrf
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                  <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $state->getTranslation('name','en')) }}" required="required">
                  @if($errors->has('name'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Country<span class="text-danger">*</span> :</label>
                  				<select name="country_id" class="form-control" id="exampleSelect1" required>
                  				    <option value="">Select Country</option>
                  				    @foreach($country as $key => $value)

                                      <option value="{{ $key }}" {{ $key==$state->country_id ? 'selected': '' }}>{{ $value }}</option>

                                      @endforeach

                             
															
														</select>
                  @if($errors->has('country_id'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('country_id')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
              <div class="form-group row">
               <div class="col-lg-6">
                  <label>Code<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Code" id="code" name="code" value="{{ old('code', $state->code) }}" required="required">
                  @if($errors->has('code'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('code')}}</div>
                                  </div>
                  @endif
               </div>
                  <div class="col-lg-6">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $state->status ==1 ? 'checked' : '' }} name="select" id="check" />
                  <span><span>
                  <input type="hidden" name="status" id="val" value="@if($state->id){{ old('status', $state->status) }} @else 0 @endif">
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
                     <a class="btn btn-secondary" href="{{route('admin.state.index')}}">Cancel</a>
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