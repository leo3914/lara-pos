@extends('admin.layouts.app')

@section('content')
    <div class="container-fiuid my-4">
        <hr>
        <h5><span><b>Employees</b></span> / <span>Employee Details</span></h5>
        <hr>
        <div class="row">
            <table class="table table-responsive table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
                @foreach ($employees as $emp)
                    <tr>
                        <td>{{ $emp->id }}</td>
                        <td>{{ $emp->name }}</td>
                        <td><img src="{{ asset('images/' . $emp->user_photo) }}" alt="user" width="50px"></td>
                        <td>{{ $emp->email }}</td>
                        <td class="p-2">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if ($emp->role === 1)
                                        Admin
                                    @else
                                        Cashier
                                    @endif
                                </button>

                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{ route('role.change',['user_id' => $emp->id , 'role' => 1]) }}">Admin</a></li>
                                  <li><a class="dropdown-item" href="{{ route('role.change',['user_id' => $emp->id , 'role' => 0]) }}">Cashier</a></li>
                                </ul>
                              </div>
                        </td>
                        <td>{{ $emp->created_at }}</td>
                        <td>
                            <a href="{{ route('emp.delete',$emp->id) }}" class="btn btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <script>
        $(".ebtn").click(function() {
            let emp_id = $(this).attr('e_id');
            let role = $(this).attr('e_role');
            // alert(role)

            $.ajax({
                url: "{{ route('emp.search') }}",
                method : "GET",
                data: {emp_id},
                success: function (response) {
                    console.log(response);

                    $('.edit_user').html(`
                    <form action="" method="POST">
                        <select name="role" class="form-control mb-2">
                            <option value="1" ${response.role === role ? 'selected' : ''}>Admin</option>
                            <option value="0" ${response.role === role ? 'selected' : ''}>Cashier</option>

                        </select>
                    </form>
                    `);
                }
            });
        });
    </script>
@endsection
