@extends('admin.layouts.app')

@section('Title', 'Users')

@section('subheader')
<!--begin::Content-->

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                Dashboard                            </h5>
            <!--end::Page Title-->

            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

            <span class="text-muted font-weight-bold mr-4">Information</span>

           
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
                      <h3 class="card-label">Information
 
                      <!--<span class="d-block text-muted pt-2 font-size-sm">extended pagination options</span></h3>-->
                    </div>
                   	<div class="card-toolbar">
											<!--begin::Dropdown-->
						                          <a href="{{route('admin.information.create')}}" class="btn btn-primary font-weight-bolder">
                      <i class="la la-plus"></i>   Add
                    </a>
									</div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="information_table">
                      <thead>
                        <tr>
                  
                       <th>Title</th>
                       <th>Short Description</th>
                       <th>Type</th>
                       <th>Sort Order</th>
                       <th>Status</th>
                       <th>Action</th>
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
      
            <!--end::Entry-->

</div>


<div class="modal fade" id="Delete_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_faq "><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

     $informationTable= $('#information_table').DataTable({

         processing: true,

         serverSide: true,

         ajax: '{{ route("admin.information.index") }}',

         columns: [
       
        
            { data: 'title', name: 'title' },
            { data: 'short_description' },
            { data: 'type' },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false }
            ]
         });
           $('table').on('click','.information-delete', function(e){
           var faq_href=$(this).data('href');

        $('.btn_delete_faq').click(function(){
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
          type: 'DELETE',
          //data:{},
          dataType : 'JSON', 
          url : faq_href,
          success: function(response){ 
            $('#Delete_Log').modal('hide');
            //category_list.ajax.reload(); 
            $('#faq_table').DataTable().ajax.reload();
            toastr.success("Faq deleted successfully", "Success"); 
             //$('#Delete_Log').close();
             
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