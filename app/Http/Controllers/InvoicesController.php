<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class InvoiceController extends Controller
{
    /**
     * Store invoice from booking
     */
    public function storeFromBooking($bookingId)
    {
        try {
            Log::info('🔥 START - Creating invoice', ['booking_id' => $bookingId]);
            
            // Ambil data booking
            $booking = Booking::find($bookingId);
            
            if (!$booking) {
                Log::error('❌ Booking not found', ['booking_id' => $bookingId]);
                return null;
            }

            Log::info('✅ Booking found', [
                'booking_id' => $bookingId,
                'booking_data' => $booking->toArray()
            ]);

            // Cek apakah invoice sudah ada
            $existingInvoice = Invoice::where('id_booking', $bookingId)->first();
            
            if ($existingInvoice) {
                Log::info('⚠️ Invoice sudah ada untuk booking ini', [
                    'booking_id' => $bookingId,
                    'invoice_id' => $existingInvoice->id_invoices
                ]);
                return $existingInvoice;
            }

            // Siapkan data untuk invoice - GUNAKAN DB::table jika mass assignment bermasalah
            $invoiceId = DB::table('invoices')->insertGetId([
                'id_booking' => $booking->id_booking,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $invoice = Invoice::find($invoiceId);

            Log::info('✅ Invoice berhasil disimpan via DB::table', [
                'invoice_id' => $invoiceId,
                'booking_id' => $bookingId,
                'booking_harga' => $booking->harga
            ]);

            return $invoice;

        } catch (Exception $e) {
            Log::error('❌ Error storing invoice: ' . $e->getMessage(), [
                'booking_id' => $bookingId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Update invoice dari booking (update tanggal)
     */
    public function updateFromBooking($bookingId)
    {
        try {
            Log::info('🔄 START - Updating invoice', ['booking_id' => $bookingId]);
            
            $booking = Booking::find($bookingId);
            
            if (!$booking) {
                Log::error('❌ Booking not found for update', ['booking_id' => $bookingId]);
                return null;
            }

            $invoice = Invoice::where('id_booking', $bookingId)->first();

            if (!$invoice) {
                // Jika invoice belum ada, buat baru
                Log::info('⚠️ Invoice not found, creating new one');
                return $this->storeFromBooking($bookingId);
            }

            // Update tanggal invoice
            DB::table('invoices')
                ->where('id_invoices', $invoice->id_invoices)
                ->update([
                    'tanggal' => now(),
                    'updated_at' => now()
                ]);

            Log::info('✅ Invoice berhasil diupdate', [
                'invoice_id' => $invoice->id_invoices,
                'booking_id' => $bookingId
            ]);

            return Invoice::find($invoice->id_invoices);

        } catch (Exception $e) {
            Log::error('❌ Error updating invoice: ' . $e->getMessage(), [
                'booking_id' => $bookingId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Get all invoices
     */
    public function index()
    {
        try {
            $invoices = Invoice::with('booking')
                ->orderBy('tanggal', 'desc')
                ->paginate(15);

            return view('admin.invoices.index', compact('invoices'));

        } catch (Exception $e) {
            Log::error('Error getting invoices: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat invoices');
        }
    }

    /**
     * Show detail invoice
     */
    public function show($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $booking = $invoice->booking;

            return view('admin.invoices.show', compact('invoice', 'booking'));

        } catch (Exception $e) {
            Log::error('Error showing invoice: ' . $e->getMessage());
            return back()->with('error', 'Invoice tidak ditemukan');
        }
    }

    /**
     * Delete invoice
     */
    public function destroy($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();

            Log::info('Invoice berhasil dihapus', [
                'invoice_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dihapus'
            ]);

        } catch (Exception $e) {
            Log::error('Error deleting invoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus invoice'
            ], 500);
        }
    }
}