@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="fw-bold text-primary">Products</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#importProductModal">
            <i class="bi bi-plus-circle"></i> Import Product
        </button>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle" id="data-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Product Modal --}}
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addProductModalLabel"><i class="bi bi-plus-circle"></i> Add New Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="addProductForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Product Name</label>
                <input type="text" name="name" id="add_name" class="form-control" placeholder="Enter product name" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Category</label>
                <input type="text" name="category" id="add_category" class="form-control" placeholder="Enter category">
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="add_description" class="form-control" rows="3" placeholder="Enter description"></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Price ($)</label>
                <input type="number" name="price" id="add_price" step="0.01" class="form-control" placeholder="Enter price" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Stock</label>
                <input type="number" name="stock" id="add_stock" class="form-control" placeholder="Enter stock" required>
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Upload Image</label>
                <input type="file" name="image" id="add_image" class="form-control">
              </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary shadow-sm">Save Product</button>
        </div>
      </form>

    </div>
  </div>
</div>

{{-- Edit Product Modal --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="editProductModalLabel"><i class="bi bi-pencil-square"></i> Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="editProductForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" id="edit_product_id">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Product Name</label>
              <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Category</label>
              <input type="text" name="category" id="edit_category" class="form-control">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Price ($)</label>
              <input type="number" name="price" id="edit_price" step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Stock</label>
              <input type="number" name="stock" id="edit_stock" class="form-control" required>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Upload Image</label>
              <input type="file" name="image" id="edit_image" class="form-control">
              <div id="edit_currentImage" class="mt-2"></div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning shadow-sm" id="updateBtn">Update Product</button>
        </div>
      </form>

    </div>
  </div>
</div>

{{-- View Product Modal --}}
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="viewProductModalLabel"><i class="bi bi-eye"></i> Product Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Product Name</label>
              <input type="text" id="view_name" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Category</label>
              <input type="text" id="view_category" class="form-control" readonly>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea id="view_description" class="form-control" rows="3" readonly></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Price ($)</label>
              <input type="text" id="view_price" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Stock</label>
              <input type="text" id="view_stock" class="form-control" readonly>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Image</label>
              <div id="view_currentImage" class="mt-2"></div>
            </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

{{-- Import Product Modal --}}
<div class="modal fade" id="importProductModal" tabindex="-1" aria-labelledby="importProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importProductModalLabel">Import Products via CSV</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="importCsvForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="csvFile" class="form-label">Select CSV file</label>
                <input class="form-control" type="file" name="file" id="csvFile" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Import</button>
        </form>
        <small class="text-muted d-block mt-2">
            CSV columns required: <strong>name, description, price, image, category, stock</strong><br>
            If the image column is empty, <strong>default.png</strong> will be used.
        </small>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'id', name: 'id', className: "text-center"},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description', render: function(data){
                    return `<span>${data.substring(0,50)}...</span>`;
                }},
                {data: 'price', name: 'price', className: "text-center"},
                {data: 'image', name: 'image', render: function(data){
                  if (data) {
                      if (data.startsWith('http')) {
                          return `<img src="${data}" class="img-thumbnail" style="width:60px; height:60px; object-fit:cover;">`;
                      } else {
                          return `<img src="/storage/${data}" class="img-thumbnail" style="width:60px; height:60px; object-fit:cover;">`;
                      }
                  } else {
                      return `<img src="{{ asset('/storage/products/default-product.png') }}" class="img-thumbnail" style="width:60px; height:60px; object-fit:cover;">`;
                  }
                }},
                {data: 'category', name: 'category'},
                {data: 'stock', name: 'stock', className: "text-center"},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            }
        });

        // Add Product
        $('#addProductForm').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#addProductModal').modal('hide');
                    $('#addProductForm')[0].reset();
                    table.ajax.reload(null,false);
                    toastr.success("Product added successfully!");
                },
                error: function(){
                    toastr.error("Something went wrong!");
                }
            });
        });

        // Delete Product
        $(document).on('click', '.delete', function(){
            let id = $(this).data('id');
            if(confirm("Are you sure to delete this product?")){
                $.ajax({
                    url: "/admin/products/"+id,
                    type: "DELETE",
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(response){
                        table.ajax.reload(null,false);
                        toastr.success(response.message || "Product deleted!");
                    },
                    error: function(){
                        toastr.error("Something went wrong!");
                    }
                });
            }
        });

        //View Product
        $(document).on('click', '.view', function(){
            let id = $(this).data('id');
            $.get("/admin/products/"+id, function(data){
                $('#viewProductModal').modal('show');

                $('#view_name').val(data.name);
                $('#view_category').val(data.category);
                $('#view_description').val(data.description);
                $('#view_price').val(data.price);
                $('#view_stock').val(data.stock);

                if(data.image){
                    $('#view_currentImage').html(`<img src="/storage/${data.image}" width="80" class="img-thumbnail">`);
                } else {
                    $('#view_currentImage').html('');
                }
            });
        });


        //Edit Product
        $(document).on('click', '.edit', function(){
            let id = $(this).data('id');
            $.get("/admin/products/"+id+"/edit", function(data){
                $('#editProductModal').modal('show');
                $('#edit_product_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_category').val(data.category);
                $('#edit_description').val(data.description);
                $('#edit_price').val(data.price);
                $('#edit_stock').val(data.stock);

                if(data.image){
                    $('#edit_currentImage').html(`<img src="/storage/${data.image}" width="80" class="img-thumbnail">`);
                } else {
                    $('#edit_currentImage').html('');
                }
            });
        });

        // Update Product
        $('#editProductForm').on('submit', function(e){
            e.preventDefault();
            let id = $('#edit_product_id').val();
            let formData = new FormData(this);
            formData.append('_method','PUT');

            $.ajax({
                url: "/admin/products/"+id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#editProductModal').modal('hide');
                    $('#editProductForm')[0].reset();
                    $('#edit_currentImage').html('');
                    table.ajax.reload(null,false);
                    toastr.success(response.message || "Product updated!");
                },
                error: function(){
                    toastr.error("Something went wrong!");
                }
            });
        });

    });

    $('#importCsvForm').on('submit', function(e){
      e.preventDefault();

      let formData = new FormData(this);

      // Proper way to inspect:
      for (let [key, value] of formData.entries()) {
          console.log(key, value);
      }
      
      $.ajax({
          url: "{{ route('admin.products.import.csv') }}",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          headers: {
              'X-CSRF-TOKEN': $('input[name="_token"]').val()
          },
          beforeSend: function(){
              toastr.info("Importing products, please wait...");
          },
          success: function(response){
              $('#importProductModal').modal('hide');
              $('#importCsvForm')[0].reset();
              toastr.success(response.message || "Products import started!");
          },
          error: function(xhr){
              if(xhr.status === 422){
                  let errors = xhr.responseJSON.errors;
                  let msg = '';
                  $.each(errors, function(key, value){
                      msg += value[0] + '<br>';
                  });
                  toastr.error(msg);
              } else {
                  toastr.error("Something went wrong!");
              }
          }
      });
    });

</script>
@endpush
