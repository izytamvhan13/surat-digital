<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleDriveService
{
    protected $client;
    protected $service;
    protected $folderId = '1oQK2D_OFWpyrFkCWazWcOxmAi7YKNzF3';

    public function __construct()
    {
        try {
            $this->client = new Client();
            $credentialsPath = storage_path('credentials/suratdigital-b96e91c9e1fc.json');

            if (!file_exists($credentialsPath)) {
                Log::error("❌ File credentials tidak ditemukan: " . $credentialsPath);
                return;
            }

            $this->client->setAuthConfig($credentialsPath);
            $this->client->addScope(Drive::DRIVE);
            $this->service = new Drive($this->client);
        } catch (Exception $e) {
            Log::error("❌ Gagal inisialisasi GoogleDriveService: " . $e->getMessage());
            $this->service = null;
        }
    }

    public function uploadFile($localPath, $fileName)
    {
        if (!$this->service) {
            Log::warning("⚠️ Google Drive belum siap, file tidak diupload.");
            return null;
        }

        if (!file_exists($localPath)) {
            Log::error("❌ File lokal tidak ditemukan: " . $localPath);
            return null;
        }

        try {
            $mimeType = mime_content_type($localPath);

            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$this->folderId],
            ]);

            $file = $this->service->files->create($fileMetadata, [
                'data' => file_get_contents($localPath),
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink',
            ]);

            // buat publik
            $this->service->permissions->create($file->id, new Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]));

            Log::info("✅ File berhasil diupload ke Google Drive", [
                'fileId' => $file->id,
                'link' => $file->webViewLink,
            ]);

            return $file->webViewLink;
        } catch (Exception $e) {
            Log::error("❌ Gagal upload ke Google Drive: " . $e->getMessage());
            return null;
        }
    }
}
