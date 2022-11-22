@extends('user.layouts.master')

@section('content')

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Filter by Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex text-center align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            <label class="mt-2" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal">{{count($categories)}}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{route('user#home')}}" class="text-dark"><label class="" for="price-1">All Pizzas</label></a>
                        </div>

                        {{-- filter pizza --}}
                        @foreach ($categories as $category)
                            <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                                <a href="{{route('user#filter',$category->id)}}" class="text-dark"><label class="" for="price-1">{{$category->name}}</label></a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{route('user#cartList')}}">
                                    <button type="button" class="btn btn-dark text-white position-relative">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle bg-danger badge rounded-pill">
                                            {{count($cart)}}
                                        </span>
                                    </button>
                                </a>

                                <a href="{{route('user#history')}}" class="ms-3">
                                    <button type="button" class="btn btn-dark text-white position-relative">
                                        <i class="fa-solid fa-clock-rotate-left"></i> History
                                        <span class="position-absolute top-0 start-100 translate-middle bg-danger badge rounded-pill">
                                            {{count($history)}}
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="" selected disabled>Choose Option...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="dataList">
                        @if (count($pizzas) != 0)
                            @foreach ($pizzas as $pizza)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 300px" src="{{asset('storage/'.$pizza->image)}}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href="{{route('user#pizzaDetails',$pizza->id)}}"><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">{{$pizza->name}}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{$pizza->price}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center shadow-sm text-secondary fs-1 col-6 offset-3 py-3">There is no pizza <i class="fa-solid fa-pizza-slice text-secondary ms-3"></i></p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

    @endsection

    @section('scriptSource')
    <script>
        $(document).ready(function() {
            // $.ajax({
            //     type : 'get' ,
            //     url : 'http://localhost:8000/user/ajax/pizza/list' ,
            //     dataType : 'json' ,
            //     success : function(response){
            //         console.log(response);
            //     }
            // })

            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();
                console.log($eventOption);

                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://localhost:8000/user/ajax/pizza/list',
                        data: {
                            'status': 'asc',
                            // 'message' : 'This is testing message'
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response[0].name);
                            $list = ``;
                            for ($i = 0; $i < response.length; $i++) {
                                // console.log(`${response[$i].name}`);
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 250px" src="{{asset('storage/${response[$i].image}')}}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `
                            }
                            $('#dataList').html($list);
                        }
                    })
                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://localhost:8000/user/ajax/pizza/list',
                        data: { 'status': 'desc' },
                        dataType: 'json',
                        success: function(response) {
                            $list = ``;
                            for ($i = 0; $i < response.length; $i++) {
                                // console.log(`${response[$i].name}`);
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 250px" src="{{asset('storage/${response[$i].image}')}}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `
                            }
                            $('#dataList').html($list);
                        }
                    })
                }
            });
        });
    </script>
    @endsection
