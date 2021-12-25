@extends('app')

@section('title')
All Products
@endsection

@if(Session::has('msg'))
<div class="alert alert-success" role="alert">
    {{Session::get('msg')}}
</div>
@endif

@section('content')
<div class="container">
    <div class='row'>
        <div class="col">
            <h2>All Products</h2>
        </div>
        <div class="col">
        </div>
        <div class="col">
            <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            <a class="btn btn-success" href="{{ route('logout') }}">logout</a>
        </div>

    </div>
</div>
<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th>Image</th>
            <th scope="col">Name</th>
            <th scope="col">Details</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <!-- <td><img src="image/{{ $product->image }}" width="100px"></td> -->
            <td><img src="{{URL('image/'.$product->image) }}" width="100px"></td>

            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>
                <form action="{{route('products.destroy' , $product->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{route('products.edit' , $product->id)}}" class="mt-1 btn btn-primary">Update</a>
                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"> Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <td colspan="5" style="text-align: center;">No Products</td>
        @endforelse
    </tbody>
</table>


@endsection