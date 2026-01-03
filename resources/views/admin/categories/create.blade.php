@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<h1 class="text-3xl font-bold text-beauty-text mb-6">Add New Category</h1>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 max-w-2xl">
    @csrf
    
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">Category Name *</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"></textarea>
        </div>
    </div>
    
    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-beauty-btn text-white rounded-lg hover:bg-secondary transition">
            Create Category
        </button>
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            Cancel
        </a>
    </div>
</form>
@endsection
