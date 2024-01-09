<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
</head>
<body style="font-family: 'Helvetica', 'Arial', sans-serif;">
    <h1>Status Peminjaman</h1>
    <p>Terima kasih telah melakukan peminjaman ruangan di SIPRIG (Sistem Informasi Peminjaman Ruangan dan Inventaris Gereja Kristen Jawa Pamulang). Berikut merupakan detail dari peminjaman yang telah anda lakukan.</p>
    <table style="width: 100%; border-collapse: collapse;" border="1">
        <tr>
            <td>Nomor Resi</td>
            <th>{{ $order['id'] }}</th>
        </tr>
        <tr>
            <td>Nama Peminjam</td>
            <th>{{ $order['full_name'] }}</th>
        </tr>
        <tr>
            <td>Status Peminjam</td>
            <th>{{ $order['status_peminjam'] }}</th>
        </tr>
        <tr>
            <td>Status</td>
            <th>
                @php
                    $status = '';

                    switch ($order['admin_approval_status']) {
                        case 1:
                            if ($order['returned_at'] != null) {
                                $status = 'Peminjaman selesai';
                            } else {
                                $status = 'Sudah disetujui';
                            }
                            break;
                        case 2:
                            $status = 'Ditolak';
                            break;
                        default:
                            // Handle other cases or set a default value
                            break;
                    }

                @endphp

               {{$status}}

            </th>
        </tr>
    </table>

</body>
</html>
