<!--SAMAH-->

@extends('admin.layouts.app')
@section('Title', 'kitchen Details')
@section('subheader')
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
            <!--begin::Page Title-->
            <a href="{{route('admin.kitchen.index')}}"><span class="text-muted font-weight-bold mr-4">Kitchens</span></a>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4">Kitchen Details</span>
            <!--end::Actions-->
        </div>
        <!--end::Info-->
    </div>
</div>
<!--end::Subheader-->
@endsection
@section('content')
<div class="container">
   <!--Begin:: Portlet-->
   <div class="row">
      <div class="col-lg-12 order-1 order-xxl-2">
         <div class="card card-custom">
            <div class="kt-portlet">
               <div class="kt-portlet__body">
                  <div class="card-body">
                     <div class="kt-widget__top">
                        <div class="kt-widget__media kt-hidden">
                           <img src="" alt="image">
                        </div>
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-bolder kt-font-light">
                               @if(!empty($kitchen->getMedia('kitchen')->first()))
               <img src="{{$kitchen->getMedia('kitchen')->first()->getUrl()}}" style="width: 100%;"/>
            @else
                           <span class="text-uppercase">{{substr($kitchen->getTranslation('name','en'), 0, 2)}}</span>
                           @endif
                        </div>
                        <div class="kt-widget__content">
                           <div class="kt-widget__head">
                              <div class="kt-widget__user">
                                 <a href="#" class="kt-widget__username">
                                 {{$kitchen->getTranslation('name','en')}}                     
                                 </a>
                                 <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--unified-success">Kitchen </span>
                              </div>
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-new-email"></i> Email :{{$kitchen->email}} 
                           </div>
                           <div class="kt-widget__subhead">
                              <i class="flaticon2-placeholder"></i> Phone :  {{$kitchen->phone}} 
                           </div>
                           <div class="kt-widget__info">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--End:: Portlet-->
            <!--Begin:: Portlet-->
            <div class="card-body">
               <div class="kt-portlet__head">
                  <div class="kt-portlet__head-toolbar">
                     <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#kt_contacts_view_tab_1" role="tab">
                                <i class="la la-user"></i> General
                           </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_2" role="tab">
                                <i class="la la-address-book"></i> Address
                            </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#kt_contacts_view_tab_3" role="tab">
                                <i class="flaticon-piggy-bank"></i> Payment
                           </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_4" role="tab">
                                <i class="la la-image"></i> Album
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_5" role="tab">
                                <i class="la la-glass"></i> Today's Food Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_6" role="tab">
                                <i class="la la-glass"></i> Previously Posted Foods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_contacts_view_tab_7" role="tab">
                                <i class="la la-user"></i> Proof
                            </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="kt-portlet__body" style="width:100%;float:left;">
                  <div class="tab-content  kt-margin-t-20">
                     <!--Begin:: Tab Content-->
                     <div class="tab-pane active" id="kt_contacts_view_tab_1" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Personal Info:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$kitchen->getTranslation('name','en')}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Phone :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">  {{$kitchen->phone}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Email :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$kitchen->email}}</span>
                                             </div>
                                          </div>
                                           <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Short Description :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen_details->description)?strip_tags($kitchen_details->getTranslation('description','en')):''}}</span>
                                             </div>
                                          </div>
                                           <div class="form-group row">
                                             <label class="col-md-4 col-form-label">About :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen_details->about)?strip_tags($kitchen_details->getTranslation('about','en')):''}}</span>
                                             </div>
                                          </div>
                                           <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Specialities :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen_details->specialities)?strip_tags($kitchen_details->getTranslation('specialities','en')):''}}</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_2" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Contact Information:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Address 1 :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{$kitchen->address_line_1}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Address 2 :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">  {{$kitchen->address_line_2}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Street Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$kitchen->street_name}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Landmark :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$kitchen->landmark}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Postcode :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$kitchen->postcode}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Country :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen->country->name)?$kitchen->country->name:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">State :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen->state->name)?$kitchen->state->name:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">City :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{$kitchen->city}}</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                         <div class="tab-pane " id="kt_contacts_view_tab_3" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="row">
                                             <!--<label class="col-xl-3"></label>-->
                                             <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-md">Account Details:</h3>
                                             </div>
                                          </div>
                                          <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Bank Name :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{!empty($kitchen_banks->bank_name)?$kitchen_banks->bank_name:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Branch :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">  {{!empty($kitchen_banks->branch)?$kitchen_banks->branch:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Payment Method :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen_banks->payment_method)?$kitchen_banks->payment_method:''}}</span>
                                             </div>
                                          </div>
                                            <div class="form-group row ">
                                             <label class="col-md-4 col-form-label"> Account Number :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{!empty($kitchen_banks->account_number)?$kitchen_banks->account_number:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">IFSC :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">  {{!empty($kitchen_banks->ifsc)?$kitchen_banks->ifsc:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">SWIFT :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder"> {{!empty($kitchen_banks->swift)?$kitchen_banks->swift:''}}</span>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-md-4 col-form-label">Payout Group :</label>
                                             <div class="col-md-6">
                                                <span class="form-control-plaintext kt-font-bolder">{{ $kitchen->payoutGroup ? $kitchen->payoutGroup->name : '' }}</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_4" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                  
                                  
                                   <div class="mb-10 font-weight-bold text-dark">Featured</div>
                                            <div class="row mb-10">
                                              
                                                <div class="col-xl-12">
                                                <div class="image-input image-input-outline" id="kitchen-image">
                                                  <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{!empty($featured)? $featured->getUrl():asset('assets/media/logos/no-image.png')}});background-size: 100% 100%;"></div>
                                                  
                                                  </label> 
                                                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                  </span> 
                                                </div> 
                                              
                                               
                                              </div>
                                              </div>
                                               <div class="mb-10 font-weight-bold text-dark">Slider - Photos</div>
                                                <div class="row mb-10">
                                                                     
                                                  
                                                  
                                                     @foreach($kitchen->getMedia('slider') as $slider)
                                                      
                                                   <div class="col-xl-4">
                                                <div class="image-input image-input-outline" id="kitchen-image">
                                                  <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{$slider->getUrl()}});background-size: 100% 100%;"></div>
                                                  
                                                  </label> 
                                                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                  </span> 
                                                </div> 
                                              
                                               
                                              </div>
                                                   @endforeach 

                                                 </div>
               
                                               <div class="mb-10 font-weight-bold text-dark">Gallery - Photos</div>
                                                <div class="row mb-10">
                                                                     
                                               
                                                     @foreach($kitchen->getMedia('gallery') as $gallery)
                                                      
                                                   <div class="col-xl-4">
                                                <div class="image-input image-input-outline" id="kitchen-image">
                                                  <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{$gallery->getUrl()}});background-size: 100% 100%;"></div>
                                                  
                                                  </label> 
                                                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                  </span> 
                                                </div> 
                                              
                                               
                                              </div>
                                                   @endforeach 

                                                 </div>
               
                                            
                                        
                                          
                                           
                                              <div class="mb-10 font-weight-bold text-dark"> Videos</div>
                                                <div class="row">
                                                    @foreach($kitchen_videos as $video)
                                                    @php $url = substr($video->url, strpos($video->url, "v=") + 2); @endphp
                                              <div class="col-xl-6">
                                               
                                                <div class="image-input image-input-outline" id="kt_image_7" style="width:100%;background-image: url(assets/media/>users/blank.png)">
                                                  <div class="image-input-wrapper" style="width:100%;height:250px;"><iframe style="padding: 2px;border-radius: 5px;" width="100%" height="250" src="https://www.youtube.com/embed/{{$url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                                               
                                                  
                                                  
                                                  </span>
                                                </div>
                                              </div>
                                           @endforeach 

                                            </div>
                                         
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     
                     
                      <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_5" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                      
			<div id="kt_calendar" class="fc fc-ltr fc-unthemed" style="">
				
					<div class="fc-view-container">
						<div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
							<div class="fc-scroller" style="overflow: hidden auto; height: 748px;">
								<table class="fc-list-table ">
									<tbody>

									@foreach($food_schedule['day'] as $schedule)

										<tr class="fc-list-heading" data-date="2020-09-01">
											<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main">{{$schedule['name']}}</a>
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
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     
                     
                     
                      <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_6" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                  
                                
                                
                                	<div id="kt_calendar" class="fc fc-ltr fc-unthemed" style="">
				
                    					<div class="fc-view-container">
                    						<div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
                    							<div class="fc-scroller" style="overflow: hidden auto; height: 748px;">
                    								<table class="fc-list-table ">
                    									<tbody>
                    
                    									@foreach($kitchen_foods as $food)
                    
                    										<tr class="fc-list-heading" data-date="2020-09-01">
                    											<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main">{{$food->name}}</a>
                    										</td>
                    										</tr>
                    								
                    										<tr class="fc-list-item fc-event-danger fc-event-solid-warning">
                    
                    										
                    
                    											<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
                    
                    											<td class="fc-list-item-title fc-widget-content">
                    										
                    											<a   data-toggle="popover"  data-html="true" title="{{$food->name}}" data-content="">
                    
                                                               
                    											Quantity:{{$food->quantity    }}<br>
                    											 Price:{{ number_format($food->price,2)   }}</a>
                    
                    											<div class="fc-description">{{strip_tags($food->description)}}</div>

                    											</td>
                    										</tr>
                    									
                    										@endforeach
                    
                    							
                    									</tbody>
                    								</table>
                    							</div>
                    						</div>
                    					</div>
                    				</div>
      
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     <!--Begin:: Tab Content-->
                         <div class="tab-pane" id="kt_contacts_view_tab_7" role="tabpanel">
                        <form class="kt-form kt-form--label-left" action="">
                           <div class="kt-form__body">
                              <div class="kt-section kt-section--first">
                                 <div class="kt-section__body">
                                  <div class="row">
                                       <div class="col-md-6">
                                           <div class="mb-10 font-weight-bold text-dark"></div>
                                                <div class="row mb-10">
                                                  
                                                    <div class="col-xl-12">
                                                    <div class="image-input image-input-outline" id="kitchen-image">
                                                      <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{!empty($proof[0])? $proof[0]->getUrl():asset('assets/media/logos/no-image.png')}});background-size: 100% 100%;"></div>
                                                      
                                                      </label> 
                                                      <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                      </span> 
                                                    </div> 
                                                  </div>
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                           <div class="mb-10 font-weight-bold text-dark"></div>
                                                <div class="row mb-10">
                                                  
                                                    <div class="col-xl-12">
                                                    <div class="image-input image-input-outline" id="kitchen-image">
                                                      <div class="image-input-wrapper" style="width:325px;height:140px;background-image: url({{!empty($proof[1])? $proof[1]->getUrl():asset('assets/media/logos/no-image.png')}});background-size: 100% 100%;"></div>
                                                      
                                                      </label> 
                                                      <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image"><i class="ki ki-bold-close icon-xs text-muted"></i>
                                                      </span> 
                                                    </div> 
                                                  </div>
                                                  </div>
                                            </div>
                                        </div> 
                                 </div>
                              </div>
                           </div>
                           <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                           <div class="kt-form__actions">
                           </div>
                        </form>
                     </div>
                     <!--End:: Tab Content-->
                     
                     
                     <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                     <div class="kt-form__actions">
                     </div>
                  </div>
                  <!--End:: Tab Content-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection