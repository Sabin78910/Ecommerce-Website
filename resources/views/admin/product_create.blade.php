@extends('layouts.admin')
@section('website-content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Create Product:</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.products.save') }}">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ old('name') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0"
                            value="{{ old('slug') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option>Choose category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option>Choose Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0"
                            aria-required="true" required="">{{ old('short_description') }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('short_description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"
                            required="">{{ old('description') }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8"
                                    alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('file')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <!-- <div class="item">
                                    <img src="images/upload/upload-1.png" alt="">
                                </div>                                                 -->
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*"
                                        multiple="">
                                </label>
                            </div>
                        </div>
                        <!-- Gallery Preview Section -->
                        <div id="galleryPreview" class="gallery-preview"></div>
                    </fieldset>
                    @error('images[]')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price"
                                tabindex="0" value="{{ old('regular_price') }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price"
                                tabindex="0" value="{{ old('sale_price') }}" aria-required="true" required="">
                        </fieldset>
                        @error('sale_price')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0"
                                value="{{ old('SKU') }}" aria-required="true" required="">
                        </fieldset>
                        @error('SKU')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                tabindex="0" value="{{ old('quantity') }}" aria-required="true" required="">
                        </fieldset>
                        @error('quantity')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock">InStock</option>
                                    <option value="outofstock">Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection

@push('website-script')
    <script>
        $(function() {
            // Single image preview
            $("#myFile").on("change", function() {
                const file = this.files[0];
                const validTypes = ["image/jpeg", "image/png", "image/gif"];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (file) {
                    if (!validTypes.includes(file.type)) {
                        alert("Please upload a valid image file (JPEG, PNG, or GIF).");
                        $(this).val("");
                        return;
                    }

                    if (file.size > maxSize) {
                        alert("File size exceeds 2MB. Please upload a smaller file.");
                        $(this).val("");
                        return;
                    }

                    // Preview the image
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change", function() {
                const files = this.files; // Get selected files
                const validTypes = ["image/jpeg", "image/png", "image/gif"]; // Allowed file types
                const maxSize = 2 * 1024 * 1024; // Maximum file size: 2MB

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Validate file type
                    if (!validTypes.includes(file.type)) {
                        alert(`File ${file.name} is not a valid image type (JPEG, PNG, GIF).`);
                        continue;
                    }

                    // Validate file size
                    if (file.size > maxSize) {
                        alert(`File ${file.name} exceeds the size limit of 2MB.`);
                        continue;
                    }

                    // Create an image element
                    const imgElement = $('<img>')
                        .attr('src', URL.createObjectURL(file)) // Create a preview URL
                        .css({
                            width: '80px', // Fixed width
                            height: '80px', // Fixed height
                            objectFit: 'cover', // Maintain aspect ratio and cover the box
                            border: '1px solid #ccc', // Optional border
                            borderRadius: '5px', // Rounded corners
                            margin: '5px' // Spacing around images
                        });

                    // Prepend the image to the gallery preview section
                    $("#galleryPreview").prepend(imgElement);
                }
            });



            // Generate slug from name
            $("input[name='name']").on("input", function() {
                const name = $(this).val();
                if (name.trim()) {
                    $("input[name='slug']").val(StringToSlug(name));
                }
            });
        });

        // Convert string to slug
        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w\s]/g, "") // Remove all non-word characters except spaces
                .replace(/\s+/g, "-"); // Replace spaces with hyphens
        }
    </script>
@endpush
