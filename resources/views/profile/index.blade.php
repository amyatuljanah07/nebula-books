@extends('layouts1.user')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi profil Anda')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px; background: #5B4B9F; font-size: 3rem; color: white;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Profil</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <table class="table table-borderless">
                    <tr><th width="150">Nama</th><td>{{ $user->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Telepon</th><td>{{ $user->phone ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $user->address ?? '-' }}</td></tr>
                    <tr><th>Kota</th><td>{{ $user->city ?? '-' }}</td></tr>
                    <tr><th>Kode Pos</th><td>{{ $user->postal_code ?? '-' }}</td></tr>
                    <tr><th>Bergabung</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <a href="{{ route('profile.change-password') }}" class="btn btn-outline-primary">
                    <i class="fas fa-key me-2"></i>Ubah Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
