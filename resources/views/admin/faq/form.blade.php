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
         <a href="{{route('admin.faq.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          Faq                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{ $faq->id ? 'Edit' : 'Add' }} Faq</span> 
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
         <h3 class="card-title">{{ $faq->id ? 'Edit' : 'Add' }} Faq</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{ $faq->id ? route('admin.faq.update',$faq->id): route('admin.faq.store') }}" method="post">
         @csrf
         {{ $faq->id ? method_field('PUT'):'' }}
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                      <div class="col-lg-12 form-group">
                  <label>Question<span class="text-danger">*</span> :</label>
                  <input type="text" name="question" class="form-control"  placeholder="Question" value="{{ old('question', $faq->getTranslation('question','en')) }}" required="required">
                  @if($errors->has('question'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('question')}}</div>
                                  </div>
                  @endif
               </div>
                 <div class="col-lg-12 form-group">
                             <label>Type<span class="text-danger">*</span> :</label>
                            

                            <select name="type" class="form-control">
                                
                                <option value="0" {{ old('type',$faq->type)==0 ? 'selected' : '' }}>Customer</option>
                                     <option value="1" {{ old('type',$faq->type)==1 ? 'selected' : '' }}>Kitchen</option>
                                   
                            </select>
                             
                           </div>
              <div class="col-lg-12 form-group">
                 
                  <label>Sort Order<span class="text-danger">*</span> :</label>
                  <input type="text" class="form-control" placeholder="Sort Order"  name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" required="required">
                  @if($errors->has('sort_order'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('sort_order')}}</div>
                                  </div>
                  @endif
               </div>
               <div class="col-lg-12 form-group">
                  <label>Status:</label>
                  <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" {{ $faq->status ==1 ? 'checked' : '' }} name="select" id="check" />
                  <span><span>
                  <input type="hidden" name="status" id="val" value="@if($faq->id){{ old('status', $faq->status) }} @else 0 @endif">
                  </span></span>
                  </label>
                  </span>
                  @if($errors->has('status'))
                  <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('status')}}</div>
                                  </div>
                  @endif
               </div>
               </div>
                 <div class="col-lg-6">
                  <label>Answer<span class="text-danger">*</span> :</label>
                  <textarea name="answer" class="form-control summernote" id="exampleTextarea" rows="3">{{ old('answer', $faq->getTranslation('answer','en')) }} </textarea>
                  @if($errors->has('answer'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('answer')}}</div>
                                  </div>
                  @endif
               </div>
               </div>
             
            <div class="form-group row">
             
               
            </div>
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                    <a class="btn btn-secondary" href="{{route('admin.faq.index')}}">Cancel</a>
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
<script type="text/javascript">
//CKEDITOR.replace( 'answr' );
</script>

<script type="text/javascript">
   $(document).ready(function() {
   
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