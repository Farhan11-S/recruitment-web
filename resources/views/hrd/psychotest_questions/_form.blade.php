@csrf
<div class="mb-3">
  <label
    for="question_text"
    class="form-label"
  >Teks Pertanyaan</label>
  <textarea
    id="question_text"
    name="question_text"
    class="form-control"
    rows="3"
    required
  >{{ old('question_text', $question->question_text ?? '') }}</textarea>
</div>
<hr>
<h6>Pilihan Jawaban (Pilih satu jawaban yang benar)</h6>
@for ($i = 0; $i < 4; $i++)
  <div class="input-group mb-3">
    <div class="input-group-text">
      <input
        class="form-check-input mt-0"
        type="radio"
        name="is_correct"
        value="{{ $i }}"
        {{ old('is_correct', $correct_answer_index ?? '') == $i ? 'checked' : '' }}
        required
      >
    </div>
    <input
      type="text"
      name="options[]"
      class="form-control"
      placeholder="Teks Opsi {{ $i + 1 }}"
      value="{{ old('options.' . $i, $question->options[$i]->option_text ?? '') }}"
      required
    >
  </div>
@endfor
@error('options.*')
  <small class="text-danger">{{ $message }}</small>
@enderror
@error('is_correct')
  <small class="text-danger">{{ $message }}</small>
@enderror

<div class="d-flex justify-content-end mt-4 gap-2">
  <a
    href="{{ route('hrd.psychotest_questions.index') }}"
    class="btn btn-secondary"
  >Batal</a>
  <button
    type="submit"
    class="btn btn-primary"
  >Simpan Soal</button>
</div>
