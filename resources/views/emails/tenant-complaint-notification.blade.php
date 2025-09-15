<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan Keluhan</title>
</head>
<body>
    <h2>Notifikasi Pengajuan Keluhan</h2>
    <p>Halo,</p>
    <p>Pengajuan keluhan Anda dengan nomor tiket <strong>{{ $complaint->nomor_tiket }}</strong> telah berhasil diterima.</p>
    <p>Detail pengajuan:</p>
    <ul>
        <li>Nama Tenant: {{ $complaint->nama_tenant }}</li>
        <li>Kontak Person: {{ $complaint->kontak_person }}</li>
        <li>Jenis Gangguan: {{ $complaint->jenis_gangguan }}</li>
        <li>Waktu Mulai Gangguan: {{ $complaint->waktu_mulai_gangguan }}</li>
        <li>Deskripsi Gangguan: {{ $complaint->deskripsi_gangguan }}</li>
        <li>Status: {{ $complaint->status }}</li>
    </ul>
    <p>Tim kami akan segera menindaklanjuti keluhan Anda dan berusaha menyelesaikan masalah secepat mungkin.</p>
    <p>Terima kasih telah melaporkan masalah ini kepada kami.</p>
</body>
</html>
