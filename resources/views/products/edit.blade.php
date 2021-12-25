@extends('app')

@section('title')
Edit Product
@endsection


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md">

            <div class="pull-left">
                <h2>Update Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>

            <form action="{{route('products.update' ,$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
                <div class="form-group">
                    <label>Product name</label>
                    <input type="text" class="form-control" name="name" value="{{$product->name}}">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{$product->description}}</textarea>
                </div>

                <div class="form-group">
                    <strong>Image:</strong>
                    <input type="file" name="image" class="form-control" placeholder="image" value="">
                    <img src="/image/{{ $product->image }}" width="200px">

                </div>
                <button type="submit" class="btn btn-success">Edit Product</button>
            </form>
        </div>
    </div>
</div>

@endsection