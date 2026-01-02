<div class="mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" class="form-control" id="product-name" name="name" value="{{ old('name', $product->name ?? '') }}" >
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="product-description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-label">Price *</div>
            <input type="number" class="form-control" id="product-price" name="price" value="{{ old('price', $product->price ?? '') }}" >
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" id="product-quantity" name="quantite" value="{{ old('quantite', $product->quantite ?? '') }}" >
            @error('quantite')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category *</label>
            <select class="form-control" id="product-category" name="category_id" >
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status *</label>
            <select class="form-control" id="product-status" name="status" >
                <option value="active" {{ old('status', $product->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="in-active" {{ old('status', $product->status ?? '') == 'in-active' ? 'selected' : '' }}>In-Active</option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" class="form-control" id="product-image" name="image" value="{{ old('image', $product->image ?? '') }}">
            
            @if (!empty($product->image))
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid">
            @endif
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
</div>