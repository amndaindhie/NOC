<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan Maintenance</title>
</head>
<body>
    <h2>Notifikasi Pengajuan Maintenance</h2>
    <p>Halo,</p>
    <p>Pengajuan maintenance Anda dengan nomor tracking <strong>{{ $maintenance->nomor_tracking }}</strong> telah berhasil diterima.</p>
    <p>Detail pengajuan:</p>
    <ul>
        <li>Nama Tenant: {{ $maintenance->nama_tenant }}</li>
        <li>Lokasi Perangkat: {{ $maintenance->lokasi_perangkat }}</li>
        <li>Jenis Maintenance: {{ $maintenance->jenis_maintenance }}</li>
        <li>Deskripsi Masalah: {{ $maintenance->deskripsi_masalah }}</li>
        <li>Tingkat Urgensi: {{ $maintenance->tingkat_urgensi }}</li>
        <li>Tanggal Permintaan: {{ $maintenance->tanggal_permintaan }}</li>
        <li>Tanggal Mulai: {{ $maintenance->tanggal_mulai ?? 'Belum ditentukan' }}</li>
        <li>Tanggal Selesai: {{ $maintenance->tanggal_selesai ?? 'Belum ditentukan' }}</li>
        <li>Status: {{ $maintenance->status }}</li>
    </ul>
    <p>Tim kami akan segera menindaklanjuti permintaan Anda.</p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>
