@extends('layouts.admin')
@section('website-content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category Infomation:</h3>
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
                        <a href="{{ route('admin.category') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Modify Category</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.category.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id" value="{{ $cat->id }}" />
                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span>
                        </div>
                        <input class="flex-grow" type="text" placeholder="Category name" name="name" tabindex="0"
                            value="{{ $cat->name }}" aria-required="true" required="">
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span>
                        </div>
                        <input class="flex-grow" type="text" placeholder="Category Slug" name="slug" tabindex="0"
                            value="{{ $cat->slug }}" aria-required="true" required="">
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($cat->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('uploads/category_images') }}/{{ $cat->image }}" class="effect8"
                                        alt="{{ $cat->name }}">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('website-script')
    <script>
        $(function() {
            // File input change event
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
