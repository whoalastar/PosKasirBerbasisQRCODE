<?php

namespace App\Services;

use App\Models\Table;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Exception;

class BarcodeService
{
    /**
     * Generate QR Code untuk table dengan fallback yang lebih baik
     */
    public function generateTableBarcode(Table $table): string
    {
        // Buat folder qrcodes jika belum ada
        $qrcodeDir = public_path('storage/qrcodes');
        if (!is_dir($qrcodeDir)) {
            mkdir($qrcodeDir, 0755, true);
        }

        // Data QR Code (URL untuk scan table)
        $qrData = url("/scan/{$table->table_number}");

        try {
            // Method 1: Coba PNG dengan binary mode
            return $this->generatePngQrCode($table, $qrData);
        } catch (Exception $e) {
            try {
                // Method 2: Coba dengan base64 decode
                return $this->generateBase64QrCode($table, $qrData);
            } catch (Exception $e2) {
                // Method 3: Fallback ke SVG
                return $this->generateSvgQrCode($table, $qrData);
            }
        }
    }

    /**
     * Generate PNG QR Code dengan binary mode
     */
    private function generatePngQrCode(Table $table, string $qrData): string
    {
        // Generate QR code sebagai binary PNG
        $qrCodeBinary = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->errorCorrection('M')
            ->generate($qrData);

        // Simpan sebagai binary
        $filename = "table_{$table->table_number}_qrcode.png";
        $filepath = "storage/qrcodes/{$filename}";
        $fullPath = public_path($filepath);

        // Pastikan data adalah binary PNG
        if (is_string($qrCodeBinary)) {
            file_put_contents($fullPath, $qrCodeBinary);
            
            // Verifikasi file adalah PNG yang valid
            if ($this->isPngFile($fullPath)) {
                return $filepath;
            }
        }
        
        throw new Exception('Failed to generate valid PNG');
    }

    /**
     * Generate QR Code dengan base64 decode approach
     */
    private function generateBase64QrCode(Table $table, string $qrData): string
    {
        try {
            // Generate dengan method yang berbeda
            $qrCode = QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->backgroundColor(255, 255, 255)
                ->color(0, 0, 0)
                ->generate($qrData);

            $filename = "table_{$table->table_number}_qrcode.png";
            $filepath = "storage/qrcodes/{$filename}";
            $fullPath = public_path($filepath);

            // Jika hasil adalah base64, decode dulu
            if (strpos($qrCode, 'data:image/png;base64,') === 0) {
                $qrCode = base64_decode(substr($qrCode, 22));
            }

            file_put_contents($fullPath, $qrCode);

            // Verifikasi file
            if ($this->isPngFile($fullPath)) {
                return $filepath;
            }

            throw new Exception('Invalid PNG generated');

        } catch (Exception $e) {
            throw new Exception('Base64 method failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate SVG QR Code sebagai fallback terakhir
     */
    private function generateSvgQrCode(Table $table, string $qrData): string
    {
        $qrCodeSvg = QrCode::size(300)
            ->margin(2)
            ->generate($qrData);

        $filename = "table_{$table->table_number}_qrcode.svg";
        $filepath = "storage/qrcodes/{$filename}";
        $fullPath = public_path($filepath);

        file_put_contents($fullPath, $qrCodeSvg);

        return $filepath;
    }

    /**
     * Generate QR Code sederhana tanpa styling khusus
     */
    public function generateBasicQrCode(Table $table): string
    {
        $qrcodeDir = public_path('storage/qrcodes');
        if (!is_dir($qrcodeDir)) {
            mkdir($qrcodeDir, 0755, true);
        }

        $qrData = url("/scan/{$table->table_number}");

        try {
            // Coba method paling sederhana untuk PNG
            $qrCode = QrCode::format('png')->size(250)->generate($qrData);
            
            $filename = "table_{$table->table_number}_qrcode.png";
            $filepath = "storage/qrcodes/{$filename}";
            $fullPath = public_path($filepath);

            file_put_contents($fullPath, $qrCode);

            // Cek apakah file valid
            if (file_exists($fullPath) && filesize($fullPath) > 0) {
                return $filepath;
            }

            throw new Exception('PNG generation failed');

        } catch (Exception $e) {
            // Fallback ke SVG
            $qrCode = QrCode::generate($qrData);
            
            $filename = "table_{$table->table_number}_qrcode.svg";
            $filepath = "storage/qrcodes/{$filename}";
            $fullPath = public_path($filepath);

            file_put_contents($fullPath, $qrCode);
            return $filepath;
        }
    }

    /**
     * Generate QR Code dengan GD jika tersedia
     */
    public function generateQrCodeWithGD(Table $table): string
    {
        if (!extension_loaded('gd')) {
            return $this->generateBasicQrCode($table);
        }

        $qrcodeDir = public_path('storage/qrcodes');
        if (!is_dir($qrcodeDir)) {
            mkdir($qrcodeDir, 0755, true);
        }

        $qrData = url("/scan/{$table->table_number}");

        try {
            // Step 1: Generate QR code
            $qrCodeData = QrCode::format('png')
                ->size(250)
                ->margin(1)
                ->generate($qrData);

            // Step 2: Create temp file for QR
            $tempFile = tempnam(sys_get_temp_dir(), 'qr_temp_');
            file_put_contents($tempFile, $qrCodeData);

            // Step 3: Verify and process with GD
            if ($this->isPngFile($tempFile)) {
                $result = $this->processQrWithGD($table, $tempFile);
                unlink($tempFile);
                return $result;
            } else {
                unlink($tempFile);
                throw new Exception('Generated QR is not valid PNG');
            }

        } catch (Exception $e) {
            return $this->generateBasicQrCode($table);
        }
    }

    /**
     * Process QR code dengan GD untuk menambah informasi
     */
    private function processQrWithGD(Table $table, string $tempQrFile): string
    {
        $qrImage = imagecreatefrompng($tempQrFile);
        if (!$qrImage) {
            throw new Exception('Cannot load QR image with GD');
        }

        // Create canvas
        $canvasWidth = 300;
        $canvasHeight = 320;
        $canvas = imagecreatetruecolor($canvasWidth, $canvasHeight);

        // Colors
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $black = imagecolorallocate($canvas, 0, 0, 0);
        $gray = imagecolorallocate($canvas, 100, 100, 100);

        // Fill background
        imagefill($canvas, 0, 0, $white);

        // Copy QR code
        $qrSize = 250;
        $qrX = ($canvasWidth - $qrSize) / 2;
        $qrY = 10;
        imagecopyresampled($canvas, $qrImage, $qrX, $qrY, 0, 0, $qrSize, $qrSize, imagesx($qrImage), imagesy($qrImage));

        // Add text
        $tableText = "Table: " . $table->table_number;
        $capacityText = "Capacity: " . $table->capacity . " people";
        $scanText = "Scan to order";

        $textY = 275;
        imagestring($canvas, 4, 50, $textY, $tableText, $black);
        imagestring($canvas, 3, 40, $textY + 20, $capacityText, $gray);
        imagestring($canvas, 2, 80, $textY + 40, $scanText, $gray);

        // Save
        $filename = "table_{$table->table_number}_qrcode_enhanced.png";
        $filepath = "storage/qrcodes/{$filename}";
        $fullPath = public_path($filepath);

        $success = imagepng($canvas, $fullPath, 9);

        // Cleanup
        imagedestroy($qrImage);
        imagedestroy($canvas);

        if ($success) {
            return $filepath;
        } else {
            throw new Exception('Failed to save enhanced QR code');
        }
    }

    /**
     * Generate QR Code sederhana dengan format PNG
     */
    public function generateSimpleQrCode(Table $table): string
    {
        return $this->generateBasicQrCode($table);
    }

    /**
     * Generate QR Code dengan logo (placeholder)
     */
    public function generateQrCodeWithLogo(Table $table, string $logoPath = null): string
    {
        return $this->generateQrCodeWithGD($table);
    }

    /**
     * Generate QR Code dengan informasi table yang lengkap
     */
    public function generateTableQrCodeWithInfo(Table $table): string
    {
        return $this->generateQrCodeWithGD($table);
    }

    /**
     * Helper method to check if file is valid PNG
     */
    private function isPngFile(string $filePath): bool
    {
        if (!file_exists($filePath) || filesize($filePath) < 8) {
            return false;
        }

        $handle = fopen($filePath, 'rb');
        if (!$handle) {
            return false;
        }

        $header = fread($handle, 8);
        fclose($handle);

        // PNG signature: 89 50 4E 47 0D 0A 1A 0A
        return $header === "\x89PNG\r\n\x1a\n";
    }

    /**
     * Clean up old QR code files
     */
    public function cleanupOldQrCodes(Table $table): void
    {
        $qrcodeDir = public_path('storage/qrcodes');
        $pattern = "table_{$table->table_number}_qrcode*";
        
        $files = glob($qrcodeDir . '/' . $pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}