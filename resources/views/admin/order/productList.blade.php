@extends('admin.layouts.master')

@section('title','Order List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                        <div class="table-responsive table-responsive-data2">

                            <a href="{{route('admin#orderList')}}" class="text-dark"><i class="fa-solid fa-arrow-left-long"></i> Back</a>

                            <div class="card mt-4 col-6">
                                <div class="card-header">
                                    <h3><i class="fa-solid fa-clipboard"></i> Order Info</h3>
                                    <small class="text-warning"><i class="fa-solid fa-triangle-exclamation"></i> Include Delivery Charges</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-user me-2"></i> Name</div>
                                        <div class="col">{{strtoupper($orderList[0]->user_name)}}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-barcode me-2"></i> Order Code</div>
                                        <div class="col">{{$orderList[0]->order_code}}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-regular fa-clock me-2"></i> Order Date</div>
                                        <div class="col">{{$orderList[0]->created_at->format('F-j-y')}}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-regular fa-clock me-2"></i> Total Price</div>
                                        <div class="col">{{$order->total_price}} kyats</div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Order ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody id="dataList">
                                    @foreach ($orderList as $order)
                                        <tr class="tr-shadow">
                                            <td></td>
                                            <td>{{$order->id}}</td>
                                            <td class="col-2"><img src="{{asset('storage/'.$order->product_image)}}" alt="" class="img-thumbnail shadow-sm"></td>
                                            <td>{{$order->product_name}}</td>
                                            <td>{{$order->created_at->format('F-j-y')}}</td>
                                            <td>{{$order->qty}}</td>
                                            <td>{{$order->total}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
