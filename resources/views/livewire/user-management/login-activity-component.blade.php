<div>
    <div class="row" x-data="{ filter_data: @entangle('filter') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{__('user-mgt.user_login_activity')}}
                                    @include('livewire.layouts.partials.inc.filter-toggle-alpine')
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" class="btn btn-outline-success" wire:click="refresh()"><i
                                            class="ti ti-refresh"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('livewire.user-management.login-activity.list-table')
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    @push('scripts')

        <script>
            window.addEventListener('livewire:load', () => {
                initializeSelect2();
            });

            $('#description').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('description', data.id);
            });

            $('#platform').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('platform', data.id);
            });

            $('#browser').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('browser', data.id);
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
