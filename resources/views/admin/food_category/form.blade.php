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
            Dashboard                           
         </h5></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <!--begin::Page Title-->
         <a href="{{route('admin.food_category.index')}}">
         <span class="text-muted font-weight-bold mr-4">
            Food Categories                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $foodcategory->id ? 'Edit' : 'Add' }} Food Category</span> 
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
            <h3 class="card-title">{{ $foodcategory->id ? 'Edit' : 'Add' }} Food Category</h3>
         </div>
         <!--begin::Form-->
         <form class="form" action="{{ $foodcategory->id ? route('admin.food_category.update',$foodcategory->id) : route('admin.food_category.store') }}" id="store-type-form" method="POST" enctype="multipart/form-data">
            @csrf
            {{ $foodcategory->id ? method_field('PUT'):'' }}
            <div class="card-body">
               <div class="form-group row">
                  <div class="col-lg-6">
                       <div class="col-lg-12 form-group">
                     <label>Name<span class="text-danger">*</span> :</label>
                     <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $foodcategory->getTranslation('name','en')) }}" required="required">
                     @if($errors->has('name'))
                     <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                     @endif
                  </div>

                          <div class="col-lg-12 form-group">
                            <label>Parent:</label>
                                   <select   name="parent_id" class="form-control kt-select2 category">
                             <option value="0" selected="">Select</option>
                          @foreach($categories as  $food_category)
                          
                                <optgroup value="{{ $food_category->id }}" label="{{ $food_category->name }}">
                               @php 
                                
                                @endphp
                                @if(!empty($food_category->child))
                                  @foreach($food_category->child as $subcategory)
                                    <option value="{{$subcategory->id}}" {{ old('parent',$subcategory->id)==$foodcategory->parent_id ? 'selected': '' }}>{{$subcategory->name}}</option>
                                  @endforeach

                                @endif
                                  <option value="{{$food_category->id}}" {{ old('parent',$food_category->id)==$foodcategory->parent_id ? 'selected': '' }}>{{$food_category->name}}</option>
                      
                                </optgroup>
                              @endforeach
                                        
                                  </select> 
                            @if($errors->has('parent_id'))

                              <div class="fv-plugins-message-container">
                                    <div  class="fv-help-block">{{ $errors->first('parent_id') }}</div>
                                </div>
                                    
                            @endif
                            
                       
                          
                        </div>
                   <div class="col-lg-12 form-group">
                       <label>Sort Order<span class="text-danger">*</span> :</label>
                     <input type="text" class="form-control" placeholder="Sort Order"  name="sort_order" value="{{ old('sort_order', $foodcategory->sort_order) }}" required="required">
                     @if($errors->has('sort_order'))
                     <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('sort_order')}}</div>
                                  </div>
                     @endif
                    </div>
                     <div class="col-lg-12">
                     <div class="row form-group">
                           <div class="col-lg-6">
                           <label style="float:left;margin: 7px 10px 0 0;">Status:</label>
                     <span class="switch switch-outline switch-icon switch-success" style="float:left;">
                     <label>
                     <input type="checkbox" {{ $foodcategory->status ==1 ? 'checked' : '' }} name="select" id="check" />
                     <span><span>
                     <input type="hidden" name="status" id="val" value="@if($foodcategory->id){{ old('status', $foodcategory->status) }} @else 0 @endif">
                     </span></span>
                     </label>
                     </span>
                     @if($errors->has('status'))
                     <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('status')}}</div>
                                  </div>
                     @endif
                     </div>
                     
                         <div class="col-lg-6" style="margin-top:6px;">
                <label class="checkbox checkbox-success">
                    <input style="margin-right:5px;" type="checkbox"  name="popular" {{ $foodcategory->popular ==1 ? 'checked' : '' }}/>
                    <span ></span>
                    Popular
                </label>
                   @if($errors->has('popular'))
                     <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('popular')}}</div>
                                  </div>
                     @endif
                   </div>
                   </div>
                   </div>
                  </div>
                  
                      
               <div class="col-lg-6">
                    <div class="col-lg-12 form-group">
                  <label>Description<span class="text-danger">*</span> :</label>
                  <textarea name="description" class="form-control summernote" id="exampleTextarea" rows="3">{{ old('description', $foodcategory->getTranslation('description','en')) }} </textarea>
                  @if($errors->has('description'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('description')}}</div>
                                  </div>
                  @endif
               </div>
             
         
											 <div class="col-lg-6 form-group">
												    
													<div class="image-input image-input-outline" id="kt_image_1" style="width:100%;">
														<div class="image-input-wrapper" style="background-image: url({{$foodcategory->getMedia('category')->first() ? $foodcategory->getMedia('category')->first()->getUrl():asset('assets/media/logos/no-image.png')}});    width: 100%; height: 200px;background-size: 100% 100%;"></div>
														<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
															<i class="fa fa-pen icon-sm text-muted"></i>
															<input type="file" name="image" accept=".png, .jpg, .jpeg" />
															<input type="hidden" name="profile_avatar_remove" />
														</label>
														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
													</div>
													<span class="form-text text-muted">Allowed file types: png, jpg, jpeg.(208 x 208)</span>
													     @if($errors->has('image'))
                                   
                                 <div class="fv-plugins-message-container">
                                    <div  class="fv-help-block">{{ $errors->first('image') }}</div>
                                    </div>
                            @endif
												</div>
											</div>
											</div>
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                     <a class="btn btn-secondary" href="{{route('admin.food_category.index')}}">Cancel</a>
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
<script type="text/javascript">
   $(document).ready(function() {

    $('.category').select2();
   
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