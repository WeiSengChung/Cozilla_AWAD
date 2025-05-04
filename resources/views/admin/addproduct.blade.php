<link rel="stylesheet" href="{{asset('css/addProduct.css')}}">
@include('partials.navigationAdmin')

<div class="product-form-container">
    <h1 class="form-title">Add New Product</h1>

    @if (session('success'))
        <div class="alert success-alert">
            <i class="fas fa-check-circle alert-icon"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert error-alert">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <strong>Whoops!</strong> Please fix the following errors:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storeproduct') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-input" id="name" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" name="price" class="form-input" id="price" step="0.01" min="0" required
                value="{{ old('price') }}">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-textarea" id="description" rows="4"
                required>{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="gender_category" class="form-label">Gender Category</label>
                <select name="gender_category" id="gender_category" class="form-select" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Men" {{ old('gender_category') == 'Men' ? 'selected' : '' }}>Men</option>
                    <option value="Women" {{ old('gender_category') == 'Women' ? 'selected' : '' }}>Women</option>
                    <option value="Kids" {{ old('gender_category') == 'Kids' ? 'selected' : '' }}>Kids</option>
                </select>
            </div>

            <div class="form-group">
                <label for="top_bottom_category" class="form-label">Top or Bottom</label>
                <select name="top_bottom_category" id="top_bottom_category" class="form-select" required disabled>
                    <option value="" styel="font-family: Times">-- Select Option --</option>
                </select>
            </div>

            <div class="form-group">
                <label for="clothes_category" class="form-label">Clothes Category</label>
                <select name="clothes_category" id="clothes_category" class="form-select" required disabled>
                    <option value="">-- Select Category --</option>
                </select>
            </div>
        </div>

        <div class="form-group file-upload-container">
            <label for="image" class="form-label">Product Image</label>
            <div class="file-upload">
                <input type="file" name="image" class="file-input" id="image" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.rtf,.odt,.csv">
                <label for="image" class="file-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span class="file-text">Choose a file</span>
                </label>

                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="file-name"></div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn submit-btn">Add Product</button>
            <a href="{{ route('admin.manageproducts') }}" class="btn cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Product categories based on seeder
        const productCategories = {
            'Men': {
                'top': ['t_shirt', 'long_sleeve', 'hoodies', 'sweatshirt', 'ut'],
                'bottom': ['jeans', 'long_pants', 'shorts', 'chinos', 'ankle_pants']
            },
            'Women': {
                'top': ['t_shirt', 'long_sleeve', 'hoodies', 'sweatshirt', 'blouses'],
                'bottom': ['shorts', 'jeans', 'casual_pants', 'long_pants', 'legging']
            },
            'Kids': {
                'top': ['t_shirt', 'long_sleeve', 'hoodies', 'sweatshirt', 'ut'],
                'bottom': ['jeans', 'long_pants', 'shorts', 'chinos', 'jogger']
            }
        };

        // Format category name for display
        function formatCategoryName(name) {
            return name
                .replace(/_/g, ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        // Get DOM elements
        const genderSelect = document.getElementById('gender_category');
        const topBottomSelect = document.getElementById('top_bottom_category');
        const clothesSelect = document.getElementById('clothes_category');

        // File upload custom handling
        const fileInput = document.getElementById('image');
        const fileNameDisplay = document.querySelector('.file-name');
        const fileText = document.querySelector('.file-text');

        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                fileNameDisplay.textContent = fileName;
                fileText.textContent = 'File selected';
                document.querySelector('.file-label').style.borderColor = '#4a574b';
            } else {
                fileNameDisplay.textContent = '';
                fileText.textContent = 'Choose a file';
                document.querySelector('.file-label').style.borderColor = '#ddd';
            }
        });

        // Handle gender selection change
        genderSelect.addEventListener('change', function () {
            // Reset and disable clothes category dropdown
            clothesSelect.innerHTML = '<option value="">-- Select Category --</option>';
            clothesSelect.disabled = true;

            // Clear and enable top/bottom dropdown
            topBottomSelect.innerHTML = '<option value="">-- Select Option --</option>';

            const selectedGender = this.value;
            if (selectedGender) {
                // Enable top/bottom dropdown
                topBottomSelect.disabled = false;

                // Add top/bottom options
                const topBottom = productCategories[selectedGender];
                if (topBottom) {
                    for (const category in topBottom) {
                        const option = document.createElement('option');
                        option.value = category;
                        option.textContent = formatCategoryName(category);
                        topBottomSelect.appendChild(option);
                    }
                }
            } else {
                topBottomSelect.disabled = true;
            }
        });

        // Handle top/bottom selection change
        topBottomSelect.addEventListener('change', function () {
            // Clear clothes category dropdown
            clothesSelect.innerHTML = '<option value="">-- Select Category --</option>';

            const selectedGender = genderSelect.value;
            const selectedTopBottom = this.value;

            if (selectedGender && selectedTopBottom) {
                // Enable clothes category dropdown
                clothesSelect.disabled = false;

                // Add clothes category options
                const clothesCategories = productCategories[selectedGender][selectedTopBottom];
                if (clothesCategories) {
                    clothesCategories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category;
                        option.textContent = formatCategoryName(category);
                        clothesSelect.appendChild(option);
                    });
                }
            } else {
                clothesSelect.disabled = true;
            }
        });

        // Initialize dropdowns based on any pre-selected values (for form validation errors)
        if (genderSelect.value) {
            genderSelect.dispatchEvent(new Event('change'));

            // If top_bottom_category was previously selected
            const oldTopBottom = "{{ old('top_bottom_category') }}";
            if (oldTopBottom) {
                topBottomSelect.value = oldTopBottom;
                topBottomSelect.dispatchEvent(new Event('change'));

                // If clothes_category was previously selected
                const oldClothes = "{{ old('clothes_category') }}";
                if (oldClothes) {
                    clothesSelect.value = oldClothes;
                }
            }
        }
    });
</script>