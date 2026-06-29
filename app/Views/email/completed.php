<h2>🎉 Pesanan Laundry Anda Telah Selesai</h2>

<p>
Halo <strong><?= $booking['nama_pelanggan']; ?></strong>,
</p>

<p>
Terima kasih telah mempercayakan kebutuhan laundry Anda kepada kami.
Kami sangat menghargai kepercayaan yang telah Anda berikan dan senang dapat membantu menjaga pakaian Anda tetap bersih dan nyaman digunakan.
</p>

<p>
Pesanan laundry Anda telah selesai diproses dan siap untuk diambil.
</p>

<p>
<strong>Total Pembayaran:</strong><br>
Rp <?= number_format($booking['total_harga'], 0, ',', '.'); ?>
</p>

<p>
Sebagai lampiran, kami juga menyertakan invoice pesanan Anda untuk keperluan dokumentasi dan bukti transaksi.
</p>

<p>
Kami berharap Anda puas dengan layanan yang kami berikan. Kritik dan saran dari Anda akan sangat membantu kami untuk terus meningkatkan kualitas pelayanan.
</p>

<p>
Terima kasih telah menggunakan jasa laundry kami. Kami tunggu pesanan Anda berikutnya 😊
</p>

<br>

<p>
Salam hangat,<br>
<strong>Tim Laundry Management System</strong>
</p>