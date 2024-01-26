@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid my-4">
        <hr>
        <h5><span><b>Dashboard</b></span><span></span></h5>
        <hr>
        <div class="row">
            <div class="my-3 row">
                <div class=" text-bg-warning rounded position-relative" style="height: 150px; margin:21px; width:300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h3 class="text-center">Product</h3>
                        <h6 class="text-center">{{ $products }}</h6>
                    </div>
                </div>
                <div class=" text-bg-danger rounded position-relative" style="height: 150px; margin:21px; width:300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h3 class="text-center">Sales</h3>
                        <h6 class="text-center">{{ $sales }}</h6>
                    </div>
                </div>
                <div class=" text-bg-info rounded position-relative" style="height: 150px; margin:21px; width:300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h3 class="text-center">Today</h3>
                        <h6 class="text-center">{{ $today_sales }}</h6>
                    </div>
                </div>
                <div class=" text-bg-success rounded position-relative" style="height: 150px; margin:21px; width:300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h3 class="text-center">Users</h3>
                        <h6 class="text-center">{{ $users }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <canvas id="product"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="monthly"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const product = document.getElementById('product');
        var ds = @json($daily_sales);
        var dsd = [];
        var dsc = [];
        ds.forEach(item => {
            dsd.push(item.month + " - " + item.day + "")
            dsc.push(item.count)
        });
        new Chart(product, {
            type: 'bar',
            data: {
                labels: dsd,
                datasets: [{
                    label: 'Daily Sales',
                    data: dsc,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const monthly = document.getElementById('monthly');
        var ms = @json($monthly_sales);
        var msm = [];
        var msc = [];
        ms.forEach(item => {
            msm.push(item.month + " - " + item.year + "")
            msc.push(item.count)
        });
        new Chart(monthly, {
            type: 'bar',
            data: {
                labels: msm,
                datasets: [{
                    label: 'Daily Sales',
                    data: msc,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
