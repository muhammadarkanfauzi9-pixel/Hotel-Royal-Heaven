{
    // ... existing methods here ...

    /**
     * Handle Midtrans payment notification webhook callback
     */
    public function midtransNotification(Request $request)
    {
        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notif = new \Midtrans\Notification();

        // Get order_id from Midtrans notification
        $orderId = $notif->order_id ?? null;
        $transactionStatus = $notif->transaction_status ?? null;
        $fraudStatus = $notif->fraud_status ?? null;
        $paymentType = $notif->payment_type ?? null;

        if (!$orderId) {
            return response('Invalid notification', 400);
        }

        // Find the booking record
        $pemesanan = Pemesanan::where('kode_pemesanan', $orderId)->first();

        if (!$pemesanan) {
            return response('Booking not found', 404);
        }

        // Update booking status based on Midtrans transaction status
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    // Payment challenge
                    $pemesanan->payment_status = 'challenge';
                    $pemesanan->status_pemesanan = 'pending';
                } else {
                    // Payment success
                    $pemesanan->payment_status = 'paid';
                    $pemesanan->status_pemesanan = 'confirmed';
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            // Payment success
            $pemesanan->payment_status = 'paid';
            $pemesanan->status_pemesanan = 'confirmed';
        } elseif ($transactionStatus == 'pending') {
            $pemesanan->payment_status = 'pending';
            $pemesanan->status_pemesanan = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesanan->payment_status = 'failed';
            $pemesanan->status_pemesanan = 'cancelled';

            // Mark room as available again
            if ($pemesanan->kamar) {
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        }

        $pemesanan->save();

        return response('OK', 200);
    }
}
=======
class PemesananController extends Controller
{
    // Show form to create new booking
    public function create(Request $request)
    {
        $roomId = $request->query('room_id');
        $kamar = null;
        if ($roomId) {
            $kamar = Kamar::where('id', $roomId)
                ->where('status_ketersediaan', 'available')
                ->first();
        }

        if (!$kamar) {
            $kamar = Kamar::where('status_ketersediaan', 'available')->first();
        }

        if (!$kamar) {
            return redirect()->route('home')->with('error', 'Tidak ada kamar tersedia untuk dipesan.');
        }

        return view('pemesanan.create', [
            'kamar' => $kamar
        ]);
    }

    // Store new booking
    public function store(Request $request)
    {
        $rules = [
            'id_kamar' => 'required|exists:kamar,id',
            'tgl_check_in' => 'required|date|after_or_equal:today',
            'tgl_check_out' => 'required|date|after:tgl_check_in',
            'nama_pemesan' => 'required|string|max:255',
            'nik' => 'required|string|max:50',
            'nohp' => 'required|string|max:20',
            'pilihan_pembayaran' => 'required|in:cash,transfer,kartu_kredit',
            'catatan' => 'nullable|string|max:500'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kamar = Kamar::findOrFail($request->id_kamar);

        if ($kamar->status_ketersediaan != 'available') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia untuk periode yang dipilih.');
        }

        $checkIn = \Carbon\Carbon::parse($request->tgl_check_in);
        $checkOut = \Carbon\Carbon::parse($request->tgl_check_out);
        $totalMalam = $checkIn->diffInDays($checkOut);

        $hargaPerMalam = $kamar->tipe->harga_dasar ?? 0;
        $totalHarga = $hargaPerMalam * $totalMalam;

        $kodePemesanan = 'INV'.strtoupper(uniqid());

        // Create booking
        $pemesanan = new Pemesanan();
        $pemesanan->id_user = Auth::id();
        $pemesanan->id_kamar = $kamar->id;
        $pemesanan->kode_pemesanan = $kodePemesanan;
        $pemesanan->tgl_pemesanan = now();
        $pemesanan->tgl_check_in = $checkIn;
        $pemesanan->tgl_check_out = $checkOut;
        $pemesanan->total_malam = $totalMalam;
        $pemesanan->total_harga = $totalHarga;
        $pemesanan->nama_pemesan = $request->nama_pemesan;
        $pemesanan->nik = $request->nik;
        $pemesanan->nohp = $request->nohp;
        $pemesanan->pilihan_pembayaran = $request->pilihan_pembayaran;
        $pemesanan->catatan = $request->catatan;
        $pemesanan->status_pemesanan = 'pending';
        $pemesanan->payment_status = 'pending';

        // Save booking
        $pemesanan->save();

        // Set room unavailable
        $kamar->status_ketersediaan = 'booked';
        $kamar->save();

        // Generate Midtrans Snap Token if payment method is not cash
        $snapToken = null;
        if ($pemesanan->pilihan_pembayaran != 'cash') {
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $pemesanan->kode_pemesanan,
                    'gross_amount' => $pemesanan->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $pemesanan->nama_pemesan,
                    'email' => Auth::user()->email,
                    'phone' => $pemesanan->nohp,
                ],
                'enabled_payments' => ['credit_card', 'bank_transfer'],
                'vtweb' => []
            ];

            try {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Payment gateway error: ' . $e->getMessage());
            }
        }

        if ($snapToken) {
            return view('pemesanan.payment', [
                'pemesanan' => $pemesanan,
                'snapToken' => $snapToken,
            ]);
        } else {
            // For cash payment, redirect to user's bookings list
            return redirect()->route('pemesanan.my')->with('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran tunai saat check-in.');
        }
    }

    // User's bookings list
    public function myBookings()
    {
        $userId = Auth::id();
        $pemesanan = Pemesanan::where('id_user', $userId)
            ->orderBy('tgl_pemesanan', 'desc')
            ->paginate(10);

        // Get kamar IDs already reviewed by user
        $reviewedKamarIds = Review::where('id_user', $userId)->pluck('id_kamar')->toArray();

        return view('pemesanan.my', compact('pemesanan', 'reviewedKamarIds'));
    }

    // Show booking detail (method already effectively exist in routes)
    public function show(Pemesanan $pemesanan)
    {
        $this->authorize('view', $pemesanan);

        return view('pemesanan.show', compact('pemesanan'));
    }

    // Cancel booking (only if pending)
    public function cancelBooking(Pemesanan $pemesanan)
    {
        $this->authorize('cancel', $pemesanan);

        if ($pemesanan->status_pemesanan != 'pending') {
            return redirect()->back()->with('error', 'Pemesanan tidak bisa dibatalkan selain status pending.');
        }

        $pemesanan->status_pemesanan = 'cancelled';
        $pemesanan->payment_status = 'failed';
        $pemesanan->save();

        // Change room availability
        if ($pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }

        return redirect()->route('pemesanan.my')->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    // Admin update booking status
    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'status_pemesanan' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $pemesanan->status_pemesanan = $request->status_pemesanan;

        // Update payment_status accordingly
        if ($request->status_pemesanan == 'cancelled') {
            $pemesanan->payment_status = 'failed';

            // Make room available
            if ($pemesanan->kamar) {
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        } elseif ($request->status_pemesanan == 'confirmed') {
            $pemesanan->payment_status = 'paid';
        }

        $pemesanan->save();

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    /**
     * Handle Midtrans payment notification webhook callback
     */
    public function midtransNotification(Request $request)
    {
        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notif = new \Midtrans\Notification();

        // Get order_id from Midtrans notification
        $orderId = $notif->order_id ?? null;
        $transactionStatus = $notif->transaction_status ?? null;
        $fraudStatus = $notif->fraud_status ?? null;
        $paymentType = $notif->payment_type ?? null;

        if (!$orderId) {
            return response('Invalid notification', 400);
        }

        // Find the booking record
        $pemesanan = Pemesanan::where('kode_pemesanan', $orderId)->first();

        if (!$pemesanan) {
            return response('Booking not found', 404);
        }

        // Update booking status based on Midtrans transaction status
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    // Payment challenge
                    $pemesanan->payment_status = 'challenge';
                    $pemesanan->status_pemesanan = 'pending';
                } else {
                    // Payment success
                    $pemesanan->payment_status = 'paid';
                    $pemesanan->status_pemesanan = 'confirmed';
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            // Payment success
            $pemesanan->payment_status = 'paid';
            $pemesanan->status_pemesanan = 'confirmed';
        } elseif ($transactionStatus == 'pending') {
            $pemesanan->payment_status = 'pending';
            $pemesanan->status_pemesanan = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesanan->payment_status = 'failed';
            $pemesanan->status_pemesanan = 'cancelled';

            // Mark room as available again
            if ($pemesanan->kamar) {
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        }

        $pemesanan->save();

        return response('OK', 200);
    }
}
