@extends('layouts1.user')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')
@section('page-subtitle', 'Perbarui password akun Anda')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-key me-2 text-primary"></i>Form Ubah Password</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        <small class="text-muted">Minimal 8 karakter</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Ubah Password
                        </button>
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Tips Keamanan Password</h6>
                <ul class="mb-0 text-muted small">
                    <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                    <li>Hindari menggunakan informasi pribadi seperti nama atau tanggal lahir</li>
                    <li>Jangan gunakan password yang sama dengan akun lain</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
