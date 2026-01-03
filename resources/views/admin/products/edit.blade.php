@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<h1 class="text-3xl font-bold text-beauty-text mb-6">Edit Product</h1>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($product->images->count() > 0)
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Current Images</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($product->images as $image)
        <div class="relative group border rounded-lg overflow-hidden h-40">
            @php
                $imagePath = str_starts_with($image->image, 'http') ? $image->image : asset('storage/' . $image->image);
            @endphp
            <img src="{{ $imagePath }}" alt="Product Image" class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <form action="{{ route('admin.products.image.delete', $image->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition" 
                            onclick="return confirm('Delete this image?')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn focus:border-transparent outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
            <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
            <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none">
                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none transition">{{ old('description', $product->description) }}</textarea>
        </div>
        
        <!-- Image Upload Section -->
        <div class="md:col-span-1 border-t pt-4">
            <label class="block text-sm font-bold text-gray-800 mb-2">Upload New Images</label>
            <input type="file" name="images[]" multiple accept="image/*" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-beauty-btn file:text-white hover:file:bg-secondary">
            <p class="text-xs text-gray-500 mt-2">Max 2MB per image (jpeg, png, jpg, gif, webp)</p>
        </div>

        <!-- Image URL Section -->
        <div class="md:col-span-1 border-t pt-4">
            <label class="block text-sm font-bold text-gray-800 mb-2">Add via URL</label>
            <div id="url-container" class="space-y-2">
                @php
                    $urlImages = $product->images->filter(function($img) {
                        return str_starts_with($img->image, 'http');
                    });
                @endphp

                @if($urlImages->count() > 0)
                    @foreach($urlImages as $image)
                        <div class="group mb-4 border border-gray-100 rounded-lg p-3 bg-gray-50">
                            <div class="flex gap-2 mb-2">
                                <input type="url" name="image_urls[]" value="{{ $image->image }}" placeholder="https://example.com/image.jpg" 
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none"
                                       oninput="handleUrlInput(this)">
                                <button type="button" onclick="this.closest('.group').remove()" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">&times;</button>
                            </div>
                            <div class="preview-area w-full h-32 rounded-lg bg-gray-200 overflow-hidden relative flex items-center justify-center">
                                <img src="{{ $image->image }}" alt="Preview" class="w-full h-full object-contain">
                                <div class="error-msg hidden absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span class="text-xs font-medium">Image not found</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="group mb-4 border border-gray-100 rounded-lg p-3 bg-gray-50">
                        <div class="flex gap-2 mb-2">
                            <input type="url" name="image_urls[]" placeholder="https://example.com/image.jpg" 
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none"
                                   oninput="handleUrlInput(this)">
                            <button type="button" onclick="addUrlField()" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">+</button>
                        </div>
                        <div class="preview-area hidden w-full h-32 rounded-lg bg-gray-200 overflow-hidden relative flex items-center justify-center">
                            <img src="" alt="Preview" class="w-full h-full object-contain">
                            <div class="error-msg hidden absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="text-xs font-medium">Image not found</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <p class="text-xs text-gray-500 mt-2">Paste full image URLs</p>
        </div>
    </div>
    
    <div class="mt-8 flex gap-4 pt-6 border-t">
        <button type="submit" class="px-6 py-2 bg-beauty-btn text-white rounded-lg hover:bg-secondary transition-all shadow-md active:scale-95">
            Update Product
        </button>
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition active:scale-95">
            Cancel
        </a>
    </div>
</form>

<script>
    function addUrlField() {
        const container = document.getElementById('url-container');
        const div = document.createElement('div');
        div.className = 'group mb-4 border border-gray-100 rounded-lg p-3 bg-gray-50';
        div.innerHTML = `
            <div class="flex gap-2 mb-2">
                <input type="url" name="image_urls[]" placeholder="https://example.com/image.jpg" 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-beauty-btn outline-none"
                       oninput="handleUrlInput(this)">
                <button type="button" onclick="this.closest('.group').remove()" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">&times;</button>
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
        const wrapper = input.closest('.group');
        const previewArea = wrapper.querySelector('.preview-area');
        const img = previewArea.querySelector('img');
        const errorMsg = wrapper.querySelector('.error-msg');
        const fileInput = document.querySelector('input[type="file"]');

        if (input.value) {
            // Check for conflict with file upload
            if (fileInput.files.length > 0) {
                if(confirm('You have selected files for upload. Do you want to use the URL instead? This will clear your file selection.')) {
                    fileInput.value = ''; 
                } else {
                    input.value = ''; 
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

    // Monitor File Input
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
                    input.closest('.group').querySelector('.preview-area').classList.add('hidden');
                });
            } else {
                this.value = ''; 
            }
        }
    });

    // Initialize existing inputs if any (e.g. after validation error)
    document.querySelectorAll('input[name="image_urls[]"]').forEach(input => {
        if(input.value) handleUrlInput(input);
    });
</script>
@endsection
