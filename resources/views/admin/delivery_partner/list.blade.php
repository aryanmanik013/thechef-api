@extends('admin.layouts.app')

@section('Title', 'Delivery Partners')

@section('subheader')
<!--begin::Content-->

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
               <a href="{{route('admin.home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                Dashboard           </h5></a>
            <!--end::Page Title-->

            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

            <span class="text-muted font-weight-bold mr-4">Delivery Partners</span>

           
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
						
    
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Delivery Partners
 
											<!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
										</div>
																<div class="card-toolbar">
											<!--begin::Dropdown-->
						  <a href="{{route('admin.delivery-partner.create')}}" class="btn btn-primary font-weight-bolder">
             <i class="la la-plus"></i>   Add
             </a>
            
									</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="delivery_partner_table">
											<thead>
												<tr>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Phone</th>
                       <th>Approval Status</th>
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




<div class="modal fade" id="delete_delivery_partner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_delivery_partner "><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="approve-deliveryPartner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="">Approve</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                </button>

            </div>

            <div class="modal-body">

            
                                    <div class="form-group row">
                                       
                                      <div class="col-lg-12">
                                      <div class="form-group fv-plugins-icon-container">
                                                <label>Payout Group :</label>
                                                <select class="form-control" name="payout_group_id" id="payout_group_id">
                                                  @foreach($payout_groups as $payout_group)

                                                  <option  value="{{$payout_group->id}}">{{$payout_group->name}}</option>
                                               @endforeach
                                                </select>

                                       </div>
                                          
                                      </div>

                                    </div> 

            </div>

            <div class="modal-footer">
             <button type="button" class="btn btn-success btn_approve_deliveryPartner "><i class="flaticon-like"></i>Approve</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

     $Table= $('#delivery_partner_table').DataTable({

         processing: true,

         serverSide: true,

         ajax: '{{ route("admin.delivery-partner.index") }}',

         columns: [

           

            { data: 'name'},
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'approve_status', name: 'approval_status' },
         
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false}

         ]

     });
     $('table').on('click','.delivery_partner_delete', function(e){
      var url=$(this).data('href');
        $('.btn_delete_delivery_partner').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : url,
          success: function(response){ 
            $('#delete_delivery_partner').modal('hide');
            $('#delivery_partner_table').DataTable().ajax.reload();
            toastr.success("Item  deleted successfully", "Success"); 
          } 
        }); 



    });
    });
    
     

   });
   setTimeout(function() 

  {

     $('#success_msg').fadeOut();

     },4000);



     $('table').on('click','.deliveryPartner-approve', function(e){

        var deliveryPartner_id=$(this).data('id');

  var payout_group_id=$('#payout_group_id').val();
        $(document).on('click','.btn_approve_deliveryPartner',function(){
            
          $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                type: 'GET',
                 data:{id:deliveryPartner_id,payout_group_id:payout_group_id},
                dataType : 'JSON', 
                url : '{{ route('admin.delivery_partner_approve') }}',
                success: function(response){ 
                    console.log(response.status);
                    if(response.status=='success')
                    {
                       $('#approve-deliveryPartner').modal('hide');
                       $('#delivery_partner_table').DataTable().ajax.reload();
                       toastr.success("Approved successfully", "Success"); 
                  
                    }
                    else if(response.status=='fail')
                    {
                       $('#approvedeliveryPartner').modal('hide');
                       $('#delivery_partner_table').DataTable().ajax.reload();
                         toastr.warning("Something Went Worng", "Warning");   
                    }
                } 
            }); 



       });
    });




</script>



@endpush