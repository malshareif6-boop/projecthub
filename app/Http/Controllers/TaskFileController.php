<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskFileRequest;
use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskFileController extends Controller
{
    public function store(StoreTaskFileRequest $request, Task $task)
    {
        $this->authorize('create', [TaskFile::class, $task]);

        $file = $request->file('file');

        $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'tasks/' . $task->id,
            $storedName,
            'local'
        );

        TaskFile::create([
            'task_id'       => $task->id,
            'uploaded_by'   => $request->user()->id,
            'original_name' => $file->getClientOriginalName(),
            'stored_path'   => $path,
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded to task successfully.');
    }

    public function download(TaskFile $file)
    {
        $this->authorize('view', $file);

        return Storage::disk('local')->download(
            $file->stored_path,
            $file->original_name
        );
    }

    public function destroy(TaskFile $file)
    {
        $this->authorize('delete', $file);

        Storage::disk('local')->delete($file->stored_path);
        $file->delete();

        return back()->with('success', 'Task file deleted successfully.');
    }
}
