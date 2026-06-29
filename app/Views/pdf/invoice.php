<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice Laundry</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header{
            text-align:center;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table td{
            padding:8px;
            border:1px solid #ddd;
        }

        .total{
            margin-top:20px;
            text-align:right;
            font-size:16px;
            font-weight:bold;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            font-size:12px;
            color:#666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>INVOICE LAUNDRY</h2>
        <p>Terima kasih telah menggunakan jasa laundry kami</p>
    </div>

    <table>
        <tr>
            <td width="35%"><strong>Nama Customer</strong></td>
            <td>Customer ID: <?= $booking['user_id'] ?></td>
        </tr>

        <tr>
            <td><strong>Tanggal Booking</strong></td>
            <td><?= $booking['tanggal_booking'] ?></td>
        </tr>

        <?php if(isset($booking['berat'])) : ?>
        <tr>
            <td><strong>Berat Cucian</strong></td>
            <td><?= $booking['berat'] ?> Kg</td>
        </tr>
        <?php endif; ?>

        <tr>
            <td><strong>Jenis Layanan</strong></td>
            <td><?= $booking['nama_paket'] ?></td>
        </tr>


    </table>

    <div class="total">
        Total Bayar :
        Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?>
    </div>

    <div class="footer">
        <p>
            Invoice ini dibuat secara otomatis oleh sistem Laundry Management System.
        </p>

        <p>
            Terima kasih atas kepercayaan Anda menggunakan layanan kami.
            Kami berharap dapat melayani Anda kembali di kesempatan berikutnya.
        </p>
    </div>

</body>
</html>