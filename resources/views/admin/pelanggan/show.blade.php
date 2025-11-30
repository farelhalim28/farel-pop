@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">🏠</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Detail Pelanggan</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <h1 class="h4 mb-3">Detail Pelanggan</h1>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">

                <div class="row">
                    <!-- DATA PELANGGAN -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Data Pribadi</h5>
                        <table class="table table-sm table-borderless">
                            <tr><th width="30%">First Name</th><td>{{ $dataPelanggan->first_name }}</td></tr>
                            <tr><th>Last Name</th><td>{{ $dataPelanggan->last_name }}</td></tr>
                            <tr><th>Birthday</th><td>{{ $dataPelanggan->birthday }}</td></tr>
                            <tr><th>Gender</th><td>{{ $dataPelanggan->gender }}</td></tr>
                            <tr><th>Email</th><td>{{ $dataPelanggan->email }}</td></tr>
                            <tr><th>Phone</th><td>{{ $dataPelanggan->phone }}</td></tr>
                        </table>

                        <a href="{{ route('pelanggan.edit', $dataPelanggan->pelanggan_id) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-edit me-1"></i> Edit Data
                        </a>
                    </div>

                    <!-- FILE LIST -->
                    <div class="col-md-6">
                        <h5 class="mb-3">File Pendukung</h5>

                        @if(isset($files) && $files->count() > 0)
                            <div class="row">
                                @foreach($files as $file)

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

                                    <div class="col-md-6 mb-4">
                                        <div class="card shadow-sm p-2 text-center">

                                            <!-- PREVIEW -->
                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                                    class="rounded border mb-2"
                                                    style="width:150px;height:150px;object-fit:cover;">

                                            @elseif($isVideo)
                                                <video width="150" height="150" controls class="rounded border mb-2" style="object-fit:cover;">
                                                    <source src="{{ asset('storage/' . $file->file_path) }}" type="{{ $mime }}">
                                                </video>

                                            @else
                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                   class="btn btn-outline-secondary w-100 mb-2" target="_blank">
                                                    📄 {{ $file->original_name }}
                                                </a>
                                            @endif

                                            <!-- TITLE -->
                                            <p class="small text-muted text-truncate mb-2">{{ $file->original_name }}</p>

                                            <!-- BUTTON -->
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" download class="btn btn-outline-success">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">Belum ada file pendukung.</div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
