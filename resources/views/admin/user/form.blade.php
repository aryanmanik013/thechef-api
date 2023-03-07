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
         <a href="{{route('admin.user.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          Users                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{$user->id ? 'Edit' : 'Add' }} User</span> 
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
         <h3 class="card-title">{{$user->id ? 'Edit' : 'Add' }} User</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{$user->id ? route('admin.user.update',$user->id) : route('admin.user.store') }}" id="user-form" method="POST" enctype="multipart/form-data">
         {{ $user->id ? method_field('PUT') : '' }}
         @csrf
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                  @if($errors->has('name'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
               
                   
            </div>
         
              <div class="form-group row">
               <div class="col-lg-6">
                  <label>Prefix<span class="text-danger">*</span> :</label>
                  <select class="country_selector sel form-control" name="phone_prefix" required>
                       <option value="">Prefix</option>
                       @foreach($isd_codes as $code)
        <option value="+{{ $code->phone_prefix }}" data-data=' {"iso_code2":"{{$code->iso_code_2 }}"}' {{$code->phone_prefix == $user->phone_prefix ?'selected':''}}>{{ $code->getTranslation('name',app()->getLocale()) }} (+{{ $code->phone_prefix }})</option>
                       @endforeach
                       </select>
                  
               </div>
                    <div class="col-lg-6">
                  <label>Phone<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                  @if($errors->has('phone'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('phone')}}</div>
                                  </div>
                  @endif
               </div>
               </div>
               <div class="form-group row">
               <div class="col-lg-6">
                  <label>Email<span class="text-danger">*</span> :</label>
                  <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                  @if($errors->has('email'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('email')}}</div>
                                  </div>
                  @endif
               </div>
                   <div class="col-lg-6">
                  <label>Notification Email<span class="text-danger">*</span> :</label>
                  <input type="email" class="form-control" placeholder="Notification Email" id="notification_email" name="notification_email" value="{{ old('notification_email', $user->notification_email) }}" >
                  @if($errors->has('notification_email'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('notification_email')}}</div>
                                  </div>
                  @endif
               </div>
            </div>

            <div class="form-group row">
               <div class="col-lg-6">
                  <label>Password<span class="text-danger">{{$user->id ? '' : '*' }}</span> :</label>
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                  @if($errors->has('password'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('password')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Password Confirmation<span class="text-danger">{{$user->id ? '' : '*' }}</span> :</label>
                  <input type="password" class="form-control" placeholder="Confirm Password"  name="password_confirmation" id="confirm_password" disabled>
                  @if($errors->has('password_confirmation'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('password_confirmation')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
             <div class="form-group row">
                <div class="col-lg-6">
                                <label>Role</label>
                         
                          <select name="role" class="form-control">
							<option value="">Select Role</option>
							@foreach($roles as $role)
									<option value="{{ $role }}" {{ old('role',$user_role) == $role ? 'selected' : '' }}>{{ $role }}</optiton>
							@endforeach
						</select>
						@if ($errors->has('role'))
					<div class="fv-plugins-message-container">
                         <div  class="fv-help-block">{{ $errors->first('role') }}</div>
                        </div>
						@endif
               </div>
               <div class="col-lg-6">
                  <label>Status:</label>
                      <select class="form-control  form-control-lg" name="status" > 
                      <option {{ old('status', $user->status)== '1' ? 'selected' : '' }} value="1"/> Enable </option>
                      <option {{ old('status', $user->status)== '0' ? 'selected' : '' }} value="0"/>  Disable</option> 
                    </select>
                
                 
               </div>
             </div>


         
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                     <a class="btn btn-secondary" href="{{route('admin.user.index')}}">Cancel</a>
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
      </script>text
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
   $(function() {
new KTImageInput('kt_image_1');
});
</script>

@endpush