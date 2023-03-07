@extends('admin.layouts.app')
@section('Title', 'Delivery Partner Payout Requests')
@section('subheader')
<!--<div class="content d-flex flex-column flex-column-fluid" id="kt_content">-->
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
         <span class="text-muted font-weight-bold mr-4">Delivery Partner Payout Requests</span>
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
<!-- begin:: Content -->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
      <div class="card card-custom">
         <div class="card-header flex-wrap py-5">
            <div class="card-title">
               <h3 class="card-label">
              Delivery Partner Payout Requests
               <!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
            </div>
            <!--begin::Button-->
            <!--end::Button-->
      
         </div>
         <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="delivery_partner_payout_request_table">
               <thead>
                  <tr>
                 
                     <th>Delivery Partner name</th>
                     <th>Payout Group</th>
                     <th>Start Date</th>
                      <th>End Date</th>
     <th>Total Orders</th>
                     <th>Total Amount</th>
                        <th>Payable Amount</th>
                           <th>Payout Generated Date</th>
                           <th>Payout Method</th>
                            <th>Status</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
            <!--end: Datatable-->
         </div>
      </div>
      <!--end::Card-->
   </div>
   <!--end::Container-->
</div>
<!--end::Entry-->
<div class="modal fade" id="complete-payout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="">Payment</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                </button>

            </div>

            <div class="modal-body">

                <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Transaction ID:</label>
                                                  <input  type="text" name="transaction_id"  class="form-control  form-control-lg" id="transaction_id">
                                                   
                                                </div>
                                              </div>
                                              <div class="col-xl-12">
                                                <div class="form-group fv-plugins-icon-container">
                                                  <label>Remarks:</label>
                                                  <textarea max-length="50" required="required" class="form-control" id="remarks" name="remarks" placeholder="Remarks" style="height: 250px"></textarea>
                                                
                                                </div>
                                              </div>

            </div>

            <div class="modal-footer">
             <button type="button" class="btn btn-success btn_complete_payout "><i class="flaticon-like"></i>Done</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="bank-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title" id="">Bank Details</h5>

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

</button>

</div>

<div class="modal-body">

<div class="col-xl-12">
<div class=" fv-plugins-icon-container">
<label style="margin: 0;  width:50%;  float: left;    padding: 12px 0;">Bank Name:</label>
<input  type="text" name="" readonly  class="form-control bank  form-control-lg" id="bank_name" style="width: auto;  float: left;    padding: 0 15px;    border: none;    margin: 0;">

</div>
</div>
<div class="col-xl-12">
<div class=" fv-plugins-icon-container">
<label style="margin: 0;  width:50%;   float: left;    padding: 12px 0;">Branch:</label>
<input  type="text" name="" readonly  class="form-control bank  form-control-lg" id="branch" style="width: auto;  float: left;    padding: 0 15px;    border: none;    margin: 0;">

</div>
</div>
<div class="col-xl-12">
<div class=" fv-plugins-icon-container">
<label style="margin: 0;   width:50%;  float: left;    padding: 12px 0;">Account No:</label>
<input  type="text" name="" readonly  class="form-control bank  form-control-lg" id="account_number" style="width: auto;  float: left;    padding: 0 15px;    border: none;    margin: 0;">

</div>
</div>
<div class="col-xl-12">
<div class=" fv-plugins-icon-container">
<label style="margin: 0;   width:50%;  float: left;    padding: 12px 0;">IFSC:</label>
<input  type="text" name="" readonly  class="form-control bank  form-control-lg" id="ifsc" style="width: auto;  float: left;    padding: 0 15px;    border: none;    margin: 0;">

</div>
</div>
<div class="col-xl-12">
<div class="form-group fv-plugins-icon-container">
<label style="margin: 0;    float: left;    padding: 12px 0;">Swift:</label>
<input  type="text" name="" readonly  class="form-control bank  form-control-lg" id="swift" style="width: auto;  float: left;    padding: 0 15px;    border: none;    margin: 0;">

</div>
</div>

</div>

<div class="modal-footer">


<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>



</div>

</div>

</div>

</div>

@endsection
@push('scripts')
<script type="text/javascript">


$(document).on('click','.btn_bank_details',function(){

var kitchen_id=$(this).data('id');
  $.ajax({

  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
  type: 'GET',
  data:{kitchen_id:kitchen_id},
  dataType : 'JSON', 
  url : '{{ route('admin.get-delivery-bank') }}',
  success: function(response){ 
      console.log(response.bank);
 
      if(response.bank)
      {
          $.each(response.bank, function(index, val) { 
                  console.log(index, val);
                  if(val!='null')
                  {
                    $('#'+index).val(val);
                  }
                
                });
          $('#bank-details').modal('show');
         
      }
     
  } 
    }); 



});
   





   $(function() {
   
     $('#delivery_partner_payout_request_table').DataTable({
   
         processing: true,
   
         serverSide: true,
   
         ajax: '{{ route("admin.delivery_partner_payout_requests") }}',
   
         columns: [
            { data: 'delivery_partner.name' ,name:'deliveryPartner.name'},
            { data: 'payout_group.name',name:'payoutGroup.name'},
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'total_orders' },
            { data: 'total_amount' },
            { data: 'payable_amount' },
            { data: 'payout_generated_date' },
            { data: 'payout_method' },
            { data: 'status' }
            ]
   
     });
   
     
     
   
   });
   setTimeout(function() 
   
   {
   
     $('#success_msg').fadeOut();
   
     },4000);
   
 $('table').on('click','.complete-payout', function(e){
        var delivery_partner_payout_id=$(this).data('id');
        var transaction_id=$('#transaction_id').val();
        var remarks=$('#remarks').val();
        $(document).on('click','.btn_complete_payout',function(){
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'GET',
			          data:{id:delivery_partner_payout_id,transaction_id:transaction_id,remarks:remarks},
			          dataType : 'JSON', 
			         url : '{{ route('admin.delivery_partner_complete_payout') }}',
			          success: function(response){ 
			              console.log(response.status);
			              if(response.status=='success')
			              {
				               $('#complete-payout').modal('hide');
				               $('#delivery_partner_payout_request_table').DataTable().ajax.reload();
				               toastr.success("Payment Completed successfully", "Success"); 
			              }
			              else if(response.status=='fail')
			              {
				               $('#complete-payout').modal('hide');
				               $('#delivery_partner_payout_request_table').DataTable().ajax.reload();
				                toastr.warning("Something Went Worng", "Warning");   
			              }
			          } 
		        }); 



   		 });
    });   
</script>
@endpush