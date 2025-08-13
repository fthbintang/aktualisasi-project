<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label">
                        <b>Nama Lengkap</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap..."
                        value="{{ $pengguna->nama_lengkap }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">
                        <b>Role</b><span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                        required>
                        <option value="" disabled {{ old('role', $pengguna->role) ? '' : 'selected' }}>Pilih Role
                        </option>
                        <option value="Kepaniteraan Hukum"
                            {{ old('role', $pengguna->role) == 'Kepaniteraan Hukum' ? 'selected' : '' }}>
                            Kepaniteraan Hukum
                        </option>
                        <option value="Kepaniteraan Perdata"
                            {{ old('role', $pengguna->role) == 'Kepaniteraan Perdata' ? 'selected' : '' }}>
                            Kepaniteraan Perdata
                        </option>
                        <option value="Kepaniteraan Pidana"
                            {{ old('role', $pengguna->role) == 'Kepaniteraan Pidana' ? 'selected' : '' }}>
                            Kepaniteraan Pidana
                        </option>
                        <option value="Panitera" {{ old('role', $pengguna->role) == 'Panitera' ? 'selected' : '' }}>
                            Panitera
                        </option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">
                        <b>Username</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" required placeholder="Masukkan username" value="{{ $pengguna->username }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <b>Password</b>
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Masukkan password baru (opsional)">
                    <small class="text-muted">Isi hanya jika ingin mengubah password</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-end">Ubah Pengguna</button>
            </form>

        </div>
    </div>
</x-layout>
