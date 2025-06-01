@extends('layouts.app')

@section('title', 'Lengkapi Data Diri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h4 class="mb-0">Formulir Data Diri</h4>
                <p class="text-muted">Harap isi semua data dengan benar. Data ini akan digunakan untuk proses rekrutmen.
                </p>
            </div>
            <div class="card-body p-4">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Form mengarah ke route update dengan method PUT --}}
                <form method="POST" action="{{ route('candidate.profile.update') }}">
                    @csrf
                    @method('PUT')

                    @php
                    // Ambil profil untuk mempermudah pemanggilan
                    $profile = $user->candidateProfile;
                    @endphp

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="place_of_birth" class="form-label">Tempat Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                                value="{{ old('place_of_birth', $profile?->place_of_birth) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth', $profile?->date_of_birth) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_male"
                                    value="laki-laki"
                                    {{ old('gender', $profile?->gender) == 'laki-laki' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gender_male">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                    value="perempuan"
                                    {{ old('gender', $profile?->gender) == 'perempuan' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gender_female">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon Aktif <span
                                class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                            value="{{ old('phone_number', $profile?->phone_number) }}"
                            placeholder="Contoh: 081234567890" required>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label">Alamat Lengkap Sesuai KTP <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="4"
                            required>{{ old('address', $profile?->address) }}</textarea>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('candidate.profile') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection