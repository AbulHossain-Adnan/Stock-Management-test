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
                        
						
						


               
                        <form id="formdata2" action="{{route('stock.update',$stock->id)}}" method="post" enctype="multipart/form-data">
							@csrf
                            @method('PUT')
                            <div class="col-md-12" id="stockbox">

							<div class="form-row" id="inputRow">
                          
                            <div class="form-group col-md-4">
									<label for="inputEmail4">Date*</label>
                                    <input type="date"  class="form-control" value="{{$stock->date}}" required="date"  name="date" placeholder="date" >
								</div> 

                                <div class="form-group col-md-4">
									<label for="inputPassword4">Product Id*</label>
                                    
    
                                <select id="" value="{{$stock->product_id}}" required="product_id" name="product_id" class="form-control unique">
                                  
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @endforeach
                                </select>
                               
								</div>


                                <div class="form-group col-md-4">
									<label for="inputEmail4">Product Quantity*</label>
									
									<input type="text" value="{{$stock->quantity}}"  class="form-control" required="quantity" name="quantity" value="{{old('quantity')}}" placeholder="quantity" >
								</div>

                               
							
							
							</div>
</div>
							
						
                          
                                     
                                    <button type="submit" class="btn btn-primary btn">Save</button>
                            
                                      
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