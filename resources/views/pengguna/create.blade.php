<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label">
                        <b>Nama Lengkap</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap..."
                        value="{{ old('nama_lengkap') }}" required>
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
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>
                            Admin</option>
                        <option value="Staff Kepaniteraan Hukum"
                            {{ old('role') == 'Staff Kepaniteraan Hukum' ? 'selected' : '' }}>
                            Staff Kepaniteraan Hukum</option>
                        <option value="Staff Kepaniteraan Perdata"
                            {{ old('role') == 'Staff Kepaniteraan Perdata' ? 'selected' : '' }}>Staff Kepaniteraan
                            Perdata</option>
                        <option value="Staff Kepaniteraan Pidana"
                            {{ old('role') == 'Staff Kepaniteraan Pidana' ? 'selected' : '' }}>Staff Kepaniteraan Pidana
                        </option>
                        <option value="Panitera" {{ old('role') == 'Panitera' ? 'selected' : '' }}>Panitera</option>
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
                        name="username" required placeholder="Masukkan username" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <b>Password</b><span class="text-danger">*</span>
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-end">Tambah Pengguna</button>
            </form>

        </div>
    </div>
</x-layout>
