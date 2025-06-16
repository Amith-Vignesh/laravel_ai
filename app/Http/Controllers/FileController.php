<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FileController extends Controller
{

    private function token()
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => config('services.google.refresh_token'),
            'grant_type' => 'refresh_token',
        ]);

        return json_decode((string)$response->getBody(), true)['access_token'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all();
        return view('file-upload', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        $accessToken = $this->token();

        $name = $request->file->getClientOriginalName();
        $path = $request->file->getRealPath();


        $response = Http::withToken($accessToken)
            ->attach('metadata', json_encode([
                'name' => $name,
                'parents' => [config('services.google.folder_id')],
            ]), 'metadata.json')
            ->attach('file', file_get_contents($path), $name)
            ->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');



        if ($response->successful()) {

            $uploadedFile = new File();
            $uploadedFile->file_name = $name;
            $uploadedFile->file_id = json_decode($response->body())->id;
            $uploadedFile->save();

            return redirect()->back()->with('success', 'File uploaded successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to upload the file.');
        }
    }

    public function download($fileId)
    {
        $accessToken = $this->token();

        $response = Http::withToken($accessToken)
            ->get("https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media");

        if ($response->successful()) {
            $file = File::where('file_id', $fileId)->first();

            session()->flash('success', 'File downloaded successfully!');

            return response($response->body(), 200)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $file->file_name . '"');
        }

        return redirect()->back()->with('error', 'Failed to download the file.');
    }

    /**
     * Destory a file on Google Drive and remove its record from the database
     *
     * @param string $fileId The ID of the file to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($fileId)
    {
        $accessToken = $this->token();

        // Delete the file from Google Drive
        $response = Http::withToken($accessToken)
            ->delete("https://www.googleapis.com/drive/v3/files/{$fileId}");

        if ($response->successful()) {
            // Delete the file record from the database
            $file = File::where('file_id', $fileId)->first();
            if ($file) {
                $file->delete();
            }
            return redirect()->back()->with('success', 'File deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete the file.');
        }
    }
}
