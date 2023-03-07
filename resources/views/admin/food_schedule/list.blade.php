@extends('admin.layouts.app')

@section('Title', 'Food Schedule')

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

             <span class="text-muted font-weight-bold mr-4">Food Schedule</span>

           
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
											<h3 class="card-label">Food Schedule
										
										</div>
										
									</div>
									<div class="card-body">
			<div id="kt_calendar" class="fc fc-ltr fc-unthemed" style="">
					<div class="fc-toolbar fc-header-toolbar">
			
						<div class="fc-center">
							<h2>Week Food Schedule</h2></div>
					
					</div>
					<div class="fc-view-container">
						<div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
							<div class="fc-scroller" style="overflow: hidden auto; height: 748px;">
								<table class="fc-list-table ">
									<tbody>

									@foreach($food_schedule['day'] as $schedule)

										<tr class="fc-list-heading" data-date="2020-09-01">
											<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main"">{{$schedule['name']}}</a>

										<a href="{{route('admin.food-schedule.new',[$schedule['id'], $kitchen_id])}}" class="btn btn-light-warning fc-list-heading-alt">
										    <i class="flaticon-plus"></i>Food
										</a>

										</td>
										</tr>
										@if(!empty($schedule['details']))
										@foreach($schedule['details'] as $detail)
										<tr class="fc-list-item fc-event-danger fc-event-solid-warning">

											<td class="fc-list-item-time fc-widget-content">{{$detail->time}}</td>

											<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>

											<td class="fc-list-item-title fc-widget-content">
											@foreach($detail->scheduledFood as $scheduled_food)
											<a   data-toggle="popover"  data-html="true" title="{{$scheduled_food->KitchenFood->name}}" data-content="

                                           
											Quantity:{{$scheduled_food->quantity    }}<br>
											 Price:{{ number_format($scheduled_food->price,2)   }}
											



											 ">{{$scheduled_food->KitchenFood->name}}</a>

											<div class="fc-description">{{strip_tags($scheduled_food->KitchenFood->description)}}</div>


											<div style="float: right;">
												<!-- <a href="{{route('admin.food-schedule.edit',$scheduled_food->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a> -->

												<a  class="btn btn-sm btn-clean btn-icon schedule-delete" data-toggle="modal" data-target="#delete-schedule" data-href="{{route('admin.food-schedule.destroy',$detail->id)}}" title="Delete"><i class="la la-trash"></i></a>

											</div>

											@endforeach

											
											</td>

																		

										</tr>
										@endforeach
										@endif
										@endforeach

							
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
								
				</div>
			</div>
			<!--end::Card-->
				</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->




<div class="modal fade" id="delete-schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
             <button type="button" class="btn btn-danger btn_delete_schedule"><i class="flaticon-delete-1"></i>Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {



     $('table').on('click','.schedule-delete', function(e){

        var href=$(this).data('href');

        $('.btn_delete_schedule').click(function(){
		      $.ajax({

			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			          type: 'DELETE',
			          //data:{},
			          dataType : 'JSON', 
			          url : href,
			          success: function(response){ 
			              console.log(response.status);
			              if(response.status=='success')
			              {
				               $('#delete-schedule').modal('hide');
				               
				               toastr.success("Item deleted successfully", "Success"); 
				               location.reload();
			            
			              }
			              else if(response.status=='fail')
			              {
				                $('#delete-schedule').modal('hide');
				               
				              	 toastr.warning("You can't remove this item", "Warning");   
			              }
			          } 
		        }); 



   		 });
    });

    
     

   });



</script>

@endpush