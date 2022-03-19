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
    
              <form id="formdata2" action="{{route('stock.store')}}" method="post" enctype="multipart/form-data">
							@csrf
              <div class="col-md-12" id="stockbox">

							<div class="form-row" id="inputRow">
                <div class="form-group col-md-3">
									<label for="inputEmail4">{{__('stock_create.date')}}*</label>
                  <input type="date"  class="form-control"  name="date[]" value="{{old('date')}}" placeholder="{{__('stock_create.date')}}" >
								</div> 

                  <div class="form-group col-md-3">
									<label for="inputPassword4">{{__('stock_create.product_id')}}*</label>
                                    
    
                    <select id="" required="product_id" name="product_id[]" class="form-control">
                    <option value="">Choose One</option>
                      
                        @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                               
								</div>


                  <div class="form-group col-md-3">
									<label for="inputEmail4">{{__('stock_create.product_quantity')}}*</label>
									
									<input type="text"  class="form-control" required="quantity" name="quantity[]" value="{{old('quantity')}}" placeholder="{{__('stock_create.product_quantity')}}" >
								</div>

                <div class="form-group col-md-2">
									<label for="inputEmail4">{{__('stock_create.action')}}*</label>
								
								</div>
							
							
							</div>
              </div>
							
						
            <button type="button" onclick="addleave({{Auth()->id()}})" class="btn btn-success btn-sm float-right">{{__('stock_create.add_more')}}+</button>
                        <div class="col-md-6 m-auto">
                    <button type="submit" class="btn btn-primary btn">{{__('stock_create.save')}}</button>
            
                        </div> 
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
   
    



    <script type="text/javascript">
      function addleave(id){
         
    $('#stockbox').append(`  

    <div class="form-row" id="inputRow">
                <div class="form-group col-md-3">
    
                <input type="date"  class="form-control"   name="date[]" >
								</div> 
                  <div class="form-group col-md-3">
                  <select id="" required name="product_id[]" class="form-control">
                      @foreach($products as $product)
                      <option value="{{$product->id}}">{{$product->name}}</option>
                      @endforeach
                  </select>
                               
								</div>
                  <div class="form-group col-md-3">
									<input type="text"  class="form-control" required="quantity"  name="quantity[]" value="{{old('quantity')}}" placeholder="{{__('stock_create.product_quantity')}}" >
								</div>

        <div class="form-group col-md-2">
                <button class="btn btn-danger" id="removeRow">{{__('stock_create.remove')}}</button>
            </div>
        </div>

    `)

      }
      $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputRow').remove();
        });



        $.validator.addMethod("unique", function(value, element) {
    var parentForm = $(element).closest('form');
    var timeRepeated = 0;
    if (value != '') {
        $(parentForm.find(':text')).each(function () {
            if ($(this).val() === value) {
                timeRepeated++;
            }
        });
    }
    return timeRepeated === 1 || timeRepeated === 0;

}, "* Duplicate");


</script>

<script>
            $(document).ready(function(){
            $("#formdata2").validate({
            rules: {
            'date[]': {
            required: true,
        
            
            },
            'product_id[]': {
            required: true,
          
          
            },
            'quantity[]': {
            required: true,
           
            },
          
            },
            messages: {
            'date[]':{
                required:"stock name field is not valid",
              
            },
            'product_id[]':{
                required:"coupon discount field is not valid",
                //     maxlength:"Max 2 digits allowed",
                // minlength:"Atlast 1 charecter required"
            },
            'quantity[]':"coupon start field is not valid",
           
            
            }
            });
            })
            </script> 







<!-- <script>
$("#formdata2").validate({
  submitHandler: function(form) {
    form.submit();
  },
  ignore: [],
  rules: {
    'quantity[]': {
      required: true
    }
  }
});
</script> -->

	@jquery
	@toastr_js
	@toastr_render
	<!-- /.content-wrapper -->
	@includeIf('backend.include.footer')
	<!-- /.control-sidebar -->
	@stop