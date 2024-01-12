@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('category.update', $category->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="category" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" value="{{ $category->name }}" name="category">
                        @error('category')
                            <div class="valid-feedback">
                                {{ $message }}
                              </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
