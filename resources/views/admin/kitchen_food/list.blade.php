@extends('admin.layouts.app')

@section('Title', 'Kitchen Food')

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

           <span class="text-muted font-weight-bold mr-4">Kitchen Food</span>

           
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
											<h3 class="card-label">Kitchen Food
										
										</div>
										<div class="card-toolbar">
											<!--buttons-->
													<a href="{{route('admin.kitchen-food.create')}}" class="btn btn-primary font-weight-bolder">
													  <i class="la la-plus"></i>
																Add
														</a>
					
									    </div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="kitchen_food-table">
											<thead>
												<tr>
											
												    <th>Image</th>
												    <th>Name</th>
												    <th>kitchen</th>
												    <th>Quantity</th>
												    <th>Price</th>
												    <th>Status</th>
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




<div class="modal fade" id="delete-kitchen_food" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_kitchen_food "><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

     $customerTable= $('#kitchen_food-table').DataTable({

         processing: true,

         serverSide: true,

         ajax: '{{ route("admin.kitchen-food.index") }}',

         columns: [

	        { data: 'image' },
            { data: 'name', name: 'name' },
            { data: 'kitchen.name.en',name: 'kitchen.name' },
            { data: 'quantity' },
            { data: 'price' },
	      	{ data: 'status' },
         	{ data: 'action', orderable: false}

         ]

     });


     $('table').on('click','.kitchen_food-delete', function(e){

        var option_href=$(this).data('href');

        $('.btn_delete_kitchen_food').click(function(){
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'DELETE',
			          //data:{},
			          dataType : 'JSON', 
			          url : option_href,
			          success: function(response){ 
			              console.log(response.status);
			              if(response.status=='success')
			              {
				               $('#delete-kitchen_food').modal('hide');
				               $('#kitchen_food-table').DataTable().ajax.reload();
				               toastr.success("Item deleted successfully", "Success"); 
			            
			              }
			              else if(response.status=='fail')
			              {
				                $('#delete-kitchen_food').modal('hide');
				               $('#kitchen_food-table').DataTable().ajax.reload();
				              	 toastr.warning("You can't remove this item", "Warning");   
			              }
			          } 
		        }); 



   		 });
    });

    
     

   });



</script>

@endpush