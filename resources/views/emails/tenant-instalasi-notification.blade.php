<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan Instalasi</title>
</head>
<body>
    <h2>Notifikasi Pengajuan Instalasi</h2>
    <p>Halo,</p>
    <p>Pengajuan instalasi Anda dengan nomor tiket <strong>{{ $instalasi->nomor_tiket }}</strong> telah berhasil diterima.</p>
    <p>Detail pengajuan:</p>
    <ul>
        <li>Nama Perusahaan: {{ $instalasi->nama_perusahaan }}</li>
        <li>Kontak Person: {{ $instalasi->kontak_person }}</li>
        <li>Nomor Telepon: {{ $instalasi->nomor_telepon }}</li>
        <li>Lokasi Instalasi: {{ $instalasi->lokasi_instalasi }}</li>
        <li>Jenis Layanan: {{ $instalasi->jenis_layanan }}</li>
        <li>Kecepatan Bandwidth: {{ $instalasi->kecepatan_bandwidth }}</li>
        <li>Tanggal Permintaan: {{ $instalasi->tanggal_permintaan }}</li>
        <li>Tanggal Instalasi: {{ $instalasi->tanggal_instalasi ?? 'Belum ditentukan' }}</li>
        <li>Waktu Instalasi: {{ $instalasi->waktu_instalasi ?? 'Belum ditentukan' }}</li>
        <li>Tingkat Urgensi: {{ $instalasi->tingkat_urgensi }}</li>
        <li>Catatan Tambahan: {{ $instalasi->catatan_tambahan ?? '-' }}</li>
    </ul>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>
