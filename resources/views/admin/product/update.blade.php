@extends('admin.layouts.master')

@section('title','Pizza Edit Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left text-dark" style="cursor: pointer" onclick="history.back()"></i>
                            </div>
                            {{-- <div class="ms-5">
                                <a href="{{route('product#list')}}">
                                    <i class="fa-solid fa-arrow-left text-dark" style="cursor: pointer"></i>
                                </a>
                            </div> --}}
                            <div class="card-title">
                                <h3 class="text-center title-2">Update Pizza</h3>
                            </div>
                            <hr>
                            <form action="{{route('product#update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        <input type="hidden" name="pizzaId" value="{{$pizzas->id}}">
                                        <img src="{{asset('storage/'.$pizzas->image)}}" class="img-thumbnail shadow-sm"/>

                                        <div class="mt-3">
                                            <input type="file" name="pizzaImage" id="" class="form-control @error('pizzaImage') is-invalid @enderror">
                                            @error('pizzaImage')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mt-3 ">
                                            <button class="btn bg-dark text-white col-12" type="submit"><i class="fa-solid fa-circle-chevron-right me-3"></i>Update</button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="pizzaName" type="text" value="{{old('pizzaName',$pizzas->name)}}" class="form-control @error('pizzaName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Pizza Name...">
                                            @error('pizzaName')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Description</label>
                                            <textarea id="cc-pament" name="pizzaDescription" type="text" class="form-control @error('pizzaDescription') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Pizza Description...">{{old('pizzaDescription',$pizzas->description)}}</textarea>
                                            @error('pizzaDescription')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory" class="form-control @error('gender') is-invalid @enderror">
                                                <option value="" disabled>Choose Category...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}" @if($pizzas->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="pizzaPrice" type="text" value="{{old('pizzaPrice',$pizzas->price)}}" class="form-control @error('pizzaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Pizza Price...">
                                            @error('pizzaPrice')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="pizzaWaitingTime" type="text" value="{{old('pizzaWaitingTime',$pizzas->waiting_time)}}" class="form-control @error('pizzaWaitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Waiting Time...">
                                            @error('pizzaWaitingTime')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="control-label">View Count</label> : {{$pizzas->view_count}}
                                        </div>

                                        <div>
                                            <label class="control-label mb-1">Created Date</label> : {{$pizzas->created_at->format('j-F-Y')}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
