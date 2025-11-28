public function show(Kamar $kamar)
    {
        return view('member.kamar.show', compact('kamar'));
    }
=======
    // Show kamar list with reviews
    public function index()
    {
        $kamar = Kamar::with(['tipe', 'reviews'])->get()->map(function ($kamar) {
            $kamar->average_rating = $kamar->reviews->avg('rating') ?? 0;
            $kamar->review_count = $kamar->reviews->count();
            return $kamar;
        });

        return view('member.kamar.index', compact('kamar'));
    }

    // Show kamar detail
    public function show(Kamar $kamar)
    {
        $kamar->load(['tipe', 'reviews.user']);
        return view('member.kamar.show', compact('kamar'));
    }
