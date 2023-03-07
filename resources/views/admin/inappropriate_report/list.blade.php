@extends('admin.layouts.app')
@section('Title', 'Inappropriate Report')
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
         <span class="text-muted font-weight-bold mr-4"> Inappropriate Report</span>
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
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-toolbar">
         <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
            <li class="nav-item">
               <a class="nav-link active feedback_tab" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab" id="inappropriate" data-type="customer" aria-selected="true">
               <i class="flaticon2-calendar-3"></i> Inappropriate Report
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link feedback_tab" data-toggle="tab" href="#kt_contacts_view_tab_2" role="tab" id="delivery" data-type="customer" aria-selected="false">
               <i class="flaticon2-calendar-3"></i> Report Delivery
               </a>
            </li>
         </ul>
      </div>
      </div>
    <!-- begin:: Content -->
  <div class="kt-portlet__body">
        <!--begin::Entry-->
        <div class="tab-content  kt-margin-t-20">
            <!--Begin:: Tab Content-->
         <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">

								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Inappropriate Report
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
			
									
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										 <table class="table table-separate table-head-custom table-checkable" id="inappropriate-report_table">
                                           <thead>
                                              <tr>
                                             
                                                 <th>Kitchen name</th>
                                                 <th>Customer </th>
                                                 <th>Reason </th>
                                                  <th>Remarks</th>
                                 
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
           <!--end::Tab Content-->
           <!--Begin:: Tab Content-->
         <div class="tab-pane active" id="kt_contacts_view_tab_2" role="tabpanel">
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">

								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label"> Report Delivery
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
			
									
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										 <table class="table table-separate table-head-custom table-checkable" id="delivery-report_table">
                                           <thead>
                                              <tr>
                                                <th>Order ID</th>
                                                 <th>Kitchen name</th>
                                                 <th>Customer </th>
                                                 <th>Reason </th>
                                                  <th>Remarks</th>
                                 
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
           <!--end::Tab Content-->
        </div>
  </div>
</div>
<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-danger btn_delete_Inappropriate Report "><i class="flaticon-delete-1"></i>Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
   $(function() {
   
     $('#inappropriate-report_table').DataTable({
   
         processing: true,
   
         serverSide: true,

        ajax: {
          url: '{{ route("admin.inappropriate-report.index") }}',
          data: function (d) {
                d.type = 0
               
            
            }
        },
         columns: [
            { data: 'kitchen.name.en' ,name:'kitchen.name'},
            { data: 'customer.name',name:'customer.name'},
            { data: 'reason' },
            { data: 'remarks' }
            ]
   
     });
   
      $('#delivery-report_table').DataTable({
   
         processing: true,
   
         serverSide: true,
   
         ajax: {
          url: '{{ route("admin.inappropriate-report.index") }}',
          data: function (d) {
                d.type = 1
               
            
            }
        },
   
         columns: [
            {data: 'order_id' ,name:'order_id'},
            { data: 'kitchen.name.en' ,name:'kitchen.name'},
            { data: 'customer.name',name:'customer.name'},
            { data: 'reason' },
            { data: 'remarks' }
            ]
   
     });
     
   
   });
   setTimeout(function() 
   
   {
   
     $('#success_msg').fadeOut();
   
     },4000);
   
   
</script>
@endpush