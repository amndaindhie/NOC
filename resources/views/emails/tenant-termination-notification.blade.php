<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan Terminasi</title>
</head>
<body>
    <h2>Notifikasi Pengajuan Terminasi</h2>
    <p>Halo,</p>
    <p>Pengajuan terminasi Anda dengan nomor tiket <strong>{{ $termination->nomor_tiket }}</strong> telah berhasil diterima.</p>
    <p>Detail pengajuan:</p>
    <ul>
        <li>Nama Tenant: {{ $termination->nama_tenant }}</li>
        <li>Lokasi: {{ $termination->lokasi }}</li>
        <li>Alasan Terminasi: {{ $termination->alasan_terminasi }}</li>
        <li>Tanggal Efektif: {{ $termination->tanggal_efektif }}</li>
        <li>Status: {{ $termination->status }}</li>
    </ul>
    <p>Tim kami akan memproses permintaan terminasi Anda sesuai dengan kebijakan yang berlaku.</p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>
