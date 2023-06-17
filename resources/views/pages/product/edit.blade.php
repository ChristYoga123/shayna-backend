@extends('layouts.app')

@push('style')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Edit Barang</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('admin.barang.update', $product->slug) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="form-control-label">Nama Barang</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $product->name) }}" 
                           class="form-control @error('name') is-invalid @enderror"/>
                    @error('name')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-control-label">Tipe Barang</label>
                    <select name="type" 
                            id="type"
                            class="form-control @error('type') is-invalid @enderror">

                            <option value="Shirts" {{ $product->type === "Shirts" ? "selected" : "" }}>Shirts</option>
                            <option value="Hat" {{ $product->type === "Hat" ? "selected" : "" }}>Hat</option>
                            <option value="Pants" {{ $product->type === "Pants" ? "selected" : "" }}>Pants</option>

                    </select>
                    @error('type')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-control-label">Deskripsi Barang</label>
                    <textarea name="description"
                              id="description"
                              class="ckeditor form-control @error('description') is-invalid @enderror">
                              {{ old('description', $product->description) }}
                    </textarea>
                    @error('description')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-control-label">Harga Barang</label>
                    <input type="number"
                           name="price"
                           id="price"
                           value="{{ old('price', $product->price) }}" 
                           class="form-control @error('price') is-invalid @enderror"/>
                    @error('price')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity" class="form-control-label">Kuantitas Barang</label>
                    <input type="number"
                           name="quantity"
                           id="quantity"
                           value="{{ old('quantity', $product->quantity) }}" 
                           class="form-control @error('quantity') is-invalid @enderror"/>
                    @error('quantity')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    CKEDITOR.replace( 'description' );
</script>
@endpush