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
    <table style="width: 100%; border-collapse: collapse;" border="0">
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
            <th>{{ $order['borrower_status'] }}</th>
        </tr>
        <tr>
        <p>Anda bisa melihat status peminjaman anda pada halaman Website SIPRIG atau dapat menghubungi petugas di nomor 082122567830</p>
            </th>
        </tr>
    </table>

</body>
</html>
