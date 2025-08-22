@extends('layouts.backoffice')
@section('title', 'New Product')

@section('style')
    <style>
        .ck-content {
            height: 375px
        }

        .img-preview {
            object-fit: cover;
            object-position: center;
            height: 200px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit @yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">@yield('title')</h3>
                                <div class="ml-auto">
                                    <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('product.update', $product->id) }}"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Side -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Nama produk</label>
                                                <input type="text" name="name"
                                                    value="{{ old('name', $product->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Jenis Aroma</label>
                                                        <input type="text" name="fragrance_family"
                                                            value="{{ old('fragrance_family', $product->fragrance_family) }}"
                                                            class="form-control @error('fragrance_family') is-invalid @enderror"
                                                            list="fragranceFamilyOptions" placeholder="Ketik atau pilih...">
                                                        <datalist id="fragranceFamilyOptions">
                                                            <option value="Floral">
                                                            <option value="Citrus">
                                                            <option value="Woody">
                                                            <option value="Oriental">
                                                            <option value="Aquatic">
                                                        </datalist>
                                                        @error('fragrance_family')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Volume (ml)</label>
                                                        <input type="number" name="volume_ml"
                                                            value="{{ old('volume_ml', $product->volume_ml) }}"
                                                            class="form-control">
                                                        @error('volume_ml')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Kiri -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Target Gender</label>
                                                        <select name="gender_target" class="form-control">
                                                            <option value="male"
                                                                {{ old('gender_target', $product->gender_target) == 'male' ? 'selected' : '' }}>
                                                                Pria
                                                            </option>
                                                            <option value="female"
                                                                {{ old('gender_target', $product->gender_target) == 'female' ? 'selected' : '' }}>
                                                                Wanita
                                                            </option>
                                                            <option value="unisex"
                                                                {{ old('gender_target', $product->gender_target) == 'unisex' ? 'selected' : '' }}>
                                                                Unisex
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Waktu Pemakaian</label>
                                                        <select name="usage_time" class="form-control">
                                                            <option value="">-- Pilih Waktu --</option>
                                                            <option value="morning"
                                                                {{ old('usage_time', $product->usage_time) == 'morning' ? 'selected' : '' }}>
                                                                Pagi
                                                            </option>
                                                            <option value="night"
                                                                {{ old('usage_time', $product->usage_time) == 'night' ? 'selected' : '' }}>
                                                                Malam
                                                            </option>
                                                            <option value="all_day"
                                                                {{ old('usage_time', $product->usage_time) == 'all_day' ? 'selected' : '' }}>
                                                                Sepanjang Hari
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Kanan -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Situasi Pemakaian</label>
                                                        <select name="situation" class="form-control">
                                                            <option value="">-- Pilih Situasi --</option>
                                                            <option value="indoor"
                                                                {{ old('situation', $product->situation) == 'indoor' ? 'selected' : '' }}>
                                                                Indoor
                                                            </option>
                                                            <option value="outdoor"
                                                                {{ old('situation', $product->situation) == 'outdoor' ? 'selected' : '' }}>
                                                                Outdoor
                                                            </option>
                                                            <option value="mixed"
                                                                {{ old('situation', $product->situation) == 'mixed' ? 'selected' : '' }}>
                                                                Campuran
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Ketahanan Wangi</label>
                                                        <select name="longevity" class="form-control">
                                                            <option value="">-- Pilih Ketahanan --</option>
                                                            <option value="long_last"
                                                                {{ old('longevity', $product->longevity) == 'long_last' ? 'selected' : '' }}>
                                                                Tahan Lama (Seharian)
                                                            </option>
                                                            <option value="light_frequent"
                                                                {{ old('longevity', $product->longevity) == 'light_frequent' ? 'selected' : '' }}>
                                                                Ringan (Sering Semprot Ulang)
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control editor" rows="4">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="category_id" class="form-control select2bs4"
                                                    style="width: 100%;">
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('category_id', $product->category_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Harga (Rp)</label>
                                                <input type="number" name="price"
                                                    value="{{ old('price', $product->price) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Stok</label>
                                                <input type="number" name="stock"
                                                    value="{{ old('stock', $product->stock) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image"
                                                        class="custom-file-input input-img" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        Image</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <img class="image-preview rounded img-preview"
                                                    src="{{ $product->image ? asset('storage/' . $product->image) : '/assets/img/no-image.jpg' }}"
                                                    alt="preview">
                                            </div>

                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="enabled" class="form-control">
                                                    <option value="1"
                                                        {{ old('enabled', $product->enabled) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('enabled', $product->enabled) == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success col-md-3 mx-2">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="/assets/js/ckeditor.js"></script>
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                // The file loader instance to use during the upload. It sounds scary but do not
                // worry — the loader will be passed into the adapter later on in this guide.
                this.loader = loader;
            }
            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }
            // Aborts the upload process.
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }
            // Initializes the XMLHttpRequest object using the URL passed to the constructor.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open('POST', '{{ route('ckeditor.uploadImage') }}', true);
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }
            // Initializes XMLHttpRequest listeners.
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }
                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve({
                        default: response.url
                    });
                });
                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }
            // Prepares the data and sends the request.
            _sendRequest(file) {
                // Prepare the form data.
                const data = new FormData();
                data.append('upload', file);
                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.
                // Send the request.
                this.xhr.send(data);
            }
            // ...
        }

        function SimpleUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };
        }

        ClassicEditor.create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold', 'italic', 'bulletedList', 'numberedList', 'link',
                        '|',
                        'blockQuote',
                        'insertTable',
                        'imageInsert',
                        '|',
                        'code',
                        'codeBlock',
                        'htmlEmbed'
                    ]
                },
                language: 'id',
                licenseKey: '',

                extraPlugins: [SimpleUploadAdapterPlugin],

            })
            .then(editor => {
                window.editor = editor;




            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error(
                    'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                );
                console.warn('Build id: hosofu6grpb-m75gatu85ah8');
                console.error(error);
            });
    </script>

@endsection
