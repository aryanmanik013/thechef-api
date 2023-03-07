<!--SAMAH-->
@extends('admin.layouts.app')
@section('Title', 'kitchen Type')
@section('subheader')
<!--<div class="content d-flex flex-column flex-column-fluid" id="kt_content">-->
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
  <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <!--begin::Info-->
    <div class="d-flex align-items-center flex-wrap mr-2">
      <!--begin::Page Title-->
      <a href="{{route('admin.home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5></a>
      <!--end::Page Title-->
      <!--begin::Actions-->
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
      <span class="text-muted font-weight-bold mr-4">Kitchens</span>
      <!--end::Actions-->
    </div>
    <!--end::Info-->
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
          <h3 class="card-label">Kitchens</h3>
        </div>
        <!--begin::Button-->
        <!--end::Button-->
        <div class="card-toolbar">
          <a href="{{route('admin.kitchen.create')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>Add</a>  
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-responsive table-separate table-head-custom table-checkable" id="kitchen_table">
          <thead>
            <tr>
           
              <th width=5%>Name</th>
              <th width=10%>Email</th>
              <th width=8%>Phone</th>
              <th width=7%>Country</th>
              <th width=7%>State</th>
              <th width=13%>City</th>
              <th width=10%>Approve</th>
              <th width=10%>Status</th>
              <th width=30%>Action</th>
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
<div class="modal fade" id="delete_kitchen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-danger btn_delete_kitchen "><i class="flaticon-delete-1"></i>Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="approve-kitchen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-success btn_approve_kitchen "><i class="flaticon-like"></i>Approve</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>
@endsection
@push('scripts')
<script type="text/javascript">
   $(function() {
   
     $kitchenTable= $('#kitchen_table').DataTable({
   
         processing: true,
   
         serverSide: true,
   
         ajax: '{{ route("admin.kitchen.index") }}',
   
         columns: [
          
            { data: 'name',name: 'name'},
            { data: 'email', name: 'email' },
            { data: 'phone',name: 'phone'},
            { data: 'country' },
            { data: 'state'},
            { data: 'city', name: 'city' },
            { data: 'approve_status', name: 'approval_status' },
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false}
            ]
   
     });
   
        $('table').on('click','.kitchen-delete', function(e){
      var kitchen_href=$(this).data('href');
        $('.btn_delete_kitchen').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : kitchen_href,
          success: function(response){ 
          


                 if(response.status=='success')
                    {
                        $('#delete_kitchen').modal('hide');
                        $('#kitchen_table').DataTable().ajax.reload();
                        toastr.success("kitchen   deleted successfully", "Success"); 
                  
                    }
                    else if(response.status=='fail')
                    {
                       $('#delete_kitchen').modal('hide');
                       
                        toastr.warning("Unable To Delete Kitchen", "Failed");    
                    }



          } 
        }); 
   
   
   
    });
    });
    
    $('table').on('click','.kitchen-approve', function(e){
        var kitchen_id=$(this).data('id');
        var payout_group_id=$('#payout_group_id').val();
        $(document).on('click','.btn_approve_kitchen',function(){
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'GET',
			          data:{id:kitchen_id,payout_group_id:payout_group_id},
			          dataType : 'JSON', 
			         url : '{{ route('admin.kitchen_approve') }}',
			          success: function(response){ 
			              console.log(response.status);
			              if(response.status=='success')
			              {
				               $('#approve-kitchen').modal('hide');
				               $('#kitchen_table').DataTable().ajax.reload();
				               toastr.success("Kitchen Approved successfully", "Success"); 
			              }
			              else if(response.status=='fail')
			              {
				               $('#approve-kitchen').modal('hide');
				               $('#kitchen_table').DataTable().ajax.reload();
				                toastr.warning("Something Went Worng", "Warning");   
			              }
			          } 
		        }); 



   		 });
    });
     
   
   });

   setTimeout(function() 
   
   {
   
     $('#success_msg').fadeOut();
   
     },4000);
   
   
</script>
@endpush