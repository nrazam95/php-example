<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Storage
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->path ? "public/{$request->path}" : 'public/files';
        // going thru tree of folders
        $files = $this->getFiles($path);

        return view('file-managers.index', ['root_folders' => $files]);
    }

    // Recursive functions to get all files and folders
    public function getFiles($path)
    {
        $files = collect(Storage::files($path))->map(function ($file) use ($path) {
            return [
                'name' => basename($file),
                'path' => $file,
                'type' => 'file',
                'url' => str_replace('/storage', '', Storage::url($file)),
            ];
        });

        $folders = collect(Storage::directories($path))->map(function ($directory) use ($path) {
            return [
                'name' => basename($directory),
                'path' => $directory,
                'type' => 'folder',
                'url' => str_replace('/storage', '', Storage::url($directory)),
                'items' => $this->getFiles($directory),
            ];
        });

        return $files->merge($folders);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:1024',
        ]);

        $file = $request->file('file');
        $file->store('public/files');

        return response()->json([
            'message' => 'File uploaded successfully',
        ]);
    }

    public function files(Request $request)
    {
        $path = $request->path ? "public/{$request->path}" : 'public/files';
        $files = collect(Storage::files($path))->map(function ($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'type' => 'file',
                'url' => str_replace('/storage', '', Storage::url($file)),
            ];
        });

        $folders = collect(Storage::directories('public/files'))->map(function ($directory) {
            return [
                'name' => basename($directory),
                'path' => $directory,
                'type' => 'folder',
                'url' => str_replace('/storage', '', Storage::url($directory)),
            ];
        });

        $files = $files->merge($folders);

        return response()->json($files);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        Storage::delete('public/files/' . $request->file);

        return response()->json([
            'message' => 'File deleted successfully',
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        return Storage::download('public/files/' . $request->file);
    }

    public function rename(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'name' => 'required',
        ]);

        Storage::move('public/files/' . $request->file, 'public/files/' . $request->name);

        return response()->json([
            'message' => 'File renamed successfully',
        ]);
    }

    public function move(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'folder' => 'required',
        ]);

        Storage::move('public/files/' . $request->file, 'public/files/' . $request->folder . '/' . $request->file);

        return response()->json([
            'message' => 'File moved successfully',
        ]);
    }
}
