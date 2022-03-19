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
		<div class="card">
     
        <div class="card-body">
          
		@if(Session::has('success'))
			<div class="alert alert-success"> {{Session::get('success')}}</div>
		@endif
		@if(Session::has('info'))
			<div class="alert alert-info"> {{Session::get('info')}}</div>
		@endif
              <a type="button" href="{{route('product.create')}}" class="btn btn-success btn-sm">{{__('product_index.add_new_product')}}</a>
                
            <table class="table" id="data_table">
                <thead>
                    <tr>
                      <th><input type = "checkbox" id="checkbox" name="main_checkbox">{{__('product_index.all')}}</th>
                        <th scope="col">{{__('product_index.id')}}</th>
                        <th scope="col">{{__('product_index.Picture')}}</th>
                        <th scope="col">{{__('product_index.name')}} </th>
						<th scope="col">{{__('product_index.slug')}}</th>
                        <th scope="col">{{__('product_index.price')}}</th>
                        <th scope="col">{{__('product_index.action')}} <button type="button" id="deleteAllButton" class="btn btn-danger btn-sm d-none">delete all</button></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
       
        </div>
    </div>
	
    {{-- script for fetch data with datatables --}}
    <script type="text/javascript">
        $(function() {
            var oTable = $('#data_table').DataTable({
                "lengthMenu": [ 10, 25, 50, 100, 250, 500],
                "pageLength":25,
              
                order: [
                    [0, 'desc']
             
                ],
                dom: 'lBfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                ],
               
                processing: true,
                serverSide: true,
                ajax:"{{route('product.index')}}",
               
                
                columns: [
                  
                    {data: 'checkbox', name: 'checkbox' ,orderable: false, searchable: false},
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {data: 'image', name: 'image'},
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                  
    
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                 
                ],
              
            });
           
        });


            
    </script>

    


	{{-- script for delete single product with sweetalert confirmation--}}
	<script>
			
			function deleteproduct(id){
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton: 'btn btn-danger'
					},
					buttonsStyling: false
				})
				swalWithBootstrapButtons.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, delete it!',
					cancelButtonText: 'No, cancel!',
					reverseButtons: true
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type:'DELETE',
						datatype:'json',
						url:"/product/"+id,
						success:function(response){
						swalWithBootstrapButtons.fire(
						'Deleted!',
						'Your file has been deleted.',
						'success'
					).then((result)=>{
						$('#data_table').DataTable().ajax.reload();
					})
				}
				})
				} else if (
				result.dismiss === Swal.DismissReason.cancel
				){
					swalWithBootstrapButtons.fire(
						'Cancelled',
						'Your imaginary file is safe :)',
						'error'
					)
				}
				})
			}
	

			//script for select all or deselect all Collumn Checkbox
			$(document).ready(function(){
				$(document).on('click','input[name="main_checkbox"]', function(){
					if(this.checked){
						$('input[name="domain_checkbox"]').each(function(){
							this.checked = true;
						})
					}
					else{
						$('input[name="domain_checkbox"]').each(function(){
							this.checked = false;
						})
					}
					toggleDeleteAullBtn();
				})
				


				// if all collumn will selected all select checkbox will selected
				$(document).on('change','input[name="domain_checkbox"]',function(){
					if( $('input[name="domain_checkbox"]').length == $('input[name="domain_checkbox"]:checked').length){
						$('input[name="main_checkbox"]').prop('checked',true);
						
					}else{
						$('input[name="main_checkbox"]').prop('checked',false);
					}
					toggleDeleteAullBtn();
				})
				

				// script for bulk delete button show or hide 
				function toggleDeleteAullBtn(){
					if( $('input[name="domain_checkbox"]:checked').length > 0){
						
						$('button#deleteAllButton').text('delete ( '+$('input[name="domain_checkbox"]:checked').length+' ) ').removeClass('d-none');
					}else{
						$('button#deleteAllButton').addClass('d-none');
					}
				}
				// script for bulk delete with confirm alert
				$(document).on('click','#deleteAllButton',function(){
					
					var selectedColumn = [];
					$('input[name="domain_checkbox"]:checked').each(function(){
						selectedColumn.push($(this).data('id'));
					})
					if( selectedColumn.length > 0 ){
							const swalWithBootstrapButtons = Swal.mixin({
								customClass: {
								confirmButton: 'btn btn-success',
								cancelButton: 'btn btn-danger'
								},
								buttonsStyling: false
							})
							swalWithBootstrapButtons.fire({
								title: 'Are you sure?',
								text: "You won't be able to revert this!",
								icon: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Yes, delete it!',
								cancelButtonText: 'No, cancel!',
								reverseButtons: true
							}).then((result) => {
							if (result.isConfirmed) {
								$.ajaxSetup({
									headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								}
							});
							$.ajax({
									type:'POST',
									data:'json',
									data:{selectedColumn:selectedColumn},
									url:"/product/bulkdelete",
									success:function(d){
										swalWithBootstrapButtons.fire(
										'Deleted!',
										'Your file has been deleted.',
										'success'
										).then((result)=>{
											$('#deleteAllButton').addClass('d-none');
											$('input[name="main_checkbox"]').prop('checked',false);
											$('#data_table').DataTable().ajax.reload();
										})
									}
							})
							} else if (
							/* Read more about handling dismissals below */
							result.dismiss === Swal.DismissReason.cancel
							) {
								swalWithBootstrapButtons.fire(
									'Cancelled',
									'Your imaginary file is safe :)',
									'error'
								)
							}

						})
					}
			
				})
			
			})
	</script>
@jquery
@toastr_js
@toastr_render
<!-- /.content-wrapper -->
@includeIf('backend.include.footer')
<!-- /.control-sidebar -->
@stop




  


