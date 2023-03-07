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
           Coupons                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $coupon->id ? 'Edit' : 'Add' }} Coupon</span> 
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
         <h3 class="card-title">{{ $coupon->id ? 'Edit' : 'Add' }} Coupon</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{ $coupon->id ? route('admin.coupon.update',$coupon->id) : route('admin.coupon.store') }}" id="unit-class-form" method="POST">
         @csrf
         {{ $coupon->id ? method_field('PUT'):'' }}
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                  <label>Coupon Name<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Coupon Name" id="name" name="name" value="{{ old('name', $coupon->name) }}" required="required">
                  @if($errors->has('name'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Coupon Code<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Coupon Code" id="code" name="code" value="{{ old('code', $coupon->code) }}" required="required">
                  @if($errors->has('code'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('code')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
            <div class="form-group row">
                 <div class="col-lg-6">
                  <label>Coupon Limit<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Coupon Limit"  name="uses_total" value="{{ old('uses_total', $coupon->uses_total) }}" required="required">
                  @if($errors->has('uses_total'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('uses_total')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Customer Usage Limit<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Customer Usage Limit"  name="uses_customer" value="{{ old('uses_customer', $coupon->uses_customer) }}" required="required">
                  @if($errors->has('uses_customer'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('uses_customer')}}</div>
                                  </div>
                  @endif
               </div>
              
            </div>
                <div class="form-group row">
               <div class="col-lg-6">
                  <label>Valid From<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Start Date" id="start_date" name="start_date" value="{{ old('start_date', Carbon\Carbon::parse($coupon->start_date)->format('d-m-Y')) }}" required="required">
                  @if($errors->has('start_date'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('start_date')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Valid To<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Expiry Date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', Carbon\Carbon::parse($coupon->expiry_date)->format('d-m-Y')) }}" required="required">
                  @if($errors->has('expiry_date'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('expiry_date')}}</div>
                                  </div>
                  @endif
               </div>
            </div>
            <div class="form-group row">

                           <div class="col-lg-6">
                             <label>Valid for<span class="text-danger">*</span> :</label>
                            

                            <select name="type" class="form-control type">
                                
                                <option value="0" {{ old('type',$coupon->type)==0 ? 'selected' : '' }}>General</option>
                                     <option value="1" {{ old('type',$coupon->type)==1 ? 'selected' : '' }}>Category</option>
                                    

                            </select>
                             
                           </div>
     <div class="col-lg-6">
                  <label>Minimum Amount<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Minimum Amount" id="minimum_amount" name="minimum_amount" value="{{ old('minimum_amount', $coupon->minimum_amount) }}" required="required">
                  @if($errors->has('minimum_amount'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('minimum_amount')}}</div>
                                  </div>
                  @endif
               </div>
                          </div>
                                                			       <div class="form-group row">
					                          <!--edit valid category-->
                    @if($coupon->type==1)
                                  <div class="col-lg-12 valid_categorydiv">
                                       <label >Category<span class="text-danger">*</span> :</label>
                   <!--<div class="col-lg-9" style="float:left;">-->
                        <select id="example-enableClickableOptGroups-init" multiple="multiple" name="category_id[]" class="valid_category form-control select2">
                          @foreach($categories as $key => $value)
                          
                                   <option value="{{$value->id}}" @if($couponcategories->categories->containsStrict('food_category_id', $value->id)) selected="selected" @endif>{{$value->name}}</option>
                         
                              @endforeach
                                         
                                  </select>
                           <!--</div>-->
                    </div>
                    @endif
					           <!--close edit valid category-->
                    <!---valid for category-->
                         <div class="col-lg-12 valid_categorydiv" style="display: none">
                        <label>Category<span class="text-danger">*</span> :</label>

                        <!--<div class="col-lg-9" style="float:left;">-->

                              <select id="example-enableClickableOptGroups-init" multiple="multiple" name="category_id[]" class="valid_category form-control select2">
                          @foreach($categories as $key => $value)
                            
                                   <option value="{{$value->id}}">{{$value->name}}</option>
                      
                              @endforeach
                                        
                                  </select>
                                  <!--</div>-->
                        </div>
                         <!--close valid for category-->
                                             
                         
                         </div>
                           <div class="form-group row">

                           <div class="col-lg-6">
                             <label>Discount Type<span class="text-danger">*</span> :</label>
                            

                            <select name="discount_type" class="form-control discount_type">
                                
                                <option value="0" @if($coupon->discount_type == '0'){{'selected'}}@endif >Fixed</option>

                       <option value="1" @if($coupon->discount_type == '1'){{'selected'}}@endif >Percentage</option>    

                            </select>
                             
                           </div>
                        <div class="col-lg-6">
                  <label>Discount<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Discount" id="code" name="discount" value="{{ old('discount', $coupon->discount) }}" required="required">
                  @if($errors->has('discount'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('discount')}}</div>
                                  </div>
                  @endif
               </div>
                          </div>
                                <div class="form-group row">
          
                    <div class="col-lg-6">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $coupon->status ==1 ? 'checked' : '' }} name="select" id="check" />
                  <span><span>
                  <input type="hidden" name="status" id="val" value="@if($coupon->id){{ old('status', $coupon->status) }} @else 0 @endif">
                  </span></span>
                  </label>
                  </span>
                  @if($errors->has('status'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('status')}}</div>
                                  </div>
                  @endif
               </div>
                   <div class="col-lg-6 maxdisc" style="display:none;">
                  <label>Maximum Discount<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Maximum Discount" id="maximum_discount_amount" name="maximum_discount_amount" value="{{ old('maximum_discount_amount', $coupon->maximum_discount_amount) }}" >
                  @if($errors->has('maximum_discount_amount'))
                 <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('maximum_discount_amount')}}</div>
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
                     <a class="btn btn-secondary" href="{{route('admin.coupon.index')}}">Cancel</a>
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
        // $('#example-enableClickableOptGroups-init').multiselect({
        //     enableClickableOptGroups: true
        // });
        $('#example-enableClickableOptGroups-init').select2();

    });
</script>
<script>
         $('.type').change(function(){
      var type=$(this).val();
      //alert(type);
      if(type==1){
        $('.valid_categorydiv').show();
        
      }
      else
      {
         $('.valid_categorydiv').hide();
         $('.valid_category').val('');
      }
  



 
    });
  </script>
  <script>
$(document).ready(function(){
    
    var type=$(".discount_type option:selected").val();
   
    if(type == '0'){
        $('.maxdisc').hide();
         $('.max_discamount').val('0.0000');
            
        }
        else {
            $('.maxdisc').show();
             
        }
    
    
    $(".discount_type").change(function(){
        var radioValue = $(this).val();
        //alert(radioValue);
        if(radioValue == '1'){
            $('.maxdisc').show();
        }
        else {
            $('.maxdisc').hide();
             $('.max_discamount').val('0.0000');
        }
    });
    
});

</script>
<script type="text/javascript">
   $(document).ready(function() {
       
       $('input[name="discount"]').attr("onkeypress", "return isDecimal(this, event)");
       $('input[name="uses_total"]').attr("onkeypress", "return isNumber(event)");
       $('input[name="uses_customer"]').attr("onkeypress", "return isNumber(event)");
       $('input[name="minimum_amount"]').attr("onkeypress", "return isDecimal(this, event)");
       $('input[name="maximum_discount_amount"]').attr("onkeypress", "return isDecimal(this, event)");
   
   $('#check').click(function(){
   
        if ($('#check').is(":checked"))
        {
               $("#val").attr( "value", "1" );
        } 
   
        else{
   
        $("#val").attr( "value", "0" );
   
        }
       });
        $('#start_date').datepicker({
            format: 'dd-mm-yyyy',
            startDate : new Date(),
            // minDate : new Date(),
            todayHighlight : true,
            autoclose : true
        }).on('changeDate', function(e){
            var minDate = new Date(e.date.valueOf());
            $('#expiry_date').datepicker('setStartDate',minDate);
            $('#expiry_date').datepicker('update',minDate);
            // $('#expiry_date').attr("value", minDate);
        });
        
        $('#expiry_date').datepicker({
            format: 'dd-mm-yyyy',
            startDate : new Date(),
            // minDate : new Date(),
            todayHighlight : true,
            autoclose : true
        }).on('changeDate', function(e){
            var startDate = new Date($("#start_date").val());
            var expiryDate = new Date(e.date.valueOf());
            if (expiryDate < startDate) {
                alert("Start Date is greater than Expiry Date!");
                return;
            }
        });
   
   });
</script>
@endpush