<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // 1. READ ALL (GET /api/rentals) - Status 200
    public function index()
    {
        $rentals = Rental::with(['customer', 'computer'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $rentals
        ], 200);
    }

    // 2. CREATE (POST /api/rentals) - Status 201
    public function store(Request $request)
    {
        // Validasi ketat sesuai materi P10
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'computer_id' => 'required|exists:computers,id',
            'start_time'  => 'required|date',
            'end_time'    => 'nullable|date|after:start_time', // end_time opsional, tapi jika diisi harus setelah start_time
            'total_price' => 'nullable|numeric|min:0',
        ]);

        $rental = Rental::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dibuat',
            'data' => $rental
        ], 201); // 201 Created
    }

    // 3. READ ONE (GET /api/rentals/{id}) - Status 200 / 404
    public function show($id)
    {
        // findOrFail otomatis mengembalikan error 404 jika ID tidak ada
        $rental = Rental::with(['customer', 'computer'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $rental
        ], 200);
    }

    // 4. UPDATE (PUT /api/rentals/{id}) - Status 200
    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        // 'sometimes' berarti validasi hanya jalan jika field tersebut dikirim
        $data = $request->validate([
            'end_time'    => 'sometimes|required|date',
            'total_price' => 'sometimes|required|numeric|min:0',
        ]);

        $rental->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil diupdate',
            'data' => $rental
        ], 200);
    }

    // 5. DELETE (DELETE /api/rentals/{id}) - Status 204
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();

        // 204 No Content (berhasil dihapus, tidak ada response body)
        return response()->noContent();
    }
}
