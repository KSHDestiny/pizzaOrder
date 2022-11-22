@extends('admin.layouts.master')

@section('title','Edit Pizza Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if (session('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check me-2"></i> {{session('updateSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left text-dark" style="cursor: pointer" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                {{-- <h3 class="text-center title-2">Pizza Details</h3> --}}
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{asset('storage/'.$pizzas->image)}}" class="img-thumbnail shadow-sm"/>
                                </div>
                                <div class="col-7">
                                    <div class="my-3 btn bg-danger text-white text-center d-block w-50 fs-4">{{$pizzas->name}}</div>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-money-bill-1-wave me-2 fs-5"></i>{{$pizzas->price}} kyats</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clock me-2 fs-5"></i>{{$pizzas->waiting_time}} mins</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-eye me-2 fs-5"></i>{{$pizzas->view_count}}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clone me-2"></i>{{$pizzas->category_name}}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-user-clock me-2 fs-5"></i>{{$pizzas->created_at->format('j-F-Y')}}</span>
                                    <div class="my-3"><i class="fa-solid fa-file-lines me-2 fs-4"></i> Details </div>
                                    <div class="">{{$pizzas->description}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
