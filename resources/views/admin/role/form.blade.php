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
         <a href="{{route('admin.role.index')}}">
         <span class="text-muted font-weight-bold mr-4">
          User Role & Access Permission                          
         </span></a>
         <!--end::Page Title-->
         <!--begin::Actions-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <span class="text-muted font-weight-bold mr-4">{{$role->id ? 'Edit':'Add'}} User Role & Access Permission </span> 
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
         <h3 class="card-title">{{$role->id ? 'Edit':'Add'}} User Role & Access Permission</h3>
      </div>
      <!--begin::Form-->
      <form class="form" action="{{ $role->id ? route('admin.role.update',$role->id) : route('admin.role.store') }}" method="post">
         @csrf
         {{ $role->id ? method_field('PUT') : '' }}
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6">
                      <div class="col-lg-12 form-group">
                  <label>Name<span class="text-danger">*</span> :</label>
                  <input type="text" name="name" class="form-control"  placeholder="Name" value="{{ old('name',$role->name) }}" required="required">
                  @if($errors->has('name'))
                   <div class="fv-plugins-message-container">
                                   <div  class="fv-help-block">{{ $errors->first('name')}}</div>
                                  </div>
                  @endif
               </div>
           
   
          
               </div>
        
               </div>
             
            <div class="form-group row">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="user_table">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th width="15%">Create</th>
                                <th width="15%">Edit <a href="javascript:;" data-toggle="tooltip" class="tip-top" title="Verification and Status needs edit permission"><i
                        class="flaticon-questions-circular-button"></i></a></th>
                                <th width="15%">Delete</th>
                                <th width="15%">View</th>
                            </tr>
                        </thead>
                        <tbody>
                   
                           @if($permissions->count())
                           @foreach($permissions->groupBy('module_name') as $permission)
                              @if($permission)
                                 <tr>
                                    <td>
                                       {{ $permission[0]->module_name }}
                                    </td>
                                 @foreach($permission as $permit)
                                    <td>
                                       <input type="checkbox" name="permission[]" {{ in_array($permit->name, $role_permissions) ? 'checked="checked"' : '' }} value="{{ $permit->name }}" />
                                    </td>
                                 @endforeach
                                 </tr>
                              @endif
                           @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
            <div class="card-footer">
               <div class="row">
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-6 text-right">
                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                    <a class="btn btn-secondary" href="{{route('admin.role.index')}}">Cancel</a>
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
<script>
   $(function() {
   $('.summernote').summernote({
               height: 250,
               tabsize: 2
           });
   });
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