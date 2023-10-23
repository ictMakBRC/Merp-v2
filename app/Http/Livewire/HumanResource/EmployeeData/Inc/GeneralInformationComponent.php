<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use App\Data\HumanResource\EmployeeData\GeneralEmployeeData;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\Settings\Station;
use App\Services\HumanResource\EmployeeData\GeneralEmployeeInformationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralInformationComponent extends Component
{
    use WithFileUploads;

    public $employee_id;

    public $entry_type;

    public $nin_number;

    public $title;

    public $surname;

    public $first_name;

    public $other_name;

    public $gender;

    public $nationality;

    public $birth_date;

    public $birth_place;

    public $religious_affiliation;

    public $height;

    public $weight;

    public $blood_type;

    public $civil_status;

    public $address;

    public $email;

    public $alt_email;

    public $contact;

    public $alt_contact;

    public $designation_id;

    public $station_id;

    public $department_id;

    public $reporting_to;

    public $work_type;

    public $join_date;

    public $tin_number;

    public $nssf_number;

    public $cv;

    public $photo;

    public $signature;

    public $cvPath;

    public $photoPath;

    public $signaturePath;

    public $shouldUpdate = false;

    public $employee;

    public function mount(Employee $employee = null)
    {
        $this->employee = $employee;
        $this->shouldUpdate = $employee == null ? false : true;
        $this->entry_type = $employee->entry_type;
        $this->nin_number = $employee->nin_number;
        $this->title = $employee->title;
        $this->surname = $employee->surname;
        $this->first_name = $employee->first_name;
        $this->other_name = $employee->other_name;
        $this->gender = $employee->gender;
        $this->nationality = $employee->nationality;
        $this->birth_date = $employee->birth_date;
        $this->birth_place = $employee->birth_place;
        $this->religious_affiliation = $employee->religious_affiliation;
        $this->height = $employee->height;
        $this->weight = $employee->weight;
        $this->blood_type = $employee->blood_type;
        $this->civil_status = $employee->civil_status;
        $this->address = $employee->address;
        $this->email = $employee->email;
        $this->alt_email = $employee->alt_email;
        $this->contact = $employee->contact;
        $this->alt_contact = $employee->alt_contact;
        $this->designation_id = $employee->designation_id;
        $this->station_id = $employee->station_id;
        $this->department_id = $employee->department_id;
        $this->reporting_to = $employee->reporting_to;
        $this->work_type = $employee->work_type;
        $this->join_date = $employee->join_date;
        $this->tin_number = $employee->tin_number;
        $this->nssf_number = $employee->nssf_number;
        $this->cv = $employee->cv;
        $this->photo = $employee->photo;
        $this->signature = $employee->signature;
        $this->cvPath = $employee->cvPath;
        $this->photoPath = $employee->photoPath;
        $this->signaturePath = $employee->signaturePath;
    }

    public function storeEmployee()
    {
        $employeeDTO = new GeneralEmployeeData($this->employee);

        $this->validate($employeeDTO->rules());

        DB::transaction(function () {
            $message = null;
            if ($this->cv != null) {
                $this->validate([
                    'cv' => ['mimes:pdf', 'max:5000'],
                ]);

                $cvName = date('YmdHis').$this->surname.'.'.$this->cv->extension();

                $this->cvPath = $this->cv->storeAs('employees/resumes', $cvName);
            } else {
                $this->cvPath = null;
            }

            if ($this->photo != null) {
                $this->validate([
                    'photo' => ['image', 'mimes:jpg,png', 'max:100'],
                ]);

                $photoName = date('YmdHis').$this->surname.'.'.$this->photo->extension();
                $this->photoPath = $this->photo->storeAs('employees/photos', $photoName, 'public');
            } else {
                $this->photoPath = null;
            }

            if ($this->signature != null) {
                $this->validate([
                    'signature' => ['image', 'mimes:jpg,png', 'max:100'],
                ]);

                $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
                $this->signaturePath = $this->signature->storeAs('employees/signatures', $signatureName, 'public');
            } else {
                $this->signaturePath = null;
            }

            $employeeDTO = GeneralEmployeeData::from(
                [
                    'entry_type' => $this->entry_type,
                    'nin_number' => $this->nin_number,
                    'title' => $this->title,
                    'surname' => $this->surname,
                    'first_name' => $this->first_name,
                    'other_name' => $this->other_name,
                    'gender' => $this->gender,
                    'nationality' => $this->nationality,
                    'birth_date' => $this->birth_date,
                    'birth_place' => $this->birth_place,
                    'religious_affiliation' => $this->religious_affiliation,
                    'height' => $this->height,
                    'weight' => $this->weight,
                    'blood_type' => $this->blood_type,
                    'civil_status' => $this->civil_status,
                    'address' => $this->address,
                    'email' => $this->email,
                    'alt_email' => $this->alt_email,
                    'contact' => $this->contact,
                    'alt_contact' => $this->alt_contact,
                    'designation_id' => $this->designation_id,
                    'station_id' => $this->station_id,
                    'department_id' => $this->department_id,
                    'reporting_to' => $this->reporting_to,
                    'work_type' => $this->work_type,
                    'join_date' => $this->join_date,
                    'tin_number' => $this->tin_number,
                    'nssf_number' => $this->nssf_number,
                    'signature' => $this->signaturePath,
                    'cv' => $this->cvPath,
                    'photo' => $this->photoPath,
                    'employee' => $this->employee,
                ]
            );

            $employeeService = new GeneralEmployeeInformationService();

            if ($this->shouldUpdate == false) {
                $employee = $employeeService->createEmployee($employeeDTO);
                $message = 'Employee details created successfully';
                $this->reset($employeeDTO->resetInputs());
            } else {
                $employee = $employeeService->updateEmployee($this->employee, $employeeDTO);
                $message = 'Employee details updated successfully';
                $this->employee = $employee;
            }
            $this->employee_id = $employee->id;

            $loadingInfo = 'For '.$employee->fullName.' |'.$employee->employee_number;

            $this->emit('switchEmployee', [
                'employeeId' => $this->employee_id,
                'info' => $loadingInfo,
            ]);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => $message]);

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Employee Data Saved!',
                'text' => $employee->fullName.'| Employee Number: '.$employee->employee_number,
            ]);

        });
    }

    public function render()
    {
        $data['designations'] = Designation::where('is_active', true)->get();
        $data['stations'] = Station::where('is_active', true)->get();
        $data['departments'] = Department::where('is_active', true)->get();
        $data['supervisors'] = Employee::where('is_active', true)->get();

        return view('livewire.human-resource.employee-data.inc.general-information-component', $data);
    }
}
