@extends('layouts.app')
@section('app_content')
<!-- Navbar -->
@includeIf('backend.include.navbar')
<!-- /.navbar -->
<!-- Main Sidebar Container -->
@includeIf('backend.include.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	@includeIf('backend.include.breadcumb')
	<!-- Main content -->
	<section class="content p-4">
		<!-- Default box -->
		@yield('master_content')
		
		@toastr_css
		<!-- /.card -->
		<div class="row">
			<div class="col-sm-11 m-auto">
				<div class="card">
					<div class="card-body">

						<form id="formdata" action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4">{{__('product_create.product_name')}}*</label>
									@error('name')
									<span class="text-danger">{{$message}}</span>
									@enderror
									<input type="text"  class="form-control" name ="name" value="{{old('name')}}" placeholder=" {{__('product_create.product_name')}}">
								</div>
								<div class="form-group col-md-6">
									<label for="inputPassword4">{{__('product_create.product_price')}}*</label>
									@error('price')
									<span class="text-danger">{{$message}}</span>
									@enderror
									<input type="text" class="form-control" name="price" value="{{old('price')}}" placeholder="{{__('product_create.product_price')}}">
								</div>
							
							</div>
							
							<div class="form-group">
								<label for="exampleInputEmail1">{{__('product_create.product_image')}}*</label>
								@error('image')
								<span class="text-danger">{{ $message }}</span>
								@enderror
								<input type="file"  name="image" class="form-control" >
								
							</div>
							<a class="btn btn-warning" type="button"  href="{{route('product.index')}}">{{__('product_create.back')}}</a>
							<button type="submit" class="btn btn-primary btn">{{__('product_create.save')}}</button>
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>

	@jquery
	@toastr_js
	@toastr_render
	<!-- /.content-wrapper -->
	@includeIf('backend.include.footer')
	<!-- /.control-sidebar -->
	@stop