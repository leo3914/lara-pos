@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid my-4">
        <hr>
        <h5><span><b>Employee</b></span> / <span>Add Employees</span></h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('employee.add') }}" method="POST" enctype="multipart/form-data">
                    <h3 class="text-center font-bold my-3">Add Employee</h3>
                    @csrf
                    <input id="name" type="text" class="form-control mb-3 @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="Enter Name">

                    <input id="email" type="email" class="form-control mb-3 @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email">

                    <select class="form-select mb-3" id="inputGroupSelect01" name="role" required>
                        <option selected>Choose...</option>
                        <option value="0">Cashier</option>
                        <option value="1">Admin</option>
                    </select>

                    <input id="password" type="password" class="form-control mb-3 @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="Enter Password">


                    <input id="password-confirm" type="password" class="form-control mb-3" name="password_confirmation"
                        required autocomplete="new-password" placeholder="Confirm Password">

                    <input type="file" class="form-control mb-3" name="photo">
                    <button class="btn btn-primary">Create</button>
                </form>
            </div>

            <div class="col-md-6">
                <table class="table table-bordered table-sm table-striped">
                    <h3 class="text-center font-bold my-3">Employees</h3>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Role</th>
                        <th>Create Date</th>
                    </tr>
                    @foreach ($employees as $emp)
                    <tr>
                        <td>{{ $emp->id }}</td>
                        <td>{{ $emp->name }}</td>
                        <td>
                            <img src="{{ asset('images/'.$emp->user_photo) }}" alt="userimg" width="50px">
                        </td>
                        <td> @if ($emp->role === 0)
                            Cashier
                        @else
                            Admin
                        @endif</td>
                        <td>{{ $emp->created_at }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>


            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert bg-warning">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
