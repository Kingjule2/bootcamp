<?php

namespace App\Http\Controllers;

use App\Models\LaporanSekolah;
use App\Models\Pengiriman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfflineSyncController extends Controller
{
    public function syncOffline(Request $request)
    {
        $data = $request->validate([
            'deliveries' => 'required|array',
            'deliveries.*.pengiriman_id' => 'required|integer',
        ]);

        $deliveries = $data['deliveries'];
        
        DB::beginTransaction();
        try {
            foreach ($deliveries as $item) {
                $pengirimanId = $item['pengiriman_id'];
                $pengiriman = Pengiriman::find($pengirimanId);
                if (!$pengiriman) continue;

                // 1. Receipt confirmation
                if (isset($item['status_logistik']) && $item['status_logistik'] === 'Diterima') {
                    $receivedAt = isset($item['received_at']) ? Carbon::parse($item['received_at']) : now();
                    $pengiriman->update([
                        'status_logistik' => 'Diterima',
                        'received_at' => $receivedAt,
                        'is_synced' => false, // Marked false since recorded offline
                        'device_info' => $item['device_info'] ?? request()->userAgent(),
                    ]);
                }

                // 2. Quality report submission
                if (isset($item['type']) && $item['type'] === 'report') {
                    // Make sure it doesn't already have a report
                    $existingReport = LaporanSekolah::where('pengiriman_id', $pengirimanId)->first();
                    if (!$existingReport) {
                        LaporanSekolah::create([
                            'pengiriman_id' => $pengirimanId,
                            'porsi_diterima' => $item['porsi_diterima'],
                            'food_waste' => $item['food_waste'] ?? 0,
                            'rating' => $item['rating'],
                            'komentar' => $item['komentar'] ?? null,
                        ]);
                        
                        // Mark the dispatch itself as unsynced
                        $pengiriman->update([
                            'is_synced' => false
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
