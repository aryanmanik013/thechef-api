@extends('admin.layouts.app')

@section('Title', 'User Roles & Access Permissions')

@section('subheader')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <a href="{{route('admin.home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                Dashboard                            </h5></a>
            <!--end::Page Title-->

            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

             <a href="{{route('admin.role.index')}}"><span class="text-muted font-weight-bold mr-4"> User Roles & Access Permissions</span></a>

           
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
								<!--begin::Notice-->
		
    
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label"> User Roles & Access Permissions
										
										</div>
										  <div class="card-toolbar">
                                          <a href="{{route('admin.role.create')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>Add</a>
                                        </div>
							
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="review-table">
											<thead>
												<tr>
											
												    <th>Name </th>
                                                    <th width="15%">Actions</th>
															
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




<div class="modal fade" id="delete-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="">Delete</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                </button>

            </div>

            <div class="modal-body">

                <p>Do you want to delete selected Data ?<br/>This Process cannot be Rolled Back</p>

            </div>

            <div class="modal-footer">
             <button type="button" class="btn btn-danger btn_delete_review "><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

     $customerTable= $('#review-table').DataTable({

         processing: true,

         serverSide: true,

         ajax: '{{ route("admin.role.index") }}',



              columns: [
                { data: 'name', name: 'name' },
                { data: 'action', orderable: false }
            ]
         	
         	

         

     });



     

   });



</script>

@endpush