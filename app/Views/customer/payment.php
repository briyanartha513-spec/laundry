<script src="https://app.sandbox.midtrans.com/snap/snap.js"></script>

<button id="pay">Bayar</button>

<script>
document.getElementById('pay').onclick = function(){
    snap.pay('<?= $snapToken ?>');
}
</script>