@extends('layouts.main')

@section('container')
    <h1 class="mb-5">Post Categories</h1>
    <div class="container">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-md-4">
                <a href="/posts?category={{ $category->slug }}">
                <div class="card mb-3">
                    <img src="https://source.unsplash.com/500x500?{{ $category->name }}" class="card-img-top" alt="{{ $category->name }}">
                    <div class="card-image-overlay">
                      <h5 class="card-title">{{ $category->name }}</h5>
                    </div>
                </div>
                </a>    
            </div>
            @endforeach
        </div>
    </div>
@endsection



