@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">🏠</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Edit Pelanggan</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <h1 class="h4">Edit Pelanggan</h1>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">

                {{-- ERROR VALIDATION --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>⚠️ Terjadi kesalahan:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM UPDATE --}}
                <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $dataPelanggan->first_name }}">
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $dataPelanggan->last_name }}">
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">Birthday *</label>
                            <input type="date" name="birthday" class="form-control" value="{{ $dataPelanggan->birthday }}">
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select">
                                <option value="Male" {{ $dataPelanggan->gender == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ $dataPelanggan->gender == 'Female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ $dataPelanggan->email }}">
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" value="{{ $dataPelanggan->phone }}">
                        </div>
                    </div>

                    <hr>

                    <h5>Upload File Pendukung (Foto, Video, PDF, Zip, Doc dll)</h5>
                    <input type="file" name="files[]" class="form-control mb-3" multiple>

                    <button class="btn btn-primary mt-2">
                        <i class="fas fa-save me-1"></i> Update & Upload
                    </button>
                </form>

                {{-- FILE LIST --}}
                @php
                    $files = \App\Models\MultipleUpload::where('ref_table', 'pelanggan')
                        ->where('ref_id', $dataPelanggan->pelanggan_id)
                        ->get();
                @endphp

                @if($files->count() > 0)
                    <hr>
                    <h5>File yang sudah diupload</h5>

                    <div class="row mt-3">
                        @foreach ($files as $file)
                            <div class="col-md-3 mb-4 text-center p-2">

                                @php
                                    $ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                    $isVideo = in_array($ext, ['mp4','mov','avi','mkv','webm']);

                                    $mimeTypes = [
                                        'mp4' => 'video/mp4',
                                        'webm' => 'video/webm',
                                        'mov' => 'video/quicktime',
                                        'avi' => 'video/x-msvideo',
                                        'mkv' => 'video/x-matroska'
                                    ];

                                    $mime = $mimeTypes[$ext] ?? 'video/mp4';
                                @endphp

                                {{-- PREVIEW --}}
                                @if($isImage)
                                    <img src="{{ asset('storage/' . $file->file_path) }}"
                                        class="img-thumbnail mb-2"
                                        style="width: 150px; height: 150px; object-fit: cover;">

                                @elseif($isVideo)
                                    <video width="150" height="150" controls class="rounded border mb-2" style="object-fit:cover;">
                                        <source src="{{ url('/stream/' . basename($file->file_path)) }}" type="{{ $mime }}">
                                        Browser tidak mendukung video.
                                    </video>

                                @else
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                        class="btn btn-outline-secondary w-100 mb-2">
                                        📄 {{ $file->original_name }}
                                    </a>
                                @endif

                                {{-- DELETE --}}
                                <form action="{{ route('multipleupload.destroy', $file->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">Hapus</button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
