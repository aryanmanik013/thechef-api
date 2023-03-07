@extends('admin.layouts.app')

@section('Title', 'Reviews')

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

             <a href="{{route('admin.review.index')}}"><span class="text-muted font-weight-bold mr-4">Reviews</span></a>

           
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
											<h3 class="card-label">Reviews
										
										</div>
							
									</div>
									<div class="card-body">
									    		  <div class="form-group row">
									      <div class="col-lg-4">
                                          <label>Filter by kitchen :</label>
                                         
                                          <select class="form-control"  id="Filter" name="filter">
                                            
                                              <option value="">All</option>
                                               @foreach($kitchens as $key=>$kitchen)
                                              <option value="{{$key}}">{{$kitchen}}</option>
                                              @endforeach
                                          </select>
                                      
                                       </div>
                                     </div>
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="review-table">
											<thead>
												<tr>
											
												    <th>customer</th>
												    <th>Kitchen</th>
												   
												    <!-- <th>Title</th> -->
													<th>Description</th>
													<th>Rating</th>
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

    reviewTable=  $('#review-table').DataTable({

           processing: true,

         serverSide: true,

         
        ajax: {
          url: '{{ route("admin.review.index") }}',
          data: function (d) {
                d.kitchen = $('#Filter').val()
             
            }
        },

         columns: [

            { data: 'customer.name', name: 'customer.name' },
            { data: 'kitchen.name.en',name: 'kitchen.name' },
	  
	        // { data: 'heading' },
	        { data: 'description',searchable: false },
	        { data: 'rating',searchable: false },
	        { data: 'status',searchable: false }
              ]

     });


     $('#Filter').change(function(){
       
         reviewTable.draw();
    });
     

   });
  $('table').on('click','.review-delete', function(e){
      var review_href=$(this).data('href');
      $('.btn_delete_review').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : review_href,
          success: function(response){ 
          


                 if(response.status=='success')
                    {
                        $('#delete-review').modal('hide');
                        $('#review-table').DataTable().ajax.reload();
                        toastr.success("Review deleted successfully", "Success"); 
                  
                    }
                    else if(response.status=='fail')
                    {
                       $('#delete-review').modal('hide');
                       
                        toastr.warning("Unable To Delete Review", "Failed");    
                    }



          } 
        }); 
   
      }); 
   
    });


  $(document).on('change','.change_status',function(){
        var value=$(this).data('val');
        var customer_id=$(this).data('id');
        
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'POST',
			          data:{id:customer_id,value:value},
			          dataType : 'JSON', 
			         url : '{{ route('admin.changeReviewStatus') }}',
			          success: function(response){ 
			              console.log(value);
			              if(response=='success')
			              {
			                    $('#review_table').DataTable().ajax.reload();
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