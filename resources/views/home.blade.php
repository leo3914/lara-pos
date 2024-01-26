@extends('layouts.app')

@section('content')
    <style>
        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ccc !important;
            border-radius: 0px !important;
        }
    </style>
    <h1 class="text-center mb-4">Counting</h1>
    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('add.to.Ses') }}" method="POST">
                @csrf
                <select id="product_id" class="form-control product_search" name="product_id">
                    <option>Select or Search</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ( Unit Price : {{ $product->price }} MMK )
                        </option>
                    @endforeach
                </select>

                <input type="number" class="form-control my-2 qty" placeholder="Enter Quantity" name="quantity" disabled>
                <span class="badge bg-danger qty_err"></span>
                <div>
                    <button class="btn btn-primary c_btn" disabled>Add to Order</button>
                </div>
            </form>


        </div>
        <div class="col-md-5">
            <h4 class=" float-start bold">Invoice</h4>
            <a href="{{ route('empty.cart') }}" class="btn btn-danger float-end btn-sm mb-2">Clear</a>
            @if (session()->get('cart'))
                <table class="table">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Remove</th>
                    </tr>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cart as $k => $p)
                        @php
                            $total += $p['price'] * $p['quantity'];
                        @endphp
                        <tr>
                            <td scope="col">{{ $loop->iteration }}</td>
                            <td scope="col">{{ $p['name'] }}</td>
                            <td scope="col">{{ $p['price'] }} MMK</td>
                            <td scope="col" class="p-1">
                                <span class="qty">{{ $p['quantity'] }}</span>
                            </td>
                            <td scope="col">{{ number_format($p['price'] * $p['quantity']) }} MMK</td>
                            <td><a href="{{ route('remove.cart', $k) }}" class="btn btn-sm text-danger"><i
                                        class="fa-solid fa-delete-left"></i></a></td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3"></th>
                        <th>Total</th>
                        <th>{{ $total }} MMK</th>
                    </tr>

                </table>
                <form action="{{ route('confirm') }}" method="POST">
                    @csrf
                    <h6>Payment Method</h6>
                    <select name="payment" class="form-control mb-2">
                        <option value="1">Cash</option>
                        <option value="1">Card</option>
                    </select>
                    <button class="btn btn-primary">Confirm</button>
                </form>
            @else
                <div class="alert bg-info text-center">There is no product.</div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <h3 class="text-center mb-3">Last Invoice</h3>
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>Id</th>
                <th>Items</th>
                <th>Payment</th>
                <th>Cashier</th>
                <th>Action</th>
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
                <td><a href="{{ route('voucher',$order->id) }}" class="btn btn-success btn-sm">Export Voucher</a></td>
            </tr>
            @endforeach
        </table>
    </div>

    <script>
        // $(".search").on('input', async function() {
        //     let text = $(this).val();
        //     $.ajax({
        //         url: "{{ route('product.search') }}",
        //         method: "GET",
        //         data: {text},
        //         success: function (response) {
        //             console.log(response);
        //         }
        //         });

        // $('.result').html(text);

        // try {
        //     const response = await $.ajax({
        //         url: "{{ route('product.search') }}",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             text: text
        //         },
        //     });
        //     console.log(response);
        // } catch (error) {
        //     console.error(error);
        // }


        // $('.search').focus( function(){
        //     $('.p_list').removeClass('d-none');
        // });
        // $('.search').hover( function(){
        //     $('.p_list').removeClass('d-none');
        // });
        // $('.search').blur(function(){
        //     $('.p_list').addClass('d-none');
        // });
        // $('.row').hover(function(){
        //     $('.p_list').addClass('d-none');
        // })
        // $('.item').click(function() {
        //     let name = $(this).attr('name');
        //     let category = $(this).attr('category');
        //     let product_id = $(this).attr('product_id');
        //     alert(product_id)
        // });


        // $(document).on('click', function(e) {
        //     if (!$(e.target).closest('.search, .p_list').length) {
        //         $('.p_list').addClass('d-none');
        //     }
        // });

        // $('.search').on({
        //     input: function() {
        //         let text = $('.search').val();
        //         let products = @json($products);

        //         // let product_search = products.find(product => product.name == text);
        //         // let product_search = products.find(product => product.name.toLowerCase() === text.toLowerCase());
        //         // // let product_search = products.filter(product => product.name.includes(`%${text}%`));
        //         // let product_search = products.filter(product => product.name.toLowerCase().includes(`%${text.toLowerCase()}%`));
        //         // console.log(product_search);
        //         console.log("Products:", products);
        //         console.log("Search text:", text);
        //         let product_search = products.find(product => product.name.includes(`%${text}%`));
        //         console.log("Search result:", product_search);

        //     },
        //     focus: function() {
        //         $('.p_list').removeClass('d-none');
        //     },
        //     mouseenter: function() {
        //         $('.p_list').removeClass('d-none');
        //     },
        //     blur: function() {
        //         $('.p_list').addClass('d-none');
        //     }
        // });
        $(document).ready(function() {
            $("#product_id").select2({

            });
        });

        // $(document).ready(function () {
        //     var cart = @json($cart);
        //     $(".increase").click(function(){
        //        for (const key in cart) {
        //         console.log(key);
        //        }
        //     })
        // });

        $('.product_search').change(function () {
            $('.qty').removeAttr('disabled',false)
        });

        $('.qty').keyup(function() {
            var qty = $(this).val();
            var product_id = $('#product_id').val();

            // alert(product_id);
            $.ajax({
                url: "{{ route('qty.search') }}",
                method: "GET",
                data: {product_id},
                success: function (response) {
                    console.log(response);
                    if(qty > response.instock)
                    {
                        $('.qty_err').text(`Sorry, We have ${response.instock} items In Stock.`);
                        $('.c_btn').attr('disabled',true);
                    }else if(qty === "" || qty <= 0)
                    {
                        $('.c_btn').attr('disabled',true);
                        $('.qty_err').text("");
                    }
                    else{
                        $('.qty_err').text("");
                        $('.c_btn').removeAttr('disabled',true);
                    }
                }
            });
        });
    </script>
@endsection
