@extends('admin.layouts.app')
<!--begin::Content-->
@section('subheader')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
   <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
         <!--begin::Page Title-->
         <a href="{{route('admin.home')}}">
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"> Dashboard</h5>
         </a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <a href="{{route('admin.kitchen-food.index')}}"><span class="text-muted font-weight-bold mr-4">Kitchen Food</span> </a>
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $kitchen_food->id ? 'Edit' : 'Add' }} Kitchen Food</span> 
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
            <h3 class="card-title">{{ $kitchen_food->id ? 'Edit' : 'Add' }} Kitchen Food</h3>
         </div>
         <!--begin::Form-->
         <form class="form" action="{{ $kitchen_food->id ? route('admin.kitchen-food.update',$kitchen_food->id) : route('admin.kitchen-food.store') }}" id="weight-class-form" method="POST" enctype="multipart/form-data">
            @csrf
            {{ $kitchen_food->id ? method_field('PUT'):'' }}

          
            <div class="card-body">

             <div class="form-group row">
                  <div class="col-lg-6">

                      <label>Kitchen<span class="text-danger">*</span> :</label>
                 
                     <select  class="form-control" name="kitchen_id" required>
                       
                     <option value=""> select Kitchen</option>

                     @foreach($kitchens as $kitchen)

                       <option {{  old('kitchen_id', $kitchen_food->kitchen_id)==$kitchen->id?'selected':''}}  value="{{$kitchen->id}}">{{$kitchen->name}}</option>

                     @endforeach

                     </select>

                   @if($errors->has('kitchen_id'))
                     <div class="fv-plugins-message-container">
                        <div  class="fv-help-block">{{ $errors->first('kitchen_id') }}</div>
                     </div>
                     @endif


                  </div>

                   <div class="col-lg-6">
                     <label>Category<span class="text-danger">*</span> :</label>
           

                    <select  name="category_id[]" class="form-group"  data-fname="Category" multiple="multiple" id="category" required>

                         @foreach($categories as $key => $parent_category)
                      
                            <optgroup value="{{ $parent_category->id }}" label="{{ $parent_category->name }}">

                             <option value="{{$parent_category->id}}" 
                              @if(!empty($kitchen_food_categories)&& in_array($parent_category->id, $kitchen_food_categories)) selected="selected" @endif >{{$parent_category->name}}</option>
                         
                            @if($parent_category->children->count())
                              @foreach($parent_category->children as $subcategory)
                                <option value="{{$subcategory->id}}" @if(!empty($kitchen_food_categories)&& in_array($subcategory->id, $kitchen_food_categories)) selected="selected" @endif >{{$subcategory->name}}</option>
                              @endforeach
                              
                            @endif
                  
                            </optgroup>
                          @endforeach

                 </select>


                   @if($errors->has('category_id'))
                     <div class="fv-plugins-message-container">
                        <div  class="fv-help-block">{{ $errors->first('category_id') }}</div>
                     </div>
                     @endif
                  </div>
              </div>



               <div class="form-group row">
                  <div class="col-lg-6">
                     <label>Name<span class="text-danger">*</span> :</label>
                     <input  maxlength="100" type="text" placeholder=" Name" id="name" name="name" value="{{ old('name', $kitchen_food->name) }}" required="required" class="form-control" />
                     @if($errors->has('name'))
                     <div class="fv-plugins-message-container">
                        <div  class="fv-help-block">{{ $errors->first('name') }}</div>
                     </div>
                     @endif
                  </div>

                <div class="col-lg-6">
                  <label>Available Time<span class="text-danger">*</span> :</label>
                  <input  maxlength="100" type="text" readonly id="kt_timepicker_1" placeholder="Available Time" id="available_time" name="available_time" value="{{ old('available_time', $kitchen_food->available_time) }}"  class="form-control" required/>
                  @if($errors->has('available_time'))
                  <div class="fv-plugins-message-container">
                     <div  class="fv-help-block">{{ $errors->first('available_time') }}</div>
                  </div>
                  @endif
               </div>
          
               </div>
               <div class="form-group row">
                  <div class="col-lg-6">
                     <label >Description<span class="text-danger">*</span> :</label>
                     <textarea class="form-control editor" name="description" style="height: 250px">{{ old('description', $kitchen_food->description) }}</textarea>
                     @if($errors->has('description'))
                     <div class="fv-plugins-message-container">
                        <div  class="fv-help-block">{{ $errors->first('description') }}</div>
                     </div>
                     @endif
                  </div>
                  <div class="col-lg-6">
                     <label >Recipe Details<span class="text-danger">*</span> :</label>
                     <textarea class="form-control editor" name="recipe_details" style="height: 250px">{{ old('recipe_details', $kitchen_food->recipe_details) }}</textarea>
                     @if($errors->has('recipe_details'))
                     <div class="fv-plugins-message-container">
                        <div  class="fv-help-block">{{ $errors->first('recipe_details') }}</div>
                     </div>
                     @endif
                  </div>
               </div>
               <div class="form-group row">
               <div class="col-lg-6">
                  <label>Quantity<span class="text-danger">*</span> :</label>
                  <input   maxlength="100" type="number" placeholder="Quantity" id="quantity" name="quantity" value="{{ old('quantity', $kitchen_food->quantity) }}" required="required" class="form-control" />
                  @if($errors->has('quantity'))
                  <div class="fv-plugins-message-container">
                     <div  class="fv-help-block">{{ $errors->first('quantity') }}</div>
                  </div>
                  @endif
               </div>
               <div class="col-lg-6">
                  <label>Price<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Price" id="" name="price" value="{{ old('price', number_format($kitchen_food->price,2))}}" required="required">
                  @if($errors->has('price'))
                  <div class="fv-plugins-message-container">
                     <div  class="fv-help-block">{{ $errors->first('price') }}</div>
                  </div>
                  @endif
               </div>
            </div>
            <div class="form-group row">

              <div class="col-lg-6">
              
                   <label>Veg Status</label>
                     <select class="form-control" name="veg_status" > 
               
                
                      <option {{ old('veg_status',$kitchen_food->veg_status)== '1' ? 'selected' : '' }} value="1"> Non-Veg </option>
                      <option {{ old('veg_status',$kitchen_food->veg_status)== '0' ? 'selected' : '' }} value="0">Veg</option>
                   
                        </select>  
                  @if($errors->has('veg_status'))
                  <div class="error">{{ $errors->first('status') }}</div>
                  @endif
               </div>
        
                  
          
               <div class="col-lg-6">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $kitchen_food->status ==1 ? 'checked' : '' }} name="checkbox" id="check" value="0" >
                  <input type="hidden" name="status" id="val" value="@if($kitchen_food->id){{ old('status', $kitchen_food->status) }} @else 0 @endif">
                  <span></span>
                  </label>
                  </span>   
                  @if($errors->has('status'))
                  <div class="error">{{ $errors->first('status') }}</div>
                  @endif
               </div>
  


            </div>

                <div class="row">
                      <div class="col-lg-12">
                      <label>Gallery Image (272 x 276)</label>

                        
                    <div class="input-images-1" style="padding-top: .5rem;"></div>
                    

                   </div>
               </div>
      </div>
      <div class="card-footer">
      <div class="row">
      <div class="col-lg-6">
      </div>
      <div class="col-lg-6 text-right">
      <button type="submit" class="btn btn-primary mr-2">Save</button>
      <a class="btn btn-secondary" href="{{route('admin.kitchen-food.index')}}">Cancel</a>
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
@push('styles')
 <link href="{{ asset('assets/css/image-uploader.min.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" />
 @endpush
@push('scripts')

<script src="{{ asset('assets/js/image-upload.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('assets/js/bootstrap-multiselect.js') }}" type="text/javascript"></script> 
<script>


   $(function() {
   new KTImageInput('kt_image_1');
   });

    $('#kt_timepicker_1').timepicker();
</script>
<script>
 

    $(document).ready(function() {
        $('input[name="price"]').attr("onkeypress", "return isDecimal(this, event)");
        $('input[name="quantity"]').attr("onkeypress", "return isNumber(event)");
        
        $('#category').multiselect({
            enableClickableOptGroups: true,
             width: "100%",
        });
      
    });
</script>
</script>
<script>
   $(document).ready(function() {



          @if($kitchen_food->id)

          @if(!empty($kitchen_food->getMedia('gallery')))
        let preloaded = [
        @foreach($kitchen_food->getMedia('gallery') as $gallery)
            {id: {{$gallery->id}}, src:'{{$gallery->getUrl()}}'},
           
        @endforeach
        ];


        $('.input-images-1').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'gallery_images',
            preloadedInputName: 'old',
            preloadedDeleteUrl: "{{route('admin.image-gallery-delete')}}"
        });
        @else
        $('.input-images-1').imageUploader();

        @endif


        @else

        $('.input-images-1').imageUploader();

        @endif









   
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