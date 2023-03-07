@extends('admin.layouts.app')


<!--begin::Content-->

@section('subheader')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
                     <a href="{{route('admin.home')}}">
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"> Dashboard</h5>
          
           </a>
            <!--end::Page Title-->

            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

                <a href="{{route('admin.delivery-charge.index')}}"><span class="text-muted font-weight-bold mr-4">Delivery Charges</span> </a>

            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

                <span class="text-muted font-weight-bold mr-4">{{ $delivery_charge->id ? 'Edit' : 'Add' }} Delivery Charge</span> 
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
          <h3 class="card-title">{{ $delivery_charge->id ? 'Edit' : 'Add' }} Delivery Charge</h3>
                                              
            </div>
                                            <!--begin::Form-->
               <form class="form" action="{{ $delivery_charge->id ? route('admin.delivery-charge.update',$delivery_charge->id) : route('admin.delivery-charge.store') }}" id="weight-class-form" method="POST">
                          @csrf
                          {{ $delivery_charge->id ? method_field('PUT'):'' }}
                          <div class="card-body">

                                        <div class="form-group row">
                                              <div class="col-lg-6">
                                                <label>Country <span class="text-danger">*</span> :</label>
                                                <select class="form-control" id="country" name="country_id" required>
                                                  <option value="" selected="">Select</option> @foreach($country as $key => $value)
                                                  <option value="{{ $key }}" {{ $key==old( 'country_id',$delivery_charge->country_id) ? 'selected': '' }}>{{ $value }}</option> @endforeach </select> 
                                                  @if($errors->has('country_id'))

                                                     <div class="fv-plugins-message-container">
                                                  <div  class="fv-help-block">{{ $errors->first('country_id') }}</div>
                                                    </div>

                                              
                                                 @endif 

                                                 </div>
                                              <div class="col-lg-6">
                                                <label>State<span class="text-danger">*</span> :</label>
                                                <select class="form-control" id="state_id" name="state_id" required>
                                                  <option value="" selected="">Select</option> @foreach($states as $key => $value)
                                                  <option value="{{ $key }}" {{ $key==old( 'state_id',$delivery_charge->state_id) ? 'selected': '' }}>{{ $value }}</option> @endforeach </select> 

                                                  @if($errors->has('state_id'))

                                               
                                               <div class="fv-plugins-message-container">
                                                  <div  class="fv-help-block">{{ $errors->first('state_id') }}</div>
                                                    </div>

                                                 @endif 
                                                </div>
                                            </div>

                            <div class="form-group row">
                              <div class="col-lg-6">
                                <label>Minimum Charge<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" placeholder="Charge" id="" name="minimum_charge" value="{{ old('minimum_charge', number_format($delivery_charge->minimum_charge,2)) }}" required="required">
                                @if($errors->has('minimum_charge'))
                                <div class="error">{{ $errors->first('minimum_charge') }}</div>
                                @endif
                                </div>
                               <div class="col-lg-6">
                                  <label for="example-date-input" class=" ">Minimum Distance<span class="text-danger">*</span> :</label>
                                  <input type="text" class="form-control" placeholder="Distance" id="" name="minimum_distance" value="{{ old('minimum_distance', number_format($delivery_charge->minimum_distance,2)) }}" required="required">
                                   @if($errors->has('minimum_distance'))
                                 <div class="error">{{ $errors->first('minimum_distance') }}</div>
                                 @endif
                              
                              </div>
                           </div>

                            <div class="form-group row">
                              <div class="col-lg-6">
                                <label>Extra Charge (Per 1 Km)<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" placeholder="Charge" id="" name="charge" value="{{ old('charge', number_format($delivery_charge->charge,2)) }}" required="required">
                                @if($errors->has('charge'))
                                <div class="error">{{ $errors->first('charge') }}</div>
                                @endif
                                </div>
                       
                           </div>
                    

                            <div class="form-group row">
                                <div class="col-lg-6">
                                <label for="example-date-input" class=" ">Start Date<span class="text-danger">*</span> :</label>
                                  <input class="form-control" type="text"  id="start-date" placeholder="Start Date"  readonly name="start_date" value="{{ old('start_date', Carbon\Carbon::parse($delivery_charge->start_date)->format('d-m-Y')) }}" required="required">
                                 @if($errors->has('start_date'))
                                <div class="error">{{ $errors->first('start_date') }}</div>
                              @endif
                              </div>
                                <div class="col-lg-6">
                                <label for="example-date-input" class="">End Date</label>
                                    <input class="form-control" readonly type="text" id="end-date" placeholder="End date"  name="end_date" value="{{ old('end_date', Carbon\Carbon::parse($delivery_charge->end_date)->format('d-m-Y')) }}">
                                   @if($errors->has('end_date'))
                                  <div class="error">{{ $errors->first('end_date') }}</div>
                                    @endif
                               </div>
                               </div>
                                <div class="form-group row">
                                <div class="col-lg-6">
                                   <label>Status:</label>
                                <span class="switch switch-outline switch-icon switch-success">
    
                                    <label>
    
                                    <input type="checkbox" {{ $delivery_charge->status ==1 ? 'checked' : '' }} name="checkbox" id="check" value="0" >
    
                                    <input type="hidden" name="status" id="val" value="@if($delivery_charge->id){{ old('status', $delivery_charge->status) }} @else 0 @endif">
    
                                    <span></span>
    
                                    </label>
    
                            </span>   
    
                       
                                @if($errors->has('status'))
                                        <div class="error">{{ $errors->first('status') }}</div>
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
                                                         

                                                            <a class="btn btn-secondary" href="{{route('admin.delivery-charge.index')}}">cancel</a>
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
<script>
$(function() {
new KTImageInput('kt_image_1');
});
</script>
<script>
$(function() {
$('.summernote').summernote({
            height: 400,
            tabsize: 2
        });
});
</script>
<script>


  $('#country').change(function() {
   
   value=$('#country').val();
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'GET',
          data:{country_id:value},
          dataType : 'JSON', 
          url : '{{route('admin.get-state')}}',
          success: function(response){ 
           
            html='<option value="">Select State</option>';
            $.each(response.states, function(i, elem){
            html+='<option value="'+elem.id+'" >'+elem.name+'</option>';
            });
            $('#state_id').html(html);
          } 
        }); 



  });
$(function() {
  
      var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
        // minimum setup

        //disabling past date from datepicker
   
        $('#end-date').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'dd-mm-yyyy',
            startDate: 'd',
        });

             $('#start-date').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'dd-mm-yyyy',
            startDate: 'd',

        });
});
</script>
<script>
    $(document).ready(function() {
        
        $('input[name="minimum_charge"]').attr("onkeypress", "return isDecimal(this, event)");
        $('input[name="charge"]').attr("onkeypress", "return isDecimal(this, event)");
        $('input[name="minimum_distance"]').attr("onkeypress", "return isDecimal(this, event)");
        
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