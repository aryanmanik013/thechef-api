@extends('admin.layouts.app')
@section('Title', 'Customers')
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
         <span class="text-muted font-weight-bold mr-4">Customers</span>
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
<!-- begin:: Content -->
@section('content')
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
      <div class="card card-custom">
         <div class="card-header flex-wrap py-5">
            <div class="card-title">
               <h3 class="card-label">
               Customers 
               <!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
            </div>
            <div class="card-toolbar">
               <!--begin::Dropdown-->
            </div>
         </div>
         <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="customer_table">
               <thead>
                  <tr>
                     <th width=20%>Name</th>
                     <th width=20%>Email</th>
                     <th width=20%>Phone</th>
                       <th width=20%>Status</th>
                     <th width=20%>Actions</th>
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
<div class="modal fade" id="Delete_Log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
         </div>
         <div class="modal-body">
            <p>Do you want to delete selected Data ?<br/>This Process cannot be Rolled Back</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger btn_delete_customer "><i class="flaticon-delete-1"></i>Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
@endsection
<!-- end:: Content -->
@push('scripts')
<script type="text/javascript">
  $('#check').click(function(){

         if ($('#check').is(":checked"))

            {

             $("#val").attr( "value", "1" );

            } 

            else{

                $("#val").attr( "value", "0" );

            }
         

        });
   $(function() {
   
     $customerTable= $('#customer_table').DataTable({
   
         processing: true,
   
         serverSide: true,
   
         ajax: '{{ route("admin.customer.index") }}',
   
         columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name:'email' },
            { data: 'phone', name:'phone'},
             { data: 'status', name: 'status' },
            { data: 'action', orderable: false}
   
         ]
   
     });
   });
   setTimeout(function() 
   
   {
   
     $('#success_msg').fadeOut();
   
     },4000);
   
    $(document).on('change','.change_customer_status',function(){
        var value=$(this).data('val');
        var customer_id=$(this).data('id');
        
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'POST',
			          data:{id:customer_id,value:value},
			          dataType : 'JSON', 
			         url : '{{ route('admin.changeCustomerStatus') }}',
			          success: function(response){ 
			              console.log(value);
			              if(response=='success')
			              {
			                    $('#customer_table').DataTable().ajax.reload();
				              toastr.success("Status Updated successfully", "Success"); 
			              }
			              else if(response=='fail')
			              {
				            toastr.warning("Something Went Worng", "Warning");   
			              }
			          } 
		        }); 



   		 });
</script>
@endpush