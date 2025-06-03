<!DOCTYPE html>
<html>

  <head>
    <title>Update Status Lamaran</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
      }

      .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
      }

      .header {
        font-size: 24px;
        font-weight: bold;
        color: #0d6efd;
      }

      .content {
        margin-top: 20px;
      }

      .footer {
        margin-top: 30px;
        font-size: 12px;
        color: #888;
      }

      .button {
        display: inline-block;
        padding: 10px 20px;
        margin: 20px 0;
        background-color: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="header">
        Update Proses Lamaran Anda
      </div>
      <div class="content">
        <p>Yth. {{ $application->user->name }},</p>

        {{-- Logika untuk menampilkan konten email yang berbeda --}}

        @if ($application->status === 'tes_psikotes')
          <p>Selamat! Setelah melalui tahap seleksi awal, kami ingin memberitahukan bahwa Anda lolos ke tahap
            selanjutnya, yaitu **Tes Psikotes Online**.</p>
          <p>Silakan klik tombol di bawah ini untuk memulai tes. Pastikan Anda berada di lingkungan yang tenang dengan
            koneksi internet yang stabil.</p>
          <a
            href="{{ route('psychotest.show', $application) }}"
            class="button"
          >Mulai Tes Psikotes</a>
        @elseif ($application->status === 'wawancara_pertama' || $application->status === 'wawancara_kedua')
          <p>Selamat! Anda telah lolos ke tahap selanjutnya, yaitu
            **{{ str_replace('_', ' ', $application->status) }}**.</p>
          <p>Kami mengundang Anda untuk hadir secara langsung (offline) di perusahaan kami dengan detail sebagai
            berikut:</p>
          <ul>
            <li><strong>Perusahaan:</strong> {{ config('app.company_name') }}</li>
            <li><strong>Alamat:</strong> {{ config('app.company_address') }}</li>
          </ul>
          <p>Tim HRD kami akan menghubungi Anda lebih lanjut dalam 1-2 hari kerja untuk penjadwalan waktu yang spesifik.
          </p>
        @elseif ($application->status === 'diterima')
          <p>Selamat! Dengan gembira kami memberitahukan bahwa Anda **DITERIMA** untuk posisi
            <strong>{{ $application->jobVacancy->title }}</strong> di {{ config('app.company_name') }}.</p>
          <p>Informasi lebih lanjut mengenai penawaran kerja (offering letter) akan kami kirimkan dalam email terpisah.
          </p>
        @elseif ($application->status === 'ditolak')
          <p>Terima kasih atas partisipasi Anda dalam proses rekrutmen untuk posisi
            <strong>{{ $application->jobVacancy->title }}</strong>. Setelah melalui pertimbangan yang saksama, dengan
            berat hati kami memberitahukan bahwa Anda belum dapat melanjutkan ke tahap berikutnya.</p>
          <p>Kami menghargai waktu dan usaha yang telah Anda berikan dan kami akan menyimpan data Anda untuk kesempatan
            di masa mendatang. Semoga sukses selalu menyertai Anda.</p>
        @endif

        <p>Terima kasih atas perhatian Anda.</p>
      </div>
      <div class="footer">
        <p>Hormat kami,<br>Tim HRD {{ config('app.company_name') }}</p>
        <p><em>Email ini dibuat secara otomatis. Mohon untuk tidak membalas email ini.</em></p>
      </div>
    </div>
  </body>

</html>
