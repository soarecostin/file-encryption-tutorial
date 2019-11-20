@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form action="{{ route('uploadFile') }}" method="post" enctype="multipart/form-data" class="my-4">
                        @csrf

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="userFile" name="userFile">
                                <label class="custom-file-label" for="userFile">Choose a file</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Upload</button>

                        @if (session()->has('message'))
                            <div class="alert alert-success mt-3">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>

                    <ul class="list-group">
                        @forelse ($files as $file)
                            <li class="list-group-item">
                                <a href="{{ route('downloadFile', basename($file)) }}">
                                    {{ basename($file) }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">You have no files</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
