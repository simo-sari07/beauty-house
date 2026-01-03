@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<h1 class="text-3xl font-bold text-beauty-text mb-6">Add New Product</h1>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   placeholder="Enter product name"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn focus:border-transparent outline-none transition-all">
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
            <select name="category_id" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all shadow-sm">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Price *</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" required 
                       class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Stock *</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" required 
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all">
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
            <select name="status" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all shadow-sm">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="description" rows="4" 
                      placeholder="Describe the product..."
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all">{{ old('description') }}</textarea>
        </div>
        
        <!-- Image Upload Section -->
        <div class="md:col-span-1 border-t pt-6">
            <label class="block text-sm font-bold text-gray-800 mb-3">Upload Images</label>
            <div class="group relative flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all border-beauty-btn/30 hover:border-beauty-btn">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-beauty-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 font-medium">Click to upload or drag and drop</p>
                    </div>
                    <input type="file" name="images[]" multiple accept="image/*" class="hidden" />
                </label>
            </div>
            <p class="text-xs text-gray-400 mt-2 italic">Max 2MB per image (jpeg, png, jpg, gif, webp)</p>
        </div>

        <!-- Image URL Section -->
        <div class="md:col-span-1 border-t pt-6">
            <label class="block text-sm font-bold text-gray-800 mb-3">Add via URL</label>
            <div id="url-container" class="space-y-3">
                <div class="animate-fade-in group mb-4 border border-gray-100 rounded-xl p-3 bg-gray-50">
                    <div class="flex gap-2 mb-2">
                        <input type="url" name="image_urls[]" placeholder="https://example.com/image.jpg" 
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all"
                               oninput="handleUrlInput(this)">
                        <button type="button" onclick="addUrlField()" 
                                class="px-4 py-2 bg-beauty-btn/10 text-beauty-btn rounded-xl hover:bg-beauty-btn hover:text-white transition-all font-bold">+</button>
                    </div>
                    <div class="preview-area hidden w-full h-32 rounded-lg bg-gray-200 overflow-hidden relative flex items-center justify-center">
                        <img src="" alt="Preview" class="w-full h-full object-contain">
                        <div class="error-msg hidden absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="text-xs font-medium">Image not found</span>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2 italic">Paste full image URLs</p>
        </div>
    </div>
    
    <div class="mt-10 flex gap-4 pt-8 border-t">
        <button type="submit" class="px-8 py-3 bg-beauty-btn text-white rounded-xl hover:bg-secondary transition-all shadow-lg hover:shadow-xl active:scale-95 font-bold">
            Create Product
        </button>
        <a href="{{ route('admin.products.index') }}" 
           class="px-8 py-3 border border-gray-300 text-gray-600 rounded-xl hover:bg-gray-50 transition-all font-bold active:scale-95">
            Cancel
        </a>
    </div>
</form>

<script>
    function addUrlField() {
        const container = document.getElementById('url-container');
        const count = container.children.length;
        const div = document.createElement('div');
        div.className = 'animate-fade-in group mb-4 border border-gray-100 rounded-xl p-3 bg-gray-50';
        div.innerHTML = `
            <div class="flex gap-2 mb-2">
                <input type="url" name="image_urls[]" placeholder="https://example.com/image.jpg" 
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-beauty-btn outline-none transition-all"
                       oninput="handleUrlInput(this)">
                <button type="button" onclick="this.closest('.animate-fade-in').remove()" 
                        class="px-4 py-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all font-bold">&times;</button>
            </div>
            <div class="preview-area hidden w-full h-32 rounded-lg bg-gray-200 overflow-hidden relative flex items-center justify-center">
                <img src="" alt="Preview" class="w-full h-full object-contain">
                <div class="error-msg hidden absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-xs font-medium">Image not found</span>
                </div>
            </div>
        `;
        container.appendChild(div);
    }

    function handleUrlInput(input) {
        const wrapper = input.closest('.animate-fade-in');
        const previewArea = wrapper.querySelector('.preview-area');
        const img = previewArea.querySelector('img');
        const errorMsg = wrapper.querySelector('.error-msg');
        const fileInput = document.querySelector('input[type="file"]');

        if (input.value) {
            // Check for conflict with file upload
            if (fileInput.files.length > 0) {
                if(confirm('You have selected files for upload. Do you want to use the URL instead? This will clear your file selection.')) {
                    fileInput.value = ''; // Clear file input
                } else {
                    input.value = ''; // Clear URL input
                    return;
                }
            }
            
            previewArea.classList.remove('hidden');
            img.classList.remove('hidden');
            errorMsg.classList.add('hidden');
            
            img.src = input.value;
            img.onload = () => {
                img.classList.remove('hidden');
                errorMsg.classList.add('hidden');
            };
            img.onerror = () => {
                img.classList.add('hidden');
                errorMsg.classList.remove('hidden');
            };
        } else {
            previewArea.classList.add('hidden');
        }
    }

    // Monitor File Input for Conflict
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        const urlInputs = document.querySelectorAll('input[name="image_urls[]"]');
        let hasUrl = false;
        urlInputs.forEach(input => {
            if(input.value) hasUrl = true;
        });

        if (this.files.length > 0 && hasUrl) {
            if(confirm('You have entered image URLs. Do you want to upload files instead? This will clear the URLs.')) {
                urlInputs.forEach(input => {
                    input.value = '';
                    input.closest('.animate-fade-in').querySelector('.preview-area').classList.add('hidden');
                });
            } else {
                this.value = ''; // Clear file input
            }
        }
    });
</script>
@endsection
