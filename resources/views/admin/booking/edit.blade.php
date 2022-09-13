@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 bold-labels">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @endif

            @include('crud::inc.form_save_buttons')
		  </form>
	</div>

    <div class="col-md-4 bold-labels">
        <div class="card">
            <div class="card-body row">
                <div class="form-group col-sm-12" element="div">
                    <label>Consignee Name</label>
                    <input type="text" name="consignee_name" readonly id="consignee_name" value="" class="form-control">
                </div>
                <div class="form-group col-sm-12" element="div">
                    <label>Consignee Phone</label>
                    <input type="text" name="consignee_phone" readonly id="consignee_phone" value="" class="form-control">
                </div>
                <div class="form-group col-sm-12" element="div">
                    <label>Consignee Address</label>
                    <input type="text" name="consignee_address" readonly id="consignee_address" value="" class="form-control">
                </div>
                <div class="form-group col-sm-12" element="div">
                    <label>Consignee Emirate</label>
                    <input type="text" name="consignee_address" readonly id="consignee_emirate" value="" class="form-control">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body row">
                <div class="form-group col-sm-12 mb-0" element="div">
                    <p>You can update your details <a href="/admin/edit-account-info">here</a></p>
                </div>
                <input type="hidden" value="{{ backpack_user()->id }}" id="consigner_id">
                <div class="form-group col-sm-12" element="div">
                    <label>Consigner Name</label>
                    <input type="text" name="consigner_name" readonly id="consigner_name" value="" class="form-control">
                </div>
                <div class="form-group col-sm-12" element="div">
                    <label>Consigner Phone</label>
                    <input type="text" name="consigner_phone" readonly id="consigner_phone" value="" class="form-control">
                </div>
                <div class="form-group col-sm-12" element="div">
                    <label>Consigner Address</label>
                    <input type="text" name="consigner_address" readonly id="consigner_address" value="" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after_scripts')
    <script>
        $('select[name=consignee]').on('change', function() {
            if (this.value) {
                $.ajax({
                    url: "/api/consignee/" + this.value,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#consignee_name').val(data.data.name);
                        $('#consignee_phone').val(data.data.phone);
                        $('#consignee_address').val(data.data.address);
                        $('#consignee_emirate').val(data.data.emirate);
                    },
                    error: function(data) {

                    }
                });
            }
        });

        $(window).ready(function() {
            $.ajax({
                url: "/api/consigner/" + $('#consigner_id').val(),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#consigner_name').val(data.data.name);
                    $('#consigner_phone').val(data.data.phone);
                    $('#consigner_address').val(data.data.address);
                },
                error: function(data) {

                }
            });
        });
    </script>
@endpush
