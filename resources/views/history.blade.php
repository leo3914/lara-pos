@extends('layouts.app')

@section('content')
<div class="row">
    <table class="table table-bordered table-striped table-responsive">
        <h1 class="text-center">History</h1>
        <tr>
            <th>Id</th>
            <th>Items</th>
            <th>Payment</th>
            <th>Cashier</th>
            <th>Created_at</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>
                <table class="table table-bordered table-sm shadow-sm">
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Photo</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                    @php
                        $total = 0;
                    @endphp
                    @foreach (json_decode($order->order_items) as $item)
                    @php
                        $total += $item->quantity * $item->price;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <img src="{{ asset('images/'.$item->photo) }}" width="40px">
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity * $item->price }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="4"></th>
                        <th>Total</th>
                        <th>{{ $total }}</th>
                    </tr>
                </table>
            </td>
            <td>@if ($order->payment === 1)
                Cash
            @else
                Card
            @endif</td>
            <td>{{ $order->user->name }}</td>
            {{-- <td>{{ date('Y-m-d H:i:s', strtotime($order->created_at)) }}</td> --}}
            <td>{{ $order->created_at }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
