<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{__('user-mgt.system_user_activity')}}
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" class="btn btn-outline-success me-2" wire:click="refresh()"><i
                                        class="ti ti-refresh" title="Refresh"></i></a>
  
                                    <div class="btn-group ms-auto">
                                        <button type="button"
                                            class="btn btn-outline-success">{{ __('public.options') }}</button>
                                        <button type="button"
                                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false"> <span
                                                class="visually-hidden">Toggle Options</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"
                                                wire:click="dumpAndClearTable(6)">{{__('user-mgt.backup_older_than_6_months')}}</a>
                                            </li>

                                            <li><a class="dropdown-item" href="#"
                                                wire:click="dumpAndClearTable(6,true)">{{__('user-mgt.backup_and_clear_older_than_6_months')}}</a>
                                            </li>

                                            <li><a class="dropdown-item" href="#"
                                                wire:click="dumpAndClearTable(12)">{{__('user-mgt.backup_older_than_a_year')}}</a>
                                            </li>

                                            <li><a class="dropdown-item" href="#"
                                                wire:click="dumpAndClearTable(12,true)">{{__('user-mgt.backup_and_clear_older_than_a_year')}}</a>
                                            </li>

                                            <li><a class="dropdown-item" href="#"
                                                wire:click="downloadBackupFolderAsZip()">{{__('user-mgt.download_all_backups')}}</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @include('livewire.user-management.user-activity.filter')
                </div>

                <div class="card-body">
                    @include('livewire.user-management.user-activity.list-table')
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>

    @push('scripts')

        <script>
            window.addEventListener('livewire:load', () => {
                initializeSelect2();
            });

            $('#causer').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('causer', data.id);
            });

            $('#event').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('event', data.id);
            });

            $('#subject').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('subject', data.id);
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
    @endpush
</div>
