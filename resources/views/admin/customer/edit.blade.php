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
         <a href="{{route('admin.customer.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          Customers                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{$customer->id ? 'Edit Customer':' '}}</span> 
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
         <h3 class="card-title">{{$customer->id ? 'Edit Customer':' '}}</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{$customer->id ? route('admin.customer.update',$customer->id) : route('admin.customer.store') }}" id="unit-class-form" method="POST">
         {{ $customer->id ? method_field('PUT') : '' }}
         @csrf
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                  <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $customer->name) }}" required="required">
                  @if($errors->has('name'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Gender<span class="text-danger">*</span> :</label>
                  				<select name="gender_id" class="form-control" id="exampleSelect1" required>
                  				    <option value="">Select Gender</option>
                  				      @foreach($genders as $key => $value)
						<option value="{{ $key }}" {{$key == old('gender_id',$customer->gender_id) ?'selected':' '}} >{{ $value }}

                                      </option>

                             @endforeach
															
														</select>
                  @if($errors->has('gender_id'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('gender_id')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
              <div class="form-group row">
               <div class="col-lg-6">
                  <label>Phone<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required="required">
                  @if($errors->has('phone'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('phone')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Email<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email', $customer->email) }}" required="required">
                  @if($errors->has('email'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('email')}}</div>
                                  </div>
                  @endif
               </div>
            </div>

            
            
            
             <div class="form-group row">
               <div class="col-lg-6">
                  <label>Status:</label>
                      <select class="form-control  form-control-lg" name="status" > 
                      <option {{ old('status', $customer->status)== '1' ? 'selected' : '' }} value="1"/> Enable </option>
                      <option {{ old('status', $customer->status)== '0' ? 'selected' : '' }} value="0"/>  Disable</option> 
                    </select>
                
                 
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
         $(document).ready(function () {
             //if ( $("#password").val().length > 0 )
            $("#password").keypress(function(){
               $('#confirm_password').removeAttr('disabled');
         });
         $("#password").keydown(function(){
             //alert($("#password").val().length);
         if ( $("#password").val().length == 1 ){
            $('#confirm_password').attr('disabled','disabled'); 
         }
         });
         
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
@endpush