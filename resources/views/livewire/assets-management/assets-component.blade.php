<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{-- @if (!$toggleForm) --}}
                                        Assets and Equipments 
                                        {{-- (<span
                                            class="text-danger fw-bold">{{ $countries->total() }}</span>) --}}
                                        {{-- @include('livewire.layouts.partials.inc.filter-toggle') --}}
                                    {{-- @else
                                        Edit Assets
                                    @endif --}}

                                </h5>
                                {{-- @include('livewire.layouts.partials.inc.create-resource') --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="new-resource">
                        <form method="POST" action="#" id="maintenanceForm">
                            @csrf
                            <div class="row">
                                <div>
                                    <h4 class="header-title mb-3 text- text-center"> General Asset Information</h4>
                                </div>
                                <hr>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="assetName" class="form-label">Asset Name</label>
                                        <input type="text" id="assetName" class="form-control" name="asset_name"
                                            value="{{ old('asset_name', '') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select select2" data-toggle="select2" id="category"
                                            name="asset_category_id">
                                            <option selected>Select Category</option>
                                            {{-- @foreach ($categories as $category)
                                                <option value='{{ $category->id }}'>{{ $category->category_name }}</option>
                                            @endforeach --}}
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subCategory" class="form-label">Subcategory</label>
                                        <select class="form-select select2" data-toggle="select2" id="subCategory"
                                            name="asset_subcategory_id">
                                            <option selected>Select subcategory</option>
                                            {{-- @foreach ($subcats as $subcat)
                                                <optgroup label="{{ $subcat->category_name }}">
                                                    @foreach ($subcat->subcategories as $subcategory)
                                                        <option value='{{ $subcategory->id }}'>
                                                            {{ $subcategory->subcategory_name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach --}}
                                            <optgroup label="{{ __('Not Applicable') }}">
                                                <option value=''>N/A</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" id="brand" class="form-control" name="brand"
                                            value="{{ old('brand', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" id="model" class="form-control" name="model"
                                            value="{{ old('model', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="serialNumber" class="form-label">Serial Number</label>
                                        <input type="text" id="serialNumber" class="form-control"
                                            placeholder="Enter N/A if not Present" name="serial_number"
                                            value="{{ old('serial_number', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">Barcode</label>
                                        <input type="text" id="barcode"
                                            class="form-control" placeholder="Focus to Auto-Generate" name="barcode"
                                            value="{{ old('barcode', '') }}">
                                        <svg id="barcodee" style="display: none"></svg>
                                    </div>
                                    <div class="mb-3">
                                        <label for="engravedLabel" class="form-label">Engraved Label</label>
                                        <input type="text" id="engravedLabel" class="form-control" name="engraved_label"
                                            placeholder="Enter N/A if not Engraved/Labelled"
                                            value="{{ old('engraved_label', '') }}">
                                    </div>
                                    <div>
                                        <h4 class="header-title mb-3 text-center"> Asset Details</h4>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="assetStatus" class="form-label">Status</label>
                                        <select class="form-select select2" data-toggle="select2" id="assetStatus"
                                            name="status">
                                            <option selected>Select status</option>
                                            <option value='Checked Out'>Checked Out</option>
                                            <option value='In stock'>In stock</option>
                                            <option value='Archived'>Archived</option>
                                            <option value='Disposed of'>Disposed of</option>
                                            <option value='Out for repair/maintenance'>Out for repair/maintenance</option>
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="checkedOut" style="display: none">
                                        <label for="checkedOutTo" class="form-label">Checked out to</label>
                                        <select class="form-select select2" data-toggle="select2" id="checkedOutTo"
                                            name="user_id">
                                            <option selected value="">Select user</option>
                                            {{-- @foreach ($users as $user)
                                                <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                            @endforeach --}}
                                            <option value=''>None</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location</label>
                                        <select class="form-select select2" data-toggle="select2" id="location"
                                            name="station_id">
                                            <option selected>Select location</option>
                                            {{-- @foreach ($stations as $station)
                                                <option value='{{ $station->id }}'>{{ $station->station_name }}</option>
                                            @endforeach --}}
                                            <option value=''>None</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="departmentOrLab"
                                            class="form-label">Department/lab/Project/Unit</label>
                                        <select class="form-select select2" data-toggle="select2" id="departmentOrLab"
                                            name="department_id">
                                            <option selected value="">Select unit</option>
                                            {{-- @foreach ($departments as $department)
                                                <option value='{{ $department->id }}'>{{ $department->department_name }}
                                                </option>
                                            @endforeach --}}
                                            <option value=''>none</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="condition" class="form-label">Condition</label>
                                        <select class="form-select select2" data-toggle="select2" id="condition"
                                            name="condition">
                                            <option selected value="">Select condition</option>
                                            <option value='New'>New</option>
                                            <option value='Good'>Good</option>
                                            <option value='Fair'>Fair</option>
                                            <option value='Bad'>Bad</option>
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                </div> <!-- end col -->
    
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="vendor" class="form-label">Vendor/Supplier</label>
                                        <select class="form-select select2" data-toggle="select2" id="vendor"
                                            name="vendor_id">
                                            <option selected value="">Select vendor</option>
                                            {{-- @foreach ($vendors as $vendor)
                                                <option value='{{ $vendor->id }}'>{{ $vendor->vendor_name }}</option>
                                            @endforeach --}}
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                    <div>
                                        <h4 class="header-title mb-3 text-center"> Purchasing Details</h4>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="purchasePrice" class="form-label">Purchase Price</label>
                                        <input class="form-control" id="purchasePrice" type="text"
                                            name="purchase_price" value="{{ old('purchase_price', '') }}">
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="purchaseDate" class="form-label">Purchase Date</label>
                                        <input class="form-control" id="purchaseDate" type="date"
                                            name="purchase_date" value="{{ old('purchase_date', '') }}">
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="purchaseOrderNumber" class="form-label">Purchase Order Number</label>
                                        <input class="form-control" id="purchaseOrderNumber" type="text"
                                            name="purchase_order_number" value="{{ old('purchase_order_number', '') }}">
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="warrantyEnd" class="form-label">Warranty End</label>
                                        <input class="form-control" id="warrantyEnd" type="date" name="warranty_end"
                                            value="{{ old('warranty_end', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="depreciationMethod" class="form-label">Depreciation Method</label>
                                        <select class="form-select select2" data-toggle="select2" id="depreciationMethod"
                                            name="depreciation_method">
                                            <option selected value="">Select method</option>
                                            <option value='Straight line method'>Straight line method</option>
                                            <option value='educing balance method'>Reducing balance method</option>
                                            <option value='No Depreciating'>No Depreciating</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="depreciationRate" class="form-label">Rate of Depreciation(%)</label>
                                        <input class="form-control" id="depreciationRate" type="number"
                                            name="depreciation_rate" value="{{ old('depreciation_rate', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usefulYears" class="form-label">Expected Useful Years</label>
                                        <input class="form-control" id="usefulYears" type="number"
                                            name="expected_useful_years" value="{{ old('expected_useful_years', '') }}">
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="insuranceCompany" class="form-label">Insurance Company</label>
                                        <select class="form-select select2" data-toggle="select2" id="insuranceCompany"
                                            name="insurance_company">
                                            <option selected value="">Select company</option>
                                            {{-- @foreach ($vendors as $vendor)
                                                <option value='{{ $vendor->id }}'>{{ $vendor->vendor_name }}</option>
                                            @endforeach --}}
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="insuranceType" class="form-label">Insurance Type</label>
                                        <select class="form-select select2" data-toggle="select2" id="insuranceType"
                                            name="insurance_type">
                                            <option selected value="">Select type</option>
                                            {{-- @foreach ($insurancetypes as $nsurancetype)
                                                <option value='{{ $nsurancetype->id }}'>{{ $nsurancetype->type }}
                                                </option>
                                            @endforeach --}}
                                            <option value=''>N/A</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="insuranceEnd" class="form-label">Insurance End</label>
                                        <input class="form-control" id="insuranceEnd" type="date"
                                            name="insurance_end" value="{{ old('insurance_end', '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks/Comment</label>
                                        <textarea class="form-control" id="remarks" rows="5" name="remarks">{{ old('remarks', '') }}</textarea>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row-->
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-success" type="submit" id="submitButton"> ADD ASSET</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                    

                    <div class="tab-content">
                        <div class="row mb-0">
                            {{-- <div class="row mb-0" @if (!$filter) hidden @endif> --}}
                            <h6>Filter Assets and Equipments</h6>

                            <div class="mb-3 col-md-4">
                                <label for="country_region_id" class="form-label">Region</label>
                                <select class="form-select select2" id="country_region_id"
                                    wire:model="country_region_id">
                                    <option selected value="0">All</option>
                                    {{-- @forelse ($regions as $region)
                                        <option value='{{ $region->id }}'>{{ $region->name }}</option>
                                    @empty
                                    @endforelse --}}
                                </select>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="mt-4 col-md-1">
                                <a type="button" class="btn btn-outline-success me-2" wire:click="export()">Export</a>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="perPage" class="form-label">Per Page</label>
                                <select wire:model="perPage" class="form-select" id="perPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-select">
                                    <option value="name">Name</option>
                                    <option value="id">Latest</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="orderAsc" class="form-label">Order</label>
                                <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                    <option value="1">Asc</option>
                                    <option value="0">Desc</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control"
                                    wire:model.debounce.300ms="search" placeholder="search">
                            </div>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Region</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($countries as $key => $country)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->region->name }}</td>
                                            <td class="table-action">
                                                <button class="action-ico btn btn-outline-success mx-1"
                                                    wire:click="editdata({{ $country->id }})"><i
                                                        class="bx bx-edit"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{-- {{ $countries->links('vendor.livewire.bootstrap') }} --}}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    {{-- @push('scripts')
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script>
            window.addEventListener('livewire:load', () => {
                initializeSelect2();
            });

            $('#region_id').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('region_id', data.id);
            });

            $('#country_region_id').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('country_region_id', data.id);
            });

            window.addEventListener('livewire:update', () => {
                $('.select2').select2('destroy'); //destroy the previous instances of select2
                initializeSelect2();
            });

            function initializeSelect2() {

                $('.select2').each(function() {
                    $(this).select2({
                        theme: 'bootstrap4',
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                            '100%' : 'style',
                        placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : 'Select',
                        allowClear: Boolean($(this).data('allow-clear')),
                    });
                });
            }
        </script>
    @endpush --}}
</div>
