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
                    <option value="">-- Select Option --</option>
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
                <input type="file" name="image" class="file-input" id="image" required accept="image/*">
                <label for="image" class="file-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span class="file-text">Choose a file</span>
                </label>
                <div class="file-name"></div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn submit-btn">Add Product</button>
            <a href="{{ route('admin.manageproducts') }}" class="btn cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<style>
    /* Modern Form Styling */
    .product-form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .alert {
        padding: 16px;
        margin-bottom: 25px;
        border-radius: 6px;
        display: flex;
        align-items: flex-start;
    }

    .alert-icon {
        margin-right: 10px;
        font-size: 18px;
    }

    .success-alert {
        background-color: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid #4caf50;
    }

    .error-alert {
        background-color: #ffebee;
        color: #c62828;
        border-left: 4px solid #f44336;
    }

    .error-alert ul {
        margin-top: 10px;
        padding-left: 25px;
    }

    .error-alert li {
        margin-bottom: 5px;
    }

    .product-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 5px;
        width: 100%;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 5px;
    }

    .form-row .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #444;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #4a574b;
        box-shadow: 0 0 0 3px rgba(74, 87, 75, 0.1);
        outline: none;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    .form-select:disabled {
        background-color: #f9f9f9;
        cursor: not-allowed;
    }

    /* File Upload Styling */
    .file-upload-container {
        margin-top: 10px;
    }

    .file-upload {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 0;
        width: 0;
        opacity: 0;
    }

    .file-label {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        color: #495057;
        padding: 12px 15px;
        border-radius: 6px;
        border: 2px dashed #ddd;
        cursor: pointer;
        transition: all 0.3s;
    }

    .file-label:hover {
        background-color: #e9ecef;
        border-color: #4a574b;
    }

    .file-label i {
        font-size: 20px;
        margin-right: 8px;
    }

    .file-name {
        margin-top: 8px;
        font-size: 14px;
        color: #666;
    }

    /* Button Styling */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }

    .btn {
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .submit-btn {
        background-color: #4a574b;
        color: white;
    }

    .submit-btn:hover {
        background-color: #3d4a3e;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .cancel-btn {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ddd;
    }

    .cancel-btn:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-form-container {
            padding: 20px;
            margin: 20px;
        }

        .form-row {
            flex-direction: column;
            gap: 10px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

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