@extends('admin.layouts.master')

@section('title','Pizza List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('product#createPage')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    {{-- Created Message --}}
                    @if (session('categorySuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check"></i> {{session('categorySuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif

                    {{-- Deleted Message --}}
                    @if (session('deleteSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{session('deleteSuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif

                    {{-- Change Password Message --}}
                    @if (session('changeSuccess'))
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check me-2"></i> {{session('changeSuccess')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- Search --}}
                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{request('key')}}</span></h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{route('product#list')}}" method="get" class="d-flex">
                                @csrf
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{request('key')}}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 offset-10 rounded bg-white shadow-sm py-1 px-2 text-center">
                            <h3><i class="fa-solid fa-database mr-2"></i>{{$pizzas->total()}}</h3>
                        </div>
                    </div>

                    @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pizzas as $pizza)
                                        <tr class="tr-shadow">
                                            <td class="col-2"><img src="{{asset('storage/'.$pizza->image)}}" class="img-thumbnail shadow-sm"></td>
                                            <td class="col-3">{{$pizza->name}}</td>
                                            <td class="col-2">{{$pizza->price}}</td>
                                            <td class="col-2">{{$pizza->category_name}}</td>
                                            <td class="col-1"><i class="fa-solid fa-eye"></i> {{$pizza->view_count}}</td>
                                            <td class="col-2">
                                                <div class="table-data-feature">
                                                    <a href="{{route('product#edit',$pizza->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>

                                                    {{-- edit --}}
                                                    <a href="{{route('product#updatePage',$pizza->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>

                                                    {{-- delete --}}
                                                    <a href="{{route('product#delete',$pizza->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>

                                                    <a href="">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                            <i class="zmdi zmdi-more"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $pizzas->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no Pizza Here!</h3>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
