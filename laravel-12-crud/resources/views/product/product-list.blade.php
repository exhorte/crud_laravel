@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Products List</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="d-flex" role="search" method="GET" action="{{ route('product.index') }}">
                                    <input class="form-control me-2" type="search" name="search" placeholder="input" aria-label="Search" value="{{ request('search') }}"/>
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <a href="{{ route('product.trashed') }}" class="float-end btn btn-warning">Trashe</a>
                                <a href="/create-product" class="float-end btn btn-success">Add New</a>
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
      <th scope="col" colspan="3" class="text-center">Actions</th>
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
            <td><a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a></td>
            <td>
                <form action="{{ route('product.destroy', $product->id) }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete this product?')" type="submit" class="btn btn-secondary btn-sm">Move to trash</button>
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