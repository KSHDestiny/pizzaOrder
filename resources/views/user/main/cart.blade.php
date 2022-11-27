@extends('user.layouts.master')

@section('content')

   <!-- Breadcrumb Start -->
   <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Pizza</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($cartLists as $cartList)
                        <tr>
                            <td class="align-middle"><img src="{{asset('storage/'.$cartList->product_image)}}" class="img-thumbnail" alt="" style="width: 100px; height: 75px"></td>
                            <td class="align-middle">
                                {{$cartList->pizza_name}}
                                <input type="hidden" class="orderId" id="" value="{{$cartList->id}}">
                                <input type="hidden" class="productId" id="" value="{{$cartList->product_id}}">
                                <input type="hidden" class="userId" id="" value="{{$cartList->user_id}}">
                            </td>
                            <td class="align-middle" id="price">{{$cartList->pizza_price}} kyats</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus text-white"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-white border-0 text-center" value="{{$cartList->qty}}" id="qty">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle" id="total">{{$cartList->pizza_price*$cartList->qty}} kyats</td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-danger btn-remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subTotalPrice">{{$totalPrice}} kyats</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delivery</h6>
                        <h6 class="font-weight-medium">3000 kyats</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="finalPrice">{{$totalPrice+3000}} kyats</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3"  id="orderBtn">
                        <span class="text-white">Proceed To Checkout</span>
                    </button>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3"  id="clearBtn">
                        <span class="text-white">Clear Cart</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

@endsection

@section('scriptSource')
    <script src="{{asset('js/cart.js')}}"></script>
    <script>
        $('#orderBtn').click(function(){
        // $userId = $('.userId').val();

        // productId ko looping pat pee shr mha ya
            $orderList = [];
            $random = Math.floor(Math.random() * 100000000001);
            $('#dataTable tbody tr').each(function(index,row) {
                $orderList.push({
                    'user_id' : $(row).find('.userId').val(),
                    'product_id' : $(row).find('.productId').val(),
                    'qty' : $(row).find('#qty').val(),
                    'total' : Number($(row).find('#total').text().replace('kyats','')),
                    'order_code' : 'POS'+$random
                });
            });

            $.ajax({
                type: 'get',
                url: '/user/ajax/order',
                data: Object.assign({},$orderList),  // data ka object type pyit ya mL
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'true'){
                        window.location.href = "/user/homePage";
                    }
                }
            })
        });

        $('#clearBtn').click(function(){
            $('#dataTable tbody tr').remove();
            $('#subTotalPrice').html("0 kyat");
            $('#finalPrice').html("3000 kyats");

            $.ajax({
                type: 'get',
                url: '/user/ajax/clear/cart',
                dataType: 'json'
                })
        });

            // X btn click
        $('.btn-remove').click(function() {
            $parentNode = $(this).parents('tr');
            $parentNode.remove();

            $productId = $parentNode.find('.productId').val();
            $orderId = $parentNode.find('.orderId').val();

            $.ajax({
                type : 'get',
                url : '/user/ajax/clear/current/product',
                data : {
                    'productId' : $productId ,
                    'orderId' : $orderId
                },
                dataType : 'json'
            })

            // summary calculation
            $summaryTotal = 0;
            $('#dataTable tbody tr').each(function(index, row) {
                $summaryTotal += Number($(row).find('#total').text().replace("kyats", ""));
            })

            $("#subTotalPrice").html(`${$summaryTotal} kyats`);
            $("#finalPrice").html(`${$summaryTotal+3000} kyats`);
        })

    </script>
@endsection
