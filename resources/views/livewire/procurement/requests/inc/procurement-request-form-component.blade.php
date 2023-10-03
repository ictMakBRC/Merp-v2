<div>
    <div class="card-bod p-0" x-cloak x-show="create_new">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#general-information" role="tab"
                    aria-selected="true">General Information</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#procurement_items" role="tab"
                    aria-selected="false">Items</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab"
                    aria-selected="false">Supporting Documents</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3 active" id="general-information" role="tabpanel">
                @include('livewire.procurement.requests.inc.request-create-form')
            </div>

            <div class="tab-pane p-3" id="procurement_items" role="tabpanel">
                <livewire:procurement.requests.inc.procurement-request-items-component />
            </div>

            <div class="tab-pane p-3" id="documents" role="tabpanel">
                <livewire:procurement.requests.inc.procurement-request-documents-component />
            </div>

        </div>
    </div>
</div>
