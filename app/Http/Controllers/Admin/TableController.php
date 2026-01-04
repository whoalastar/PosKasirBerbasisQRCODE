<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TableRequest;
use App\Models\Table;
use App\Services\BarcodeService;
use Illuminate\Http\Request;
use Exception;

class TableController extends Controller
{
    protected $barcodeService;

    public function __construct(BarcodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }

    public function index(Request $request)
    {
        $query = Table::query();

        if ($request->has('search')) {
            $query->where('table_number', 'like', '%' . $request->search . '%');
        }

        $tables = $query->paginate(15);

        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(TableRequest $request)
    {
        $data = $request->validated();
        $table = Table::create($data);

        // Generate QR Code dengan error handling yang lebih baik
        try {
            $barcodePath = $this->barcodeService->generateTableBarcode($table);
            $table->update(['barcode_path' => $barcodePath]);
            $message = 'Table created successfully with QR Code';
        } catch (Exception $e) {
            \Log::warning('QR Code generation failed on table creation', [
                'table_id' => $table->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $message = 'Table created successfully, but QR Code generation failed. You can generate it later.';
        }

        return redirect()->route('admin.tables.index')->with('success', $message);
    }

    public function show(Table $table)
    {
        return view('admin.tables.show', compact('table'));
    }

    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(TableRequest $request, Table $table)
    {
        $data = $request->validated();
        $oldTableNumber = $table->table_number;
        $table->update($data);

        // If table number changed, regenerate QR Code
        if ($oldTableNumber !== $data['table_number']) {
            // Cleanup old files
            $this->barcodeService->cleanupOldQrCodes($table);

            // Generate new QR Code with error handling
            try {
                $barcodePath = $this->barcodeService->generateTableBarcode($table);
                $table->update(['barcode_path' => $barcodePath]);
            } catch (Exception $e) {
                \Log::warning('QR Code regeneration failed on table update', [
                    'table_id' => $table->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('admin.tables.index')->with('success', 'Table updated successfully');
    }

    public function destroy(Table $table)
    {
        // Cleanup all QR code files for this table
        $this->barcodeService->cleanupOldQrCodes($table);

        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Table deleted successfully');
    }

    public function generateBarcode(Table $table)
    {
        try {
            // Cleanup old files first
            $this->barcodeService->cleanupOldQrCodes($table);

            $barcodePath = null;
            $message = '';
            $method = '';

            // Method 1: Try enhanced version with GD
            if (extension_loaded('gd')) {
                try {
                    $barcodePath = $this->barcodeService->generateQrCodeWithGD($table);
                    $method = 'Enhanced (with GD)';
                } catch (Exception $e) {
                    \Log::info('GD method failed, trying basic method', [
                        'table_id' => $table->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Method 2: Try basic method if GD failed
            if (!$barcodePath) {
                try {
                    $barcodePath = $this->barcodeService->generateBasicQrCode($table);
                    $method = 'Basic PNG';
                } catch (Exception $e) {
                    \Log::info('Basic method failed, using fallback', [
                        'table_id' => $table->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Method 3: Final fallback
            if (!$barcodePath) {
                $barcodePath = $this->barcodeService->generateTableBarcode($table);
                $method = 'Fallback';
            }

            if ($barcodePath && $this->verifyQrCodeFile($barcodePath)) {
                $table->update(['barcode_path' => $barcodePath]);
                $message = "QR Code generated successfully ({$method})";
                
                // Log success for debugging
                \Log::info('QR Code generated successfully', [
                    'table_id' => $table->id,
                    'method' => $method,
                    'path' => $barcodePath,
                    'file_size' => filesize(public_path($barcodePath))
                ]);

                return redirect()->back()->with('success', $message);
            } else {
                throw new Exception('All QR generation methods failed or produced invalid files');
            }

        } catch (Exception $e) {
            \Log::error('QR Code generation completely failed', [
                'table_id' => $table->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to generate QR Code. Error: ' . $e->getMessage());
        }
    }

    /**
     * Regenerate all QR codes with different methods
     */
    public function regenerateAllBarcodes(Request $request)
    {
        $method = $request->input('method', 'basic'); // basic, gd, or fallback
        $tables = Table::all();
        $success = 0;
        $failed = 0;

        foreach ($tables as $table) {
            try {
                // Cleanup old files
                $this->barcodeService->cleanupOldQrCodes($table);

                $barcodePath = null;
                
                switch ($method) {
                    case 'gd':
                        if (extension_loaded('gd')) {
                            $barcodePath = $this->barcodeService->generateQrCodeWithGD($table);
                        } else {
                            $barcodePath = $this->barcodeService->generateBasicQrCode($table);
                        }
                        break;
                    case 'fallback':
                        $barcodePath = $this->barcodeService->generateTableBarcode($table);
                        break;
                    default:
                        $barcodePath = $this->barcodeService->generateBasicQrCode($table);
                }

                if ($barcodePath && $this->verifyQrCodeFile($barcodePath)) {
                    $table->update(['barcode_path' => $barcodePath]);
                    $success++;
                } else {
                    $failed++;
                }

            } catch (Exception $e) {
                \Log::warning('Failed to regenerate QR for table', [
                    'table_id' => $table->id,
                    'error' => $e->getMessage()
                ]);
                $failed++;
            }
        }

        $message = "Regeneration complete: {$success} succeeded, {$failed} failed";
        return redirect()->back()->with('success', $message);
    }

    /**
     * Generate QR Code with logo
     */
    public function generateBarcodeWithLogo(Table $table, Request $request)
    {
        try {
            // Cleanup old files
            $this->barcodeService->cleanupOldQrCodes($table);

            $barcodePath = $this->barcodeService->generateQrCodeWithLogo($table);
            
            if ($barcodePath && $this->verifyQrCodeFile($barcodePath)) {
                $table->update(['barcode_path' => $barcodePath]);
                return redirect()->back()->with('success', 'Enhanced QR Code generated successfully');
            } else {
                throw new Exception('QR generation failed');
            }

        } catch (Exception $e) {
            \Log::error('QR Code with logo generation failed', [
                'table_id' => $table->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Failed to generate enhanced QR Code: ' . $e->getMessage());
        }
    }

    /**
     * Download QR Code
     */
    public function downloadBarcode(Table $table)
    {
        if (!$table->barcode_path || !file_exists(public_path($table->barcode_path))) {
            return redirect()->back()->with('error', 'QR Code not found. Please generate it first.');
        }

        // Verify file is readable
        if (!$this->verifyQrCodeFile($table->barcode_path)) {
            return redirect()->back()->with('error', 'QR Code file is corrupted. Please regenerate it.');
        }

        $filename = "table_{$table->table_number}_qrcode." . pathinfo($table->barcode_path, PATHINFO_EXTENSION);
        return response()->download(public_path($table->barcode_path), $filename);
    }

    /**
     * Debug QR Code generation
     */
    public function debugBarcode(Table $table)
    {
        $debug = [];
        
        // Check GD extension
        $debug['gd_loaded'] = extension_loaded('gd');
        if ($debug['gd_loaded']) {
            $debug['gd_info'] = gd_info();
        }

        // Check current QR file
        if ($table->barcode_path) {
            $fullPath = public_path($table->barcode_path);
            $debug['current_file'] = [
                'path' => $table->barcode_path,
                'exists' => file_exists($fullPath),
                'size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                'is_readable' => file_exists($fullPath) ? is_readable($fullPath) : false,
            ];

            if (file_exists($fullPath)) {
                $debug['file_type'] = mime_content_type($fullPath);
                $debug['first_bytes'] = bin2hex(substr(file_get_contents($fullPath), 0, 16));
            }
        }

        // Test QR generation methods
        try {
            $testPath = $this->barcodeService->generateBasicQrCode($table);
            $debug['basic_test'] = [
                'success' => true,
                'path' => $testPath,
                'verified' => $this->verifyQrCodeFile($testPath)
            ];
        } catch (Exception $e) {
            $debug['basic_test'] = [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($debug);
    }

    /**
     * Helper method to verify QR code file
     */
    private function verifyQrCodeFile(string $barcodePath): bool
    {
        $fullPath = public_path($barcodePath);
        
        if (!file_exists($fullPath) || filesize($fullPath) === 0) {
            return false;
        }

        // Check if it's a valid image file
        $mimeType = mime_content_type($fullPath);
        return in_array($mimeType, ['image/png', 'image/svg+xml']);
    }
}