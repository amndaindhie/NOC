<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Installation Request Notification</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f4f4f4; padding:20px 0;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#1e4356" style="padding:20px;">
                            <h1 style="color:#ffffff; margin:0; font-size:22px;">Installation Request Notification</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Hello,</p>
                            <p>Your installation request with ticket number <strong>{{ $instalasi->nomor_tiket }}</strong> has been successfully received.</p>
                            <p><strong>Installation Details:</strong></p>
                            
                            <table width="100%" cellpadding="8" cellspacing="0" border="0" style="border:1px solid #e0e0e0; border-radius:6px; margin-top:10px; margin-bottom:20px; font-size:14px;">
                                <tr style="background-color:#f9f9f9;">
                                    <td width="40%"><strong>Company Name</strong></td>
                                    <td>{{ $instalasi->nama_perusahaan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Contact Person</strong></td>
                                    <td>{{ $instalasi->kontak_person }}</td>
                                </tr>
                                <tr style="background-color:#f9f9f9;">
                                    <td><strong>Phone Number</strong></td>
                                    <td>{{ $instalasi->nomor_telepon }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Installation Location</strong></td>
                                    <td>{{ $instalasi->lokasi_instalasi }}</td>
                                </tr>
                                <tr style="background-color:#f9f9f9;">
                                    <td><strong>Service Type</strong></td>
                                    <td>{{ $instalasi->jenis_layanan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bandwidth Speed</strong></td>
                                    <td>{{ $instalasi->kecepatan_bandwidth }}</td>
                                </tr>
                                <tr style="background-color:#f9f9f9;">
                                    <td><strong>Request Date</strong></td>
                                    <td>{{ $instalasi->tanggal_permintaan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Installation Date</strong></td>
                                    <td>{{ $instalasi->tanggal_instalasi ?? 'Not yet determined' }}</td>
                                </tr>
                                <tr style="background-color:#f9f9f9;">
                                    <td><strong>Installation Time</strong></td>
                                    <td>{{ $instalasi->waktu_instalasi ?? 'Not yet determined' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Urgency Level</strong></td>
                                    <td>{{ $instalasi->tingkat_urgensi }}</td>
                                </tr>
                                <tr style="background-color:#f9f9f9;">
                                    <td><strong>Additional Notes</strong></td>
                                    <td>{{ $instalasi->catatan_tambahan ?? '-' }}</td>
                                </tr>
                            </table>

                            <p>Thank you for using our service.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#f0f0f0" align="center" style="padding:15px; font-size:12px; color:#777777;">
                            &copy; {{ date('Y') }} NOC System. All rights reserved.
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
