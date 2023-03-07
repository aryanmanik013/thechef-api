@extends('admin.layouts.app')

@section('Title', 'Feedback')

@section('subheader')
<!--begin::Content-->

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

            <span class="text-muted font-weight-bold mr-4">Feedback</span>

           
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
	<div class="kt-portlet kt-portlet--tabs">
   <div class="kt-portlet__head">
      <div class="kt-portlet__head-toolbar">
         <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
            <li class="nav-item">
               <a class="nav-link active feedback_tab" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab" id="customer" data-type="customer" aria-selected="true">
               <i class="flaticon2-calendar-3"></i> Customer
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link feedback_tab" data-toggle="tab" href="#kt_contacts_view_tab_2" role="tab" id="kitchen" data-type="customer" aria-selected="false">
               <i class="flaticon-piggy-bank"></i> Kitchen
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link feedback_tab" data-toggle="tab" href="#kt_contacts_view_tab_3" role="tab" id="delivery_partner" data-type="delivery_partner" aria-selected="false">
               <i class="flaticon-piggy-bank"></i> Delivery Partner
               </a>
            </li>
            
             

            
         </ul>
         
         
      </div>
      </div>
   <div class="kt-portlet__body">
      <div class="tab-content  kt-margin-t-20">
         <!--Begin:: Tab Content-->
         <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
						
    
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Feedback
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
			
									
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="feedback_customer_table">
											<thead>
												<tr>
												  
                         <th>Phone Number</th>
                          <th>Description</th> 
                          <th>User</th>
                          <!--<th>Source</th>-->
                        
                          <th>Actions</th>
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
</div>


  <div class="tab-pane" id="kt_contacts_view_tab_2" role="tabpanel">
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
						
    
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Feedback
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
			
									
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="feedback_kitchen_table">
											<thead>
												<tr>
												  
                         <th>Phone Number</th>
                          <th>Description</th> 
                          <th>User</th>
                          <!--<th>Source</th>-->
                          <!--<th>Type</th>-->
                          <th>Actions</th>
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
</div>

  <div class="tab-pane" id="kt_contacts_view_tab_3" role="tabpanel">
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
						
    
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Feedback
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
			
									
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="feedback_delivery_partner_table">
											<thead>
												<tr>
												  
                          <th>Phone Number</th>
                          <th>Description</th> 
                          <th>User</th>
                          <!--<th>Source</th>-->
                          <!--<th>Type</th>-->
                          <th>Actions</th>
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
</div>
</div>
</div>
</div>

<div class="modal fade" id="delete_feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_feedback "><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">
   $(function() {
     $('#feedback_customer_table').DataTable({

         processing: true,

         serverSide: true,

         ajax: {
          url: '{{ route("admin.feedback.index") }}',
          data: function (d) {
                d.type = 0
               
            
            }
        },

         columns: [
                   
              
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'name', name: 'name' },
                    // { data: 'source', name: 'source' },
                  
                    { data: 'action', orderable: false}
                ]

     });
          $('#feedback_kitchen_table').DataTable({

         processing: true,

         serverSide: true,

         ajax: {
          url: '{{ route("admin.feedback.index") }}',
          data: function (d) {
                d.type = 1
               
            
            }
        },

         columns: [
                   
              
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'name', name: 'name' },
                    // { data: 'source', name: 'source' },
                  
                    { data: 'action', orderable: false}
                ]

     });
          $('#feedback_delivery_partner_table').DataTable({

         processing: true,

         serverSide: true,

         ajax: {
          url: '{{ route("admin.feedback.index") }}',
          data: function (d) {
                d.type = 2
               
            
            }
        },

         columns: [
                   
              
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'name', name: 'name' },
                    // { data: 'source', name: 'source' },
                  
                    { data: 'action', orderable: false}
                ]

     });

})




    
 $('table').on('click','.feedback-delete', function(e){
      var area_feedback_href=$(this).data('href');
        $('.btn_delete_feedback').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : area_feedback_href,
          success: function(response){ 
            $('#delete_feedback').modal('hide');
           
            toastr.success("Item  deleted successfully", "Success"); 
             window.location.reload();
          } 
        }); 



    });
    });
     


   setTimeout(function() 

  {

     $('#success_msg').fadeOut();

     },4000);


</script>

@endpush