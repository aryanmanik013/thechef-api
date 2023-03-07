@extends('admin.layouts.app')

@section('Title', 'Orders')

@section('subheader')
<!--begin::Content-->

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

            <span class="text-muted font-weight-bold mr-4">Orders</span>

           
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
											<h3 class="card-label">Orders
										
										</div>
										<div class="card-toolbar">
											<!--buttons-->
													
					
									    </div>
									</div>
									<div class="card-body">
									    
									    
									     <div class="form-group row">
									      <div class="col-lg-4">
                                          <label>Sort :</label>
                                         
                                          <select class="form-control"  id="Filter" name="filter">
                                               <option value="">All</option>
                                              <option value="today">Today</option>
                                               <option value="week">Week</option>
                                                <option value="year">Year</option>
                                          </select>
                                      
                                       </div>
                                       <div class="col-lg-4">
                                          <label>Kitchen :</label>
                                           <!--<input type="text" class="auto-width search-form" id="searchInput" name="searchInput" placeholder="Search Kitchen"> -->
                                          <select class="form-control"  id="Kitchen" name="kitchen" >
                                                <option value="">All</option>
                                               @foreach($kitchens as $key=>$kitchen)
                                              <option value="{{$key}}">{{$kitchen}}</option>
                                              @endforeach
                                            </select>
                                      
                                       </div>
                                        <div class="col-lg-4">
                                          <label>Status :</label>
                                         
                                          <select class="form-control"  id="Status" name="order_status_id">
                                               <option value="">All</option>
                                               @foreach($orderSatatus as $key=>$orderSatatus)
                                              <option value="{{$key}}">{{$orderSatatus}}</option>
                                              @endforeach
                                             
                                            </select>
                                      
                                       </div> 
                                       </div>
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="order-table">
											<thead>
												<tr>
											
				                                    <th>Invoice Id</th>
							                        
							                        <th>Order Date</th>
							                        <th>Customer Name</th>
							                        <th>Kitchen Name</th>
							                        <th>Amount</th>
							                        <th>Order Status</th>
							                        <th>Payment Method</th>
							                       
							                        <th>View</th>
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






@endsection

@push('scripts')
<!--<script src="{{ asset('assets/js/autocomplete.js') }}"></script>-->
<script type="text/javascript">

   $(function() {

     orderTable= $('#order-table').DataTable({

         processing: true,

         serverSide: true,
          ajax: {
          url: '{{ route("admin.order.index") }}',
          data: function (d) {
                d.filter = $('#Filter').val(),
                d.kitchen= $('#Kitchen').val(),
                d.statusId= $('#Status').val()
            
            }
        },

         columns: [
                { data: 'id', orderable: false },
                { data: 'created_at' },
                { data: 'name', name: 'name' },
                { data: 'kitchen_name',name:'kitchen_name'},
                { data: 'total' },
                { data: 'status' },
                { data: 'payment_method' },
                { data: 'action', orderable: false}
         ]

     });





    
     

   });
     $('#Filter').change(function(){
       
         orderTable.draw();
    });
     $('#Kitchen').change(function(){
       
         orderTable.draw();
    });
     $('#Status').change(function(){
       
         orderTable.draw();
    });

</script>
<script type="text/javascript">
    // $(document).ready(function(){
    //   console.log('search');
    //   $("#searchInput").autocomplete({
    //     source: "{{ url('autocompleteajax') }}",
    //     minLength: 1,
    // select: function(event, ui) {
    //   $("#searchInput").val(ui.item.value);
    //   $("#Kitchen").val(ui.item.id);
    //   }
    //   }).data("ui-autocomplete")._renderItem = function( ul, item ) {
    //     return $( "<li class='ui-autocomplete-row'></li>" )
    //   .data( "item.autocomplete", item )
    //   .append( item.label )
    //   .appendTo( ul );
    // };
    // });
    </script>

@endpush