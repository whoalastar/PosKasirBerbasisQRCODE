<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Exception;

class TestQrCode extends Command
{
    protected $signature = 'test:qrcode';
    protected $description = 'Test QR Code generation functionality';

    public function handle()
    {
        $this->info('Testing QR Code generation...');
        
        // Test 1: Check if QR Code library is available
        $this->info('1. Checking QR Code library...');
        if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
            $this->info('✅ QR Code library is available');
        } else {
            $this->error('❌ QR Code library is NOT available');
            return;
        }

        // Test 2: Check GD extension
        $this->info('2. Checking GD extension...');
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
            $this->info('✅ GD extension is loaded');
            $this->info('   - GD Version: ' . $gdInfo['GD Version']);
            $this->info('   - PNG Support: ' . ($gdInfo['PNG Support'] ? 'Yes' : 'No'));
        } else {
            $this->error('❌ GD extension is NOT loaded');
        }

        // Test 3: Check directory permissions
        $this->info('3. Checking directory permissions...');
        $qrcodeDir = public_path('storage/qrcodes');
        if (!is_dir($qrcodeDir)) {
            mkdir($qrcodeDir, 0755, true);
            $this->info('✅ Created QR codes directory');
        }
        
        if (is_writable($qrcodeDir)) {
            $this->info('✅ QR codes directory is writable');
        } else {
            $this->error('❌ QR codes directory is NOT writable');
            $this->error('   Path: ' . $qrcodeDir);
        }

        // Test 4: Generate test QR code
        $this->info('4. Testing QR code generation...');
        try {
            // Test basic generation
            $testData = 'https://example.com/test';
            $qrCode = QrCode::generate($testData);
            $this->info('✅ Basic QR code generation works');

            // Test PNG generation
            try {
                $pngQrCode = QrCode::format('png')->size(200)->generate($testData);
                $testFile = $qrcodeDir . '/test_qr.png';
                file_put_contents($testFile, $pngQrCode);
                
                if (file_exists($testFile)) {
                    $filesize = filesize($testFile);
                    $this->info('✅ PNG QR code generation works');
                    $this->info('   File size: ' . number_format($filesize) . ' bytes');
                    
                    // Clean up test file
                    unlink($testFile);
                } else {
                    $this->error('❌ PNG QR code file was not created');
                }
            } catch (Exception $e) {
                $this->error('❌ PNG QR code generation failed: ' . $e->getMessage());
            }

            // Test SVG generation as fallback
            try {
                $svgQrCode = QrCode::format('svg')->size(200)->generate($testData);
                $this->info('✅ SVG QR code generation works (fallback available)');
            } catch (Exception $e) {
                $this->warn('⚠️ SVG QR code generation failed: ' . $e->getMessage());
            }

        } catch (Exception $e) {
            $this->error('❌ QR code generation completely failed');
            $this->error('Error: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
        }

        // Test 5: Check storage link
        $this->info('5. Checking storage link...');
        $storageLink = public_path('storage');
        if (is_link($storageLink)) {
            $this->info('✅ Storage link exists');
        } else {
            $this->warn('⚠️ Storage link does not exist. Run: php artisan storage:link');
        }

        $this->info('QR Code test completed!');
    }
}