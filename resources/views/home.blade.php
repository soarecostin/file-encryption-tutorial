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

                    <h4>Your files</h4>
                    <ul class="list-group">
                        @forelse ($s3Files as $file)
                            <li class="list-group-item">
                                <a href="{{ route('downloadFile', basename($file)) }}">
                                    {{ basename($file) }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">You have no files</li>
                        @endforelse
                    </ul>

                    @if (!empty($localFiles))
                    <hr />
                    <h4>Uploading and encrypting...</h4>
                    <ul class="list-group">
                        @foreach ($localFiles as $file)
                            <li class="list-group-item">
                                {{ basename($file) }}
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
