<?php

namespace App\Http\Livewire\Documents\Settings;

use App\Models\Documents\Settings\DmFolder;
use Livewire\Component;
use Livewire\WithPagination;

class DmFoldersComponent extends Component
{
    
    use WithPagination;
        
    //Filters
    public $from_date;

    public $to_date;

    public $folderIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $parent_id;

    public $is_active =1;

    public $description;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|integer',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);
    }

    public function storeDocFolder()
    {
        $this->validate([
            'name' => 'required|string|unique:dm_folders',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',

        ]);
        // dd($this->parent_id);
        $folder = new DmFolder();
        $folder->name = $this->name;
        $folder->is_active = $this->is_active;
        $folder->code = time();
        if($this->parent_id !=""){            
        $folder->parent_id = $this->parent_id;
        }
        $folder->description = $this->description;
        $folder->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'folder created successfully!']);
    }

    public function editData(DmFolder $folder)
    {
        $this->edit_id = $folder->id;
        $this->name = $folder->name;
        $this->is_active = $folder->is_active;
        $this->parent_id = $folder->parent_id;
        $this->description = $folder->description;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active', 'description']);
    }

    public function updateDocFolder()
    {
        $this->validate([
            'name' => 'required|unique:dm_folders,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);

        $folder = DmFolder::find($this->edit_id);
        $folder->name = $this->name;
        $folder->is_active = $this->is_active;
        $folder->parent_id = $this->parent_id;
        $folder->description = $this->description;
        $folder->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'folder updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->folderIds) > 0) {
            // return (new foldersExport($this->folderIds))->download('folders_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No folders selected for export!',
            ]);
        }
    }

    public function filterFolders()
    {
        $folders = DmFolder::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->folderIds = $folders->pluck('id')->toArray();

        return $folders;
    }

    public function render()
    {
        $data['folders'] = $this->filterFolders()->with('parent')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.documents.settings.dm-folders-component', $data);
    }
}
