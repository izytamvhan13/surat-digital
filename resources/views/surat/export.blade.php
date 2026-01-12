<!DOCTYPE html>
<html>

<head>
    <title>Ekspor Surat Masuk</title>
</head>

<body>
    <h2>Ekspor Surat Masuk ke Spreadsheet</h2>
    <p>Klik tombol di bawah untuk mengunduh semua data surat masuk dalam format Excel.</p>
    <a href="{{ route('surat.export') }}">
        <button>Download Excel</button>
    </a>
    <br><br>
    <a href="{{ route('surat.index') }}">⬅ Kembali</a>
</body>

</html>