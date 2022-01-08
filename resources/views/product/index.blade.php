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
			<div class="col-sm-12 m-auto">
				<div class="card">
					<div class="card-body">
						<a class="btn btn-success btn-sm" href="{{route('product.create')}}">ADD NEW PRODUCT+</a>
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Product Image</th>
									<th scope="col">Product Id</th>
									<th scope="col">Category Id</th>
									<th scope="col">SubCategory Id</th>
									<th scope="col">Name</th>
									<th scope="col">PRICE</th>
									<th scope="col">Quantity</th>
									<th scope="col">Alert Quantity</th>
									<th scope="col">ACTIONS</th>
								</tr>
							</thead>
							<tbody>
								@foreach($products as $item)
								<?php
								$data= $item->image;
								
								$images=explode('|',$data);
								?>
								<tr>
									<td>
										@foreach($images as $image)
										@endforeach
										<img src="{{asset('product_images/'.$image)}}" width="80">
									</td>
									
									<td>
										{{$item->id}}
									</td>
									<td>{{$item->category_id}}</td>
									<td>{{$item->subcategory_id}}</td>
									<td>{{$item->name}}</td>
									<td>{{$item->price}}</td>
									<td>{{$item->quantity}}</td>
									<td>{{$item->min_qty}}</td>
									
									
									<td><form action="{{route('product.destroy',$item->id)  }}" method="post">
										@csrf
										@method('DELETE')
										<a class="btn btn-primary btn-sm" href="{{route('product.edit',$item->id)}}"> edit</a>
										<a class="btn btn-warning btn-sm" href="{{route('product.edit',$item->id)}}"> view</a>
										<button class="btn btn-danger btn-sm" type="submit" >delete</button>
									</form>
								</td>
								
								
							</tr>
							@endforeach
						</tbody>
					</table>
					{{-- Pagination --}}
					<div class="d-flex justify-content-center">
						 {!! $products->links() !!}
					</div>
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