<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 py-3">
                <a href="{{ route('admin.home') }}" class=" navbar-brand">
                    <h3 class="text-center mb-3"><b>Dashboard </b></h3>
                </a>
                <ul class="list-group border rounded mb-2">
                    <h5 class="text-center my-3">Inventory</h5>
                    <a href="{{ route('product') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-file-circle-plus"></i>
                            Add Product
                        </li>
                    </a>
                    <a href="{{ route('category') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-circle-plus"></i>
                            Add Category
                        </li>
                    </a>
                    <a href="#" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-calculator"></i>
                            Calculator
                        </li>
                    </a>
                </ul>

                <ul class="list-group border rounded mb-2">
                    <h5 class="text-center my-3">Sales</h5>
                    <a href="{{ route('today') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-calendar-day"></i>
                            Today
                        </li>
                    </a>
                    <a href="{{ route('admin.history') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            History
                        </li>
                    </a>
                </ul>

                <ul class="list-group border rounded mb-2">
                    <h5 class="text-center my-3">Employees</h5>
                    <a href="{{ route('employee.detail') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-user"></i>
                            Employee Details
                        </li>
                    </a>
                    <a href="{{ route('employee') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-user-plus"></i>
                            Add Employee
                        </li>
                    </a>
                    <a href="{{ route('profile') }}" class="link-underline link-underline-opacity-0">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-regular fa-id-badge"></i>
                            Profile
                        </li>
                    </a>
                    <a href="{{ route('logout') }}" class="link-underline link-underline-opacity-0"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <li class="list-group-item link-underline-opacity-0">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </ul>
            </div>
            <div class="col-md-10 ">
                @yield('content')
            </div>
        </div>

    </div>
</body>

</html>
