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
         <a href="{{route('admin.notification.index')}}">
         <span class="text-muted font-weight-bold mr-4">
           Notification                         
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $notification->id ? 'Edit' : 'Add' }} Push Notification</span> 
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
            <h3 class="card-title">{{ $notification->id ? 'Edit' : 'Add' }} Push Notification</h3>
         </div>
         <!--begin::Form-->
         <form class="form" action="{{ $notification->id ? route('admin.notification.update',$notification->id) : route('admin.notification.store') }}" id="notification-form" method="POST">
            @csrf
            {{ $notification->id ? method_field('PUT'):'' }}
            <div class="card-body">
               <div class="form-group row">
                     <div class="col-lg-6">
                             <label>Type <span class="text-danger">*</span> :</label>
                             <select  class="form-control type" name="user_type" required>
                              <option value="">Select Type</option>
                           
                               <option value="1">Customer</option>
                               <option value="2">Kitchen</option>
                               <option value="3">Delivery Partner</option>
                           
                            
                             </select>
                        </div>
                  <div class="col-lg-6">
                     <label>Title <span class="text-danger">*</span> :</label>
                     <input type="text" class="form-control" placeholder="Title" id="title" name="title" value="{{ old('title', $notification->title) }}">
                     @if($errors->has('title'))
                    <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('title')}}</div>
                                  </div>
                     @endif
                  </div>
             </div>
               <div class="form-group row">
                   <div class="col-lg-12">
                            <label>Message <span class="text-danger">*</span> :</label>
                            <textarea max-length="45" class="form-control " id="message" name="message" placeholder="Message">{{ old('message', $notification->message) }}</textarea>
                          @if($errors->has('message'))
                                        <div class="fv-plugins-message-container">
                                            <div  class="fv-help-block">{{ $errors->first('message') }}</div>
                                        </div>
                                    @endif
                        </div>
               </div>
               <div class="form-group row">
                   
                    <div class="col-lg-6">
                             <label>Route <span class="text-danger">*</span> :</label>
                             <select  class="form-control notification_type" name="route" required>
                              <option value="">Select Route</option>
                           
                               <option value="1" selected>Information</option>
                             
                           
                            
                             </select>
                        </div>
                  
                  
                <div class="col-lg-6" >
                     <label>Parameter <span class="text-danger">*</span> :</label>
                    <select  class="form-control " name="parameter">
                    
                   @foreach($information as $info)
                       <option value="{{$info->id}}">{{$info->getTranslation('title',app()->getLocale())}}</option>
                    @endforeach
                   
                    
                     </select>
                  </div>

             
               </div>
      
            </div>
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Sent</button>
                     <a class="btn btn-secondary" href="{{route('admin.notification.index')}}">Cancel</a>
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
       
    $('.notification_type').change(function(){
      var type=$(this).val();
      //alert(type);
      if(type=='2'){
        $('#storeTypeDiv').show();

        $('#infoDiv').hide();
      
       
      }
      else if(type=='1')
      {
         $('#storeTypeDiv').hide();
         $('#infoDiv').show();
        
      
      }
      else
      {
         $('#storeTypeDiv').hide();
         $('#infoDiv').hide();
       
         
      }
  

    });
   
   });
</script>
<script>
    $(document).ready(function () {
  //called when key is pressed in textbox
  $(".numbers").keypress(function (e) {

     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});</script>

@endpush