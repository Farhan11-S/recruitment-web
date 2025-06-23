@extends('layouts.app')

@section('title', 'Tes Psikotes')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-center text-white">
            <h1 class="h3 mb-0">Tes Psikotes Online</h1>
          </div>
          <div class="card-body p-4">
            <div class="alert alert-info">
              <strong>Petunjuk:</strong> Pilih satu jawaban yang paling tepat untuk setiap pertanyaan. Tidak
              ada sistem
              pengurangan nilai untuk jawaban yang salah.
            </div>

            <form
              action="{{ route('psychotest.store', $application) }}"
              method="POST"
            >
              @csrf
              <hr>
              @foreach ($questions as $question)
                <div class="mb-5">
                  <p class="fw-bold">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                  <div class="ps-3">
                    {{-- Kita menggunakan relasi 'options' yang sudah di-load dari controller --}}
                    @foreach ($question->options as $option)
                      <div class="form-check">
                        {{-- DIPERBARUI: value radio button sekarang adalah $option->id --}}
                        <input
                          id="option_{{ $option->id }}"
                          class="form-check-input"
                          type="radio"
                          name="answers[{{ $question->id }}]"
                          value="{{ $option->id }}"
                          required
                        >
                        <label
                          class="form-check-label w-100"
                          for="option_{{ $option->id }}"
                        >
                          {{ $option->option_text }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
              <hr>
              <div class="d-grid">
                <button
                  type="submit"
                  class="btn btn-success btn-lg"
                  onclick="return confirm('Apakah Anda yakin ingin menyelesaikan tes ini?')"
                >Selesaikan Tes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
