@extends('admin.layouts.app')


<!--begin::Content-->

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

                 <a href="{{route('admin.banner.index')}}"><span class="text-muted font-weight-bold mr-4">Banners</span> </a>

              <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

                <span class="text-muted font-weight-bold mr-4">{{ $banner->id ? 'Edit' : 'Add' }} Banner</span>
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

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
          
<div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
            <h3 class="card-title">{{ $banner->id ? 'Edit' : 'Add' }} Banner
            </h3>
            
            </div>
            <!--begin::Form-->
            <form class="form" action="{{ $banner->id ? route('admin.banner.update',$banner->id) : route('admin.banner.store') }}" id="banner-form" method="POST" enctype="multipart/form-data">
            @csrf
            {{ $banner->id ? method_field('PUT'):'' }}
            <input type="hidden" value="{{$banner->activity}}" id="banner_activity">
            <div class="card-body">
                                      
                        <div class="form-group row">
          
                        <div class="col-lg-6">
                                 <label>Activity <span class="text-danger">*</span> :</label>
                                 <select  class="form-control notification_type" name="activity" required>
                                  <option value="">Select Activity</option>
                               
                                   <option value="Information" @if($banner->activity=='Information') selected="selected" @endif >Information</option>
                                  <option value="KitchenDetail" @if($banner->activity=='KitchenDetail') selected="selected" @endif >Kitchen</option>
                               
                                
                                 </select>
                            </div>
                      
                    <div class="col-lg-6" id="infoDiv" >
                         <label>Parameter <span class="text-danger">*</span> :</label>
                        <select  class="form-control " name="parameter">
                        
                       @foreach($information as $info)
                           <option value="{{$info->id}}"  @if($banner->parameter==$info->id) selected="selected"  @endif>{{$info->getTranslation('title',app()->getLocale())}}</option>
                        @endforeach
                       
                        
                         </select>
                      </div>
                           <div class="col-lg-6" id="storeDiv" style="display:none">
                     <label>Parameter <span class="text-danger">*</span> :</label>
                      <select  class="form-control " name="parameter">
                        @foreach($kitchens as $kitchen)
                           <option value="{{$kitchen->id}}" @if($banner->parameter==$kitchen->id) selected="selected"  @endif>{{$kitchen->getTranslation('name',app()->getLocale())}}</option>
                        @endforeach
                         </select>
                  </div>
                   </div>
                    <div class="form-group row">
                    <div class="col-lg-6">
                    <label>Sort Order<span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" placeholder="Sort Order" id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" required="required">
                    
                    @if($errors->has('sort_order'))
                    
                    <div class="fv-plugins-message-container">
                    <div  class="fv-help-block">{{ $errors->first('sort_order') }}</div>
                    </div>
                    @endif
                    </div>
                    <div class="col-lg-6">
                    <label>Status:</label>
                    <span class="switch switch-outline switch-icon switch-success ">
                    
                    <label>
                    
                    <input type="checkbox" {{ $banner->status ==1 ? 'checked' : '' }} name="checkbox" id="check" value="0" >
                    
                    <input type="hidden" name="status" id="val" value="@if($banner->id){{ old('status', $banner->status) }} @else 0 @endif">
                    
                    <span></span>
                    
                    </label>
                    
                    </span>   
                    
                    @if($errors->has('status'))
                    
                    <div class="fv-plugins-message-container">
                    <div  class="fv-help-block">{{ $errors->first('status') }}</div>
                    </div>
                    @endif
                    </div> 
                    </div>
                    <div class="form-group row">
                    <div class="col-lg-12">
                    
                    <div class="image-input image-input-outline" id="kt_image_1" style="width:100%;">
                    <div class="image-input-wrapper" style="background-image: url({{$banner->id ? $banner->getMedia('banner')->first()->getUrl():asset('assets/media/logos/no-image.png')}});    width: 100%; height: 200px;background-size: 100% 100%;"></div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="profile_avatar_remove" />
                    </label>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                    </div>
                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg. (794 x 406)</span>
                    @if($errors->has('image'))
                    
                    <div class="fv-plugins-message-container">
                    <div  class="fv-help-block">{{ $errors->first('image') }}</div>
                    </div>
                    @endif
                    </div>
                    </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                        </div>
                                                        <div class="col-lg-6 text-right">
                                                             <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                            <a href="{{route('admin.banner.index')}}" class="btn btn-secondary">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--end::Form-->
                                        </div>




    



<!--begin::Row-->
      </div>

</div>
<!--end::Entry-->
                
<!--end::Content-->


@endsection
@push('scripts')
<script>
$(function() {
new KTImageInput('kt_image_1');
});
</script>
<script>
$(function() {
$('.summernote').summernote({
            height: 400,
            tabsize: 2
        });
});
</script>

<script>
    $(document).ready(function() {
     var activity=$('#banner_activity').val(); 
      if(activity=='KitchenDetail')
      {
        $('#storeDiv').show();
        $('#infoDiv').hide();   
      }
      else
      {
         $('#storeDiv').hide();
         $('#infoDiv').show();  
      }
    $('.notification_type').change(function(){
      var type=$(this).val();
      //alert(type);
      if(type=='KitchenDetail'){
        $('#storeDiv').show();

        $('#infoDiv').hide();
      
       
      }
      else if(type=='Information')
      {
         $('#storeDiv').hide();
         $('#infoDiv').show();
        
      
      }
      else
      {
         $('#storeTypeDiv').hide();
         $('#infoDiv').hide();
       
         
      }
  

    });

        $('#check').click(function(){

         if ($('#check').is(":checked"))

            {

             $("#val").attr( "value", "1" );

            } 

            else{

                $("#val").attr( "value", "0" );

            }
         

        });

    });
</script>
@endpush