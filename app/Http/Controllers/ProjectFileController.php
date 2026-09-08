<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectFileRequest;
use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectFileController extends Controller
{
    public function store(StoreProjectFileRequest $request, Project $project)
    {
        $file = $request->file('file');

        $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'projects/' . $project->id,
            $storedName,
            'local'
        );

        ProjectFile::create([
            'project_id'    => $project->id,
            'uploaded_by'   => $request->user()->id,
            'original_name' => $file->getClientOriginalName(),
            'stored_path'   => $path,
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function download(ProjectFile $file)
    {
        $this->authorize('view', $file);

        return Storage::disk('local')->download(
            $file->stored_path,
            $file->original_name
        );
    }

    public function destroy(ProjectFile $file)
    {
        $this->authorize('delete', $file);

        // Delete from storage
        Storage::disk('local')->delete($file->stored_path);

        // Delete from database
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
