<!--SAMAH-->
@extends('admin.layouts.app')
<!--begin::Content-->
@section('subheader')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Page Title-->
            <a  href="{{ route('admin.home') }}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5></a>
            <!--end::Page Title-->
            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <a href="{{route('admin.information.index')}}"><span class="text-muted font-weight-bold mr-4">Information</span></a> 
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4">{{ $information->id ? 'Edit' : 'Add' }} Information</span> 
            <!--end::Actions-->
        </div>
        <!--end::Info-->
    </div>
</div>
 <!--end::Subheader-->
@endsection
@section('content')
<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class=" container">    
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">{{ $information->id ? 'Edit' : 'Add' }} information</h3> 
            </div>
            <!--begin::Form-->
            <form class="form" action="{{ $information->id ? route('admin.information.update',$information->id) : route('admin.information.store') }}" method="post">
            @csrf
                {{ $information->id ? method_field('PUT'):'' }}
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                             <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Title <span class="text-danger">*</span> :</label>
                                    <input  maxlength="100" type="text" placeholder="Title" id="title" name="title" value="{{ old('title', $information->getTranslation('title','en')) }}" required="required" class="form-control" />
                                    @if($errors->has('title'))
                                        <div class="fv-plugins-message-container">
                                            <div  class="fv-help-block">{{ $errors->first('questtion') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                     <label>Short Descriptions <span class="text-danger">*</span> :</label>
                                    <textarea max-length="100" class="form-control " id="short_description" name="short_description" placeholder="Short Descriptions">{{ old('short_description', $information->getTranslation('short_description','en')) }}</textarea>
                                 @if($errors->has('short_description'))
                                        <div class="fv-plugins-message-container">
                                            <div  class="fv-help-block">{{ $errors->first('short_description') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Type <span class="text-danger">*</span> :</label>
                                    <select class="select3 form-control" name="type" required>
                                        <option value="" selected>Select</option>
                                        <option value="1" {{1 == old('type',$information->type) ?'selected':' '}}>Kitchen</option>
                                        <option value="2" {{2 == old('type',$information->type) ?'selected':' '}}>Delivery </option>
                                        <option value="3" {{3 == old('type',$information->type) ?'selected':' '}}>Customer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Sort Order <span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" placeholder="Sort Order" id="sort_order" name="sort_order" value="{{ old('sort_order', $information->sort_order) }}" required="required">
                                    @if($errors->has('sort_order'))
                                        <div class="fv-plugins-message-container">
                                            <div  class="fv-help-block">{{ $errors->first('sort_order') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Status</label>
                                    <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input type="checkbox" {{ $information->status ==1 ? 'checked' : '' }} name="checkbox" id="check" value="0" >
                                            <input type="hidden" name="status" id="val" value="@if($information->id){{ old('status', $information->status) }} @else 0 @endif">
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
                        </div>
                        <div class="col-lg-6">
                            <label>Descriptions <span class="text-danger">*</span> :</label>
                            <textarea max-length="50" class="form-control summernote" id="description" name="description" placeholder="Descriptions">{{ old('description', $information->getTranslation('description','en')) }}</textarea>
                          @if($errors->has('description'))
                                        <div class="fv-plugins-message-container">
                                            <div  class="fv-help-block">{{ $errors->first('description') }}</div>
                                        </div>
                                    @endif
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                            <a href="{{route('admin.information.index')}}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
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
        // minimum setup
        $('#kt_datepicker_1_modal').datepicker({
               rtl: KTUtil.isRTL(),
               todayHighlight: true,
               orientation: "bottom left",
               templates: arrows
              });
});
</script>

<script>
    $(document).ready(function() {
        $('#check').click(function(){
         if ($('#check').is(":checked"))
            {
             $("#val").attr( "value", "1" );
            } 
            else
            {
             $("#val").attr( "value", "0" );
            }
        });
    });
</script>
@endpush