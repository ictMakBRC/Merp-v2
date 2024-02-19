<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Customer Prifile</h4>
            <p class="text-muted mb-0">{{ $requestable->name }}</p>
        </div><!--end card-header-->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <div class="nav flex-column nav-pills text-left" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a  wire:ignore.self class="nav-link waves-effect waves-light active" id="v-pills-home-tab" data-bs-toggle="pill"
                            href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                            aria-selected="true">Home</a>
                        <a  wire:ignore.self wire:click="viewInvoices()" class="nav-link waves-effect waves-light" id="v-pills-profile-tab" data-bs-toggle="pill"
                            href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                            aria-selected="false">Invoice</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-profile-tab" data-bs-toggle="pill"
                            href="#v-pills-statement" role="tab" aria-controls="v-pills-statement"
                            aria-selected="false">Statement</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Expense</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Income</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Paymnets</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Projects</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Credit Notes</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Tasks</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Files</a>
                        <a class="nav-link waves-effect waves-light" id="v-pills-settings-tab" data-bs-toggle="pill"
                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false">Reminders</a>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div  wire:ignore.self class="tab-content mo-mt-2" id="v-pills-tabContent">
                        <div  wire:ignore.self class="tab-pane  fade active show" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            @include('livewire.finance.customer.inc.dashboard')
                        </div>
                        <div  wire:ignore.self class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            {{-- @if (count($invoices)>0) --}}
                            @include('livewire.finance.customer.inc.invoices')
                            {{-- @endif --}}
                        </div>
                        <div class="tab-pane fade" id="v-pills-statement" role="tabpanel"
                            aria-labelledby="v-pills-statement-tab">
                            @include('livewire.finance.customer.inc.statement')
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
