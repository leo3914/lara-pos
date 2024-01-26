@extends('layouts.app')

@section('content')
<h3 class="text-center my-2"><b>Product List</b></h3>
<div class="row">
    <table class="table table-bordered table-striped table-responsive">
        <tr>
            <th>Id</th>
            <th>Product</th>
            <th>Photo</th>
            <th>Category</th>
            <th>Price</th>
            <th>In Stock</th>
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
                {{-- <td>
                    <button type="button" class="btn btn-sm btn-outline-danger m-1 edit_product"
                        data-bs-toggle="modal" data-bs-target="#editModal" p_id="{{ $product->id }}"><i
                            class="fa-regular fa-pen-to-square"></i></button>
                    <a href="{{ route('product.delete', $product->id) }}"
                        class="btn btn-sm btn-outline-danger m-1"><i class="fa-solid fa-trash-can"></i></a>
                </td> --}}
            </tr>
        @endforeach
    </table>
</div>
@endsection
