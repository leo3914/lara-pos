@extends('admin.layouts.app')

@section('content')
<div class="container-fluid my-4">
    <hr>
    <h5><span><b>Inventory</b></span> / <span>Category</span></h5>
    <hr>
    <div class="row">
        <div class="col-md-5">
            <h4 class="text-center my-2">Add Category</h4>
            <form action="{{ route('category.add') }}" method="POST">
                @csrf
                <input name="category" type="text" class="form-control mb-2" placeholder="Enter Category" required>
                <button class="btn btn-primary">Add +</button>
            </form>
        </div>
        <div class="col-md-7">
            <h4 class="text-center my-2">Category</h4>
            <table class="table table-bordered table-striped table-sm">
                <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->category }}</td>
                    <td>
                        <a href="{{ route('category.delete',$category->id) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
