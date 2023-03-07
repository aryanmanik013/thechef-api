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
         <a href="{{route('admin.coupon.index')}}">
         <span class="text-muted font-weight-bold mr-4">
           Payout Groups                           
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $payout_group->id ? 'Edit' : 'Add' }}  Payout Group</span> 
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
         <h3 class="card-title">{{ $payout_group->id ? 'Edit' : 'Add' }} Payout Group </h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{ $payout_group->id ? route('admin.payout_group.update',$payout_group->id) : route('admin.payout_group.store') }}" id="payout-group-form" method="POST">
         @csrf
         {{ $payout_group->id ? method_field('PUT'):'' }}
         <div class="card-body">
                        <div class="form-group row">
                                                           <div class="col-lg-6">
                   <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Name"  name="name" value="{{ old('name', $payout_group->name) }}" required="required">
                  @if($errors->has('name'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
                <div class="col-lg-6">
                             <label>Payment User Type<span class="text-danger">*</span> :</label>
                            

                            <select name="type" class="form-control " required>
                                <option value="">Select</option>
                                <option value="1" {{ old('type',$payout_group->type)==1 ? 'selected' : '' }}>Kitchen</option>
                                     <option value="2" {{ old('type',$payout_group->type)==2 ? 'selected' : '' }}>Delivery</option>
                                    

                            </select>
                             
                           </div>
               </div>
            <div class="form-group row">
                
                    
               <div class="col-lg-6">
                             <label>Payment Frequency<span class="text-danger">*</span> :</label>
                            

                            <select name="payment_frequency" class="form-control type" required>
                                <option value="">Select</option>
                                <option value="1" {{ old('payment_frequency',$payout_group->payment_frequency)==1 ? 'selected' : '' }}>Month</option>
                                     <option value="2" {{ old('payment_frequency',$payout_group->payment_frequency)==2 ? 'selected' : '' }}>Week</option>
                                    

                            </select>
                             
                           </div>
                                                      <div class="col-lg-6">
                   <label>Sort Order<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Sort Order"  name="sort_order" value="{{ old('sort_order', $payout_group->sort_order) }}" required="required">
                  @if($errors->has('sort_order'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('sort_order')}}</div>
                                  </div>
                  @endif
               </div>
           
            </div>

                <div class="form-group row">
                     @if($payout_group->payment_frequency==1)
                         <div class="col-lg-6 valid_datediv">
                  <label>Payment Date<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control payment_date" placeholder="Payment Date" id="payment_date" name="payment_date" value="{{ old('payment_date', Carbon\Carbon::parse($payout_group->payment_date)->format('d-m-Y')) }}" >
                  @if($errors->has('payment_date'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('payment_date')}}</div>
                                  </div>
                  @endif
               </div>
                     @else
               <div class="col-lg-6 valid_datediv" style="display: none">
                  <label>Payment Date<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control payment_date" placeholder="Payment Date" id="payment_date" name="payment_date" value="{{ old('payment_date', Carbon\Carbon::parse($payout_group->payment_date)->format('d-m-Y')) }}" >
                  @if($errors->has('payment_date'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('payment_date')}}</div>
                                  </div>
                  @endif
               </div>
               @endif
               @if($payout_group->payment_frequency==2)
                  <div class="col-lg-6 valid_daydiv">
                             <label>Day<span class="text-danger">*</span> : </label>
                            

                            <select name="day_id" class="form-control day" id="day">
                                
                               <!--<option value="">Select Day</option>-->
                  				      @foreach($days as $key => $value)
						<option value="{{ $key }}" {{$key == old('day_id',$payout_group->day_id) ?'selected':' '}} >{{ $value }}
                                     
                              @endforeach      

                            </select>
                             
                           </div>
                           @else
                <div class="col-lg-6 valid_daydiv" style="display: none">
                             <label>Day<span class="text-danger">*</span> :</label>
                            

                            <select name="day_id" class="form-control day" id="day1">
                                
                               <option value="">Select Day</option>
                  				      @foreach($days as $key => $value)
						<option value="{{ $key }}">{{ $value }}
                                     
                              @endforeach      

                            </select>
                             
                           </div>
                           @endif
                           @if(isset($payout_group->id))
                                          <div class="col-lg-6 percentage">
                  <label>Percentage<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Percentage" id="percentage" name="percentage" value="{{ number_format(old('percentage', $payout_group->percentage),2) }}" required="required">
                  @if($errors->has('percentage'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('percentage')}}</div>
                                  </div>
                  @endif
               </div>
               @else
                                                  <div class="col-lg-6 percentage" style="display: none">
                  <label>Percentage<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Percentage" id="percentage" name="percentage" value="{{ number_format(old('percentage', $payout_group->percentage),2) }}" required="required">
                  @if($errors->has('percentage'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('percentage')}}</div>
                                  </div>
                  @endif
               </div>
               @endif
              
            </div>
           
    
            
                                <div class="form-group row">
                     
          
                    <div class="col-lg-6">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $payout_group->status ==1 ? 'checked' : '' }} name="select" id="check" />
                  <span><span>
                  <input type="hidden" name="status" id="val" value="@if($payout_group->id){{ old('status', $payout_group->status) }} @else 0 @endif">
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
                     <a class="btn btn-secondary" href="{{route('admin.payout_group.index')}}">Cancel</a>
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
        $('#example-enableClickableOptGroups-init').multiselect({
            enableClickableOptGroups: true
        });

    });
</script>
<script>
$(document).ready(function(){

     $('input[name="percentage"]').attr("onkeypress", "return isDecimal(this, event)");
         $('.type').change(function(){
      var type=$(this).val();
      //alert(type);
      if(type==2){
        $('.valid_daydiv').show();
        $('.valid_datediv').hide();
        $('.percentage').show();
         //$('.payment_date').val('');
         $( ".payment_date").datepicker('setDate','');
      }
      else if(type==1)
      {
          $('.valid_datediv').show();
          $('.percentage').show();
         $('.valid_daydiv').hide();
          $('.day').val('');
          $('#day').val('');
           $('#day1').val('');
         
      }
    //   else
    //   {
    //      $('.valid_daydiv').hide();
    //      $('.valid_datediv').hide();
    //      //$('.payment_date').val('');
    //      $( ".payment_date").datepicker('setDate','');
    //      $('.day').val('');
    //   }
  



 
    });
    $('.day').change(function(){
         $( ".payment_date").datepicker('setDate','');
    });
    //  $('.payment_date').change(function(){
    //      $( ".day").val('');
    // });
});
  </script>
  <script>
$(document).ready(function(){
    
    
    // var type=$(".discount_type option:selected").val();
   
    // if(type == '0'){
    //     $('.maxdisc').hide();
    //      $('.max_discamount').val('0.0000');
            
    //     }
    //     else {
    //         $('.maxdisc').show();
             
    //     }
    
    
    // $(".discount_type").change(function(){
    //     var radioValue = $(this).val();
    //     //alert(radioValue);
    //     if(radioValue == '1'){
    //         $('.maxdisc').show();
    //     }
    //     else {
    //         $('.maxdisc').hide();
    //          $('.max_discamount').val('0.0000');
    //     }
    // });
    
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
       $('.payment_date').datepicker({
           format: 'dd-mm-yyyy',
      startDate : new Date(),
    todayHighlight : true,
           });

   
   });
</script>
@endpush