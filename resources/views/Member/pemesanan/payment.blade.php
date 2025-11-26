<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Complete Your Payment</title>
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Complete Your Payment</h1>
    <p>Booking Code: {{ $pemesanan->kode_pemesanan }}</p>
    <p>Total Price: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>

    <button id="pay-button">Pay Now</button>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('pemesanan.my') }}";
                },
                onPending: function(result){
                    window.location.href = "{{ route('pemesanan.my') }}";
                },
                onError: function(result){
                    alert('Payment failed or canceled. Please try again.');
                }
            });
        });
    </script>
</body>
</html>
