@extends('admin.layouts.app')

@section('Title', 'Reports')

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
											<h3 class="card-label">Reports
										
										</div>
										<div class="card-toolbar">
											<!--buttons-->
													
					
									    </div>
									</div>
									<div class="card-body">
						    		<div class="card card-custom">
							
									<div class="card-body">
									    <form method="POST" action="{{  route('admin.reportFilter') }}">
									       @csrf 
									       
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
                                         
                                          <select class="form-control"  id="" name="kitchen">
                                               <option value="">All</option>
                                               @foreach($kitchens as $key=>$kitchen)
                                              <option value="{{$key}}">{{$kitchen}}</option>
                                              @endforeach
                                            </select>
                                      
                                       </div>
                                        <div class="col-lg-4">
                                          <label>Status :</label>
                                         
                                          <select class="form-control"  id="" name="order_status_id">
                                               <option value="">All</option>
                                               @foreach($orderSatatus as $key=>$orderSatatus)
                                              <option value="{{$key}}">{{$orderSatatus}}</option>
                                              @endforeach
                                            </select>
                                      
                                       </div> 
                                       </div>
                                       <div class="form-group row">
                                           
                                        <div class="col-lg-4">
                                          <label>From :</label>
                                         
                                             <input type="text" class="form-control" placeholder="From" id="start_date" name="from" >
                                      
                                       </div> 
                                        <div class="col-lg-4">
                                          <label>To :</label>
                                       <input type="text" class="form-control" placeholder="To" id="to" name="to" >
                                       </div> 
                                       <div class="col-lg-4">
                                        <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                          
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                     </div>
                                     
                                 
									   
									 </div>
								
									   </form>  
						        <div class="card-spacer mt-n25">
            <!--begin::Row-->
            <div class="row m-0">
                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"><!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"/>
                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"/>
                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"/>
                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>                    
                    <a id="totalSales" href="{{route('admin.report')}}" class="text-warning font-weight-bold font-size-h6">
                        Total Sales ({{$reports->sum('total')}})
                    </a>
                </div>



                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"><!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg><!--end::Svg Icon--></span>                    
                <a id="totalOrder"  class="text-primary font-weight-bold font-size-h6 mt-2">
                        Total Orders({{$reports->count('total')}})
                    </a>
                </div>
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
							                        <th>Payment</th>
							                      
							                        <th>Total Products</th>
												</tr>
											</thead>
											<tbody>
											    @foreach($reports as $report)
											    @php
											     $totalItemCount=0;
                                                    
                                                    $totalItemCount=count($report->food);
											    @endphp
											    <tr>
											       <td>{{$report->invoice_prefix.$report->id}}</td>
											        <td>{{ date("d-m-Y",strtotime($report->created_at))}}</td>
											        <td>{{$report->name}}</td>
											        <td>{{$report->kitchen_name}}</td>
											        <td>{{$report->total}}</td>
											             <td>{{$report->status->name}}</td>
											              <td>{{$report->payment_method}}</td>
											              <td>{{ $totalItemCount}}</td>
											              
											        
											    </tr>
											    @endforeach
										
				
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

<script type="text/javascript">
       $('#start_date').datepicker({
           format: 'dd-mm-yyyy',
      
    todayHighlight : true,
           });
 $('#to').datepicker({
           format: 'dd-mm-yyyy',
      
    todayHighlight : true,
           });
  $(document).ready(function() {
  $('#order-table').DataTable( {
         
        buttons: [
            'print'
        ]
    });

    
  } );
 




</script>

@endpush