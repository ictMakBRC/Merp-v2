<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')
    <form
        @if (!$toggleForm) wire:submit.prevent="storeEducationHistory"
                        @else
                        wire:submit.prevent="updateEducationHistory" @endif>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="level" class="form-label required">Education Level</label>
                <select class="form-select select2" data-toggle="select2" id="level" wire:model.lazy="level" required>
                    <option selected value="">Select</option>
                    <option value='Primary'>Primary</option>
                    <option value='O-level'>Ordinary Level</option>
                    <option value='A-level'>Advanced/High School</option>
                    <option value='College'>College Level</option>
                    <option value='Vocation'>Vocational Level</option>
                    <option value='Graduate'>Graduate</option>
                    <option value='Post Graduate'>Post Graduate</option>
                    <option value='Doctorate'>Doctorate</option>
                </select>
                @error('level')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="school" class="form-label required">School/College/Institute/University</label>
                <input type="text" id="school" class="form-control" wire:model.defer="school" required>
                @error('school')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="start_date" class="form-label required">From</label>
                <input type="date" id="start_date" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="end_date" class="form-label">To</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="award" class="form-label required">Degree/Honor/Diploma/Certicate/Award</label>
                <input type="text" id="award" class="form-control" wire:model.defer="award" required>
                @error('award')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="award_document" class="form-label">Award Document</label>
                <input type="file" id="award_document" class="form-control" wire:model.lazy="award_document"
                    accept=".pdf">
                <div class="text-success text-small" wire:loading wire:target="award_document">Uploading award document
                </div>
                @error('award_document')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">
                @if (!$toggleForm)
                    {{ __('public.save') }}
                @else
                    {{ __('public.update') }}
                @endif
            </x-button>
        </div>
    </form>

    <!--EDUCATION BACKGROUND-->
    @if (!$educationInformation->isEmpty())

        <div class="row">
            <div class="col-lg-12">
                <hr>
                <div class="table-responsive">
                    <table class="table w-100 mb-0 table-striped text-center">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Institution</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Award</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($educationInformation as $award)
                            <tr>
                                <td>
                                    {{ $award->level }}
                                </td>
                                <td>
                                    {{ $award->school }}

                                </td>
                                <td>
                                    @formatDate($award->start_date)
                                </td>
                                <td>
                                    @formatDate($award->end_date)
                                </td>
                                <td>
                                    {{ $award->award }}
                                </td>
                                <td class="table-action text-center">
                                    @if ($award->award_document != null)
                                        <a href="#" class="btn-outline-success"><i class="ti ti-download"></i></a>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn btn-sm btn-outline-success"
                                        wire:click="editData({{ $award->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- end preview-->
            </div>
        </div>
    @endif
    <!-- end EDUCATION BACKGROUND-->

</div>
