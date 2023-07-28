<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Writer;
use Livewire\Component;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\Activitylog\Models\Activity;
use ZipArchive;

class UserActivityComponent extends Component
{
    public $causer = 0;

    public $event = 0;

    public $subject = 0;

    public $from_date = '';

    public $to_date = '';

    public $checkroute = false;

    public $users;

    public $loading = true;

    public function mount()
    {
        $this->users = User::where(['is_active' => 1])->get();
    }

    public function filterLogs()
    {
        $this->loading = true;
        $logs = Activity::select('*')->whereNotNull('causer_id')->with('causer')
            ->when($this->causer != 0, function ($query) {
                $query->where('causer_id', $this->causer);
            }, function ($query) {
                return $query;
            })
            ->when($this->event != 0, function ($query) {
                $query->where('event', $this->event);
            }, function ($query) {
                return $query;
            })
            ->when($this->subject != 0, function ($query) {
                $query->where('log_name', $this->subject);
            }, function ($query) {
                return $query;
            })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })
            ->latest()->get()->take(1000);
        $this->loading = false;

        return $logs;
    }

    // public function cleanLogs()
    // {
    //     try {
    //         Artisan::call('activitylog:clean');
    //         $this->dispatchBrowserEvent('close-modal');
    //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Logs deleted successfully!']);
    //     } catch(Exception $error) {
    //         $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Something went wrong! Logs could not be cleared!']);
    //     }
    // }

    public function dumpAndClearTable($months, $clear = false)
    {
        // Specify the table you want to dump and clear
        $tableName = 'activity_log';

        // Get the current date and time
        $currentDate = now();

        // Calculate the date months ago
        $monthsAgo = $currentDate->subMonths($months);

        // Generate a backup of the table data
        $backupData = DB::table($tableName)->where('created_at', '<=', $monthsAgo)->get();

        if (! $backupData->isEmpty()) {

            // Convert the collection of objects to an array of arrays
            $backupDataArray = $backupData->map(function ($item) {
                return (array) $item;
            })->toArray();

            $folderPath = storage_path('app/UserActivityBackup/');

            if (! File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // Export the data as a CSV file
            $fileName = date('YmdHis').'Backup'.'.csv';
            $csvWriter = Writer::createFromPath($folderPath.$fileName, 'w+');
            $csvWriter->insertOne(array_keys($backupDataArray[0]));
            $csvWriter->insertAll($backupDataArray);

            // Clear the table by deleting all records
            if ($clear) {
                DB::table($tableName)->where('created_at', '<=', $monthsAgo)->delete();
            }

            // Download the CSV file
            $backupFilePath = $folderPath.$fileName;
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="backup.csv"',
            ];

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Logs dumped successfully!']);

            return response()->download($backupFilePath, $fileName, $headers);
        } else {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Not found!',
                'text' => 'There are no activity logs to backup/clear',
            ]);
        }

    }

    public function downloadBackupFolderAsZip()
    {
        $zip = new ZipArchive;
        $zipFileName = storage_path('app/User_Activity_'.date('YmdHis').'.zip');

        try {
            if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                // Add files from the 'app/UserActivityBackup' folder to the zip archive
                $backupFolderPath = storage_path('app/UserActivityBackup');
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($backupFolderPath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (! $file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($backupFolderPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();
            }

            return response()->download($zipFileName)->deleteFileAfterSend();

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Something went wrong',
                'text' => 'The download could not be completed/performed. Please try again',
            ]);
        }
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    // public function deleteConfirmation()
    // {
    //     $this->dispatchBrowserEvent('delete-modal');
    // }

    // public function cancel()
    // {
    //     $this->dispatchBrowserEvent('close-modal');
    // }

    public function render()
    {
        $logs = $this->filterLogs();
        $log_names = Activity::select('log_name')->distinct()->get();
        $events = Activity::select('event')->distinct()->get();

        return view('livewire.user-management.user-activity-component', compact('logs', 'log_names', 'events'))->layout('layouts.app');
    }
}
