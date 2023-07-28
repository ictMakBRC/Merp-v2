<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-none border">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bx bx-cog me-2"></i>{{ __('public.general_settings') }}</h6>
            </div>
            <div class="card-body">

                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                                {{ __('user-mgt.theme_customization') }}
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div>
                                    <div class="mb-0 text-success fw-bold">{{ __('user-mgt.mode') }}</div>
                                    {{-- <hr> --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model='theme' id="Light"
                                            value="light-theme">
                                        <label class="form-check-label" for="Light">Light</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model='theme' id="Dark"
                                            value="dark-theme">
                                        <label class="form-check-label" for="Dark">Dark</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model='theme' id="SemiDark"
                                            value="semi-dark">
                                        <label class="form-check-label" for="SemiDark">Semi Dark</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model='theme' id="Minimal"
                                            value="minimal-theme" checked>
                                        <label class="form-check-label" for="Minimal">Minimal Theme</label>
                                    </div>
                                </div>
                                <hr />

                                <div class="mb-0 text-success fw-bold">{{ __('user-mgt.header') }}</div>
                                <div class="row row-cols-auto g-3">
                                    <div class="col">
                                        <div class="headercolor-1 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor1')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-2 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor2')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-3 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor3')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-4 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor4')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-5 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor5')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-6 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor6')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-7 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor7')"> &nbsp;</div>
                                    </div>
                                    <div class="col">
                                        <div class="headercolor-8 radius-10" style="width: 50px;height:50px"
                                            wire:click="updateHeaderColor('headercolor8')"> &nbsp;</div>
                                    </div>

                                </div>
                                <hr />

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
