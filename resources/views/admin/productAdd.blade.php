@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid my-4">
        <hr>
        <h5><span><b>Inventory</b></span> / <span>Product</span></h5>
        <hr>
        <div class="row">
            <div class="col-md-5">
                <h4 class="text-center my-2">Add Product</h4>
                <form action="{{ route('product.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="form-control mb-2" placeholder="Enter Name" required name="name">
                    <select class="form-control mb-2" name="category_id">
                        <option>Select</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control mb-2" placeholder="Enter Price" required name="price">
                    <input type="number" class="form-control mb-2" placeholder="In Stock" required name="instock">
                    <input type="file" class="form-control mb-2" required name="photo">
                    <button class="btn btn-primary">Add +</button>
                </form>
            </div>
            <div class="col-md-7">
                <h4 class="text-center my-2">Product</h4>
                <table class="table table-bordered table-striped table-sm table-responsive">
                    <tr>
                        <th>Id</th>
                        <th>Product</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>In Stock</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset('images/' . $product->photo) }}" width="40px ">
                            </td>
                            <td>{{ $product->category->category }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->instock }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger m-1 edit_product"
                                    data-bs-toggle="modal" data-bs-target="#editModal" p_id="{{ $product->id }}"><i
                                        class="fa-regular fa-pen-to-square"></i></button>
                                <a href="{{ route('product.delete', $product->id) }}"
                                    class="btn btn-sm btn-outline-danger m-1"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-regular fa-pen-to-square"></i> Edit
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body edit_form">

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".edit_product").click(function(){
                let product_id = $(this).attr('p_id');
                $.ajax({
                    method : "GET",
                    url: "{{ route('product.search') }}",
                    data: {product_id},
                    success: function (response) {
                        // console.log(response.price);
                        $('.edit_form').html(`
                            <form action="{{ route('product.edit') }}" method="POST">
                            @csrf
                            <h6 class="text-start ms-1 font-bold">${response.name}</h6>
                            <input type="hidden" value="${response.id}" name="product_id">
                            <input type="number" class="form-control mb-2" placeholder="Enter Price" required name="price" value="${response.price}">
                            <input type="number" class="form-control mb-2" placeholder="In Stock" required name="instock" value="${response.instock}">
                            <button class="btn btn-primary">Update</button>
                            </form>
                        `)
                        console.log(response.price);
                    }
                });
            })
        });
    </script>
@endsection
