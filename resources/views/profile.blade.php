@extends('layouts.app')

@section('content')
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-md-6">
                <h3 class="my-3">My Profile</h3>
                <div class="mb-3">
                    <img src="{{ asset('images/' . auth()->user()->user_photo) }}" alt="" width="300px">
                </div>
                <h5>Name : <b>{{ auth()->user()->name }}</b></h5>
                <h5>Email : <b>{{ auth()->user()->email }}</b></h5>
                <h5>Role : <b>
                        @if (auth()->user()->role === 1)
                            Admin
                        @else
                            Cashier
                        @endif
                    </b></h5>
                <h5>Created Date : <b>{{ auth()->user()->created_at }}</b></h5>
            </div>
            <div class="col-md-3">
                <h3 class="my-3">Change Password</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('pass.change') }}" class="mt-5" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="password" name="c_pass" id="" class="form-control mb-2"
                        placeholder="Current Password" required>
                    <input type="password" name="n_pass" id="" class="form-control mb-2"
                        placeholder="New Password" required>
                    <input type="password" name="cn_pass" id="" class="form-control mb-2"
                        placeholder="Confirm New Password" required>
                    <button class="btn btn-primary">Change</button>
                </form>
            </div>
        </div>
    </div>
@endsection
