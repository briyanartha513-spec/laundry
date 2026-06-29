<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= env('Mid-client-0z2G332IawD46hwy'); ?>"></script>
            
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        #pay-button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        #pay-button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2>Konfirmasi Pembayaran Laundry</h2>
    <p>Total Tagihan: <strong>Rp 50.000</strong></p>
    
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        // Ketika tombol "Bayar Sekarang" ditekan
        document.getElementById('pay-button').onclick = function(){
            // Memanggil pop-up Midtrans menggunakan Snap Token dari Controller
            snap.pay('<?= $snapToken; ?>', {
                // Jika pembayaran berhasil
                onSuccess: function(result){
                    alert("Pembayaran berhasil!"); 
                    console.log(result);
                },
                // Jika pelanggan menutup pop-up sebelum bayar
                onPending: function(result){
                    alert("Menunggu pembayaran!"); 
                    console.log(result);
                },
                // Jika pembayaran gagal
                onError: function(result){
                    alert("Pembayaran gagal!"); 
                    console.log(result);
                },
                onClose: function(){
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                }
            });
        };
    </script>
</body>
</html>