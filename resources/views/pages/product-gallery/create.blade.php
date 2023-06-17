@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Tambah Foto Barang</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route("admin.galeri.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="product_id" class="form-control-label">Nama Barang</label>
                    <select name="product_id"
                            class="form-control @error('product_id') is-invalid @enderror"
                            id="product_id">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image" class="form-control-label">Foto Barang</label>
                    <img class="image-preview" width="300px">
                    <input type="file"
                           name="image"
                           id="image"
                           value="{{ old('image') }}" 
                           accept="image/*"
                           class="image-input form-control @error('image') is-invalid @enderror"
                           onchange="previewImage()"/>
                    @error('image')
                        <div class="text-muted">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <label for="is_default" class="form-control-label">Jadikan foto default</label>
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio" 
                           name="is_default" 
                           id="flexRadioDefault1"
                           value="1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Ya
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio" 
                           name="is_default" 
                           id="flexRadioDefault2"
                           value="0">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Tidak
                    </label>
                </div>
                @error('is_default')
                    <div class="text-muted">
                        {{ $message }}
                    </div>
                @enderror

                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    function previewImage()
    {
        const image_input = document.querySelector(".image-input");
        const image_preview = document.querySelector(".image-preview");
        
        image_preview.style.display = "block";

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image_input.files[0]);

        oFReader.onload = function(oFREvent) {
            image_preview.src = oFREvent.target.result;
        }
    }
</script>
@endpush