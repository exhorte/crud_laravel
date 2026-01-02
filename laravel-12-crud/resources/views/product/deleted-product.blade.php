@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>ProducListt </h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="d-flex" role="search" method="GET" action="{{ route('product.trashed') }}">
                                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}"/>
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <a href="{{ route('product.index') }}" class="float-end btn btn-warning">View all products</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('success'))
            <span class="alert alert-success p-2">{{ Session::get('success')}}</span>
        @endif
        @if (Session::has('error'))
            <span>{{ Session::get('error')}}</span>
        @endif
        <div class="crad-body">
        <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Category</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
      <th scope="col">Status</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    @if ($products->count() > 0)
        @foreach ($products as $product)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th> <!-- masque le veritable id et affiche just un numero attribuer par la boucle -->
            <td>{{ $product->name}}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->quantite}}</td>
            <td>{{ $product->price}}</td>
            <td>{{ $product->status}}</td>
            <td>{{ $product->description}}</td>
            <td><a href="{{ route('product.show', $product->id) }}" class="btn btn-success btn-sm">Show</a></td>
            <td>
                <form action="{{ route('product.restore', $product->id) }}" method="post" style="display: inline;">
                    @csrf
                    <button onclick="return confirm('Are you sure you want to restore this product?')" type="submit" class="btn btn-info btn-sm">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{ route('product.delete', $product->id) }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete this product?')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center">No Data Found!</td>
        </tr>
    @endif
    
  </tbody>
</table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection