@extends('admin.layouts.app')
@section('Title', 'States')
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
         <span class="text-muted font-weight-bold mr-4">States</span>
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
               States 
               <!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
            </div>
            <div class="card-toolbar">
                <a href="{{route('admin.state.create')}}" class="btn btn-primary font-weight-bolder">
<i class="la la-plus"></i>	Add</a>
               <!--begin::Dropdown-->
            </div>
         </div>
         <div class="card-body">
        <form method="POST" action="{{  route('admin.reportFilter') }}">
        @csrf 
            <div class="form-group row">
                <div class="col-lg-4">
                <label>Country :</label>
                <select class="form-control"  id="country" name="country">
                <option value="">All</option>
               @foreach($countries as $key=>$country)
              <option value="{{$key}}">{{$country}}</option>
              @endforeach
                </select>
                </div>
        
            </div>
        </form>  
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="state_table">
               <thead>
                  <tr>
                     <th width="30%">Name</th>
                     <th width="30%">Country</th>
                     <th width="20%">Code</th>
                     <th width="10%">Status</th>
                     <th width="10%">Actions</th>
                    
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
<div class="modal fade" id="delete-state" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_state"><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>
@endsection
<!-- end:: Content -->
@push('scripts')
<script type="text/javascript">
   $(function() {
   
     stateTable= $('#state_table').DataTable({
   
         processing: true,
   
         serverSide: true,
         ajax: {
          url: '{{ route("admin.state.index") }}',
          data: function (d) {
                d.country= $('#country').val()
            
            }
        },
     
        //  ajax: '{{ route("admin.state.index") }}',
             columns: [
            { data: 'name', name: 'name' },
             { data: 'country_id', name: 'country_id' }, 

            { data: 'code', name: 'code'},

            { data: 'status', name: 'status'},
            { data: 'action', orderable: false}
   
         ]
   
     });
   $('#country').change(function(){
       
         stateTable.draw();
    });
    $('table').on('click','.state-delete', function(e){
           var state_href=$(this).data('href');

        $('.btn_delete_state').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : state_href,
          success: function(response){ 
            $('#delete-state').modal('hide');
            $('#state_table').DataTable().ajax.reload();
            toastr.success("State deleted successfully", "Success"); 
             
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