<div class="row mb-0">
    <form>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="causer" class="form-label">{{ __('user-mgt.causer') }}</label>
                <select class="form-select select2" id="causer" wire:model.lazy="causer">
                    <option selected value="0">All</option>
                    @forelse ($users as $user)
                        <option value='{{ $user->id }}'>{{ $user->fullName }}</option>
                    @empty
                    @endforelse
                </select>
                <div class="text-info" wire:loading wire:target='causer'>
                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                        <span class='sr-only'></span>
                    </div>
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <label for="event" class="form-label">{{ __('user-mgt.event') }}</label>
                <select class="form-select select2" id="event" wire:model.lazy="event">
                    <option selected value="0">All</option>
                    @forelse ($events as $event)
                        <option value='{{ $event->event }}'>{{ $event->event }}</option>
                    @empty
                    @endforelse
                </select>
                <div class="text-info" wire:loading wire:target='event'>
                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                        <span class='sr-only'></span>
                    </div>
                </div>
            </div>

            <div class="mb-3 col-md-3">
                <label for="subject" class="form-label">{{ __('user-mgt.target') }}</label>
                <select class="form-select select2" id="subject" wire:model.lazy="subject">
                    <option selected value="0">All</option>
                    @forelse ($log_names as $log_name)
                        <option value='{{ $log_name->log_name }}'>{{ $log_name->log_name }}</option>
                    @empty
                    @endforelse
                </select>
                <div class="text-info" wire:loading wire:target='subject'>
                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                        <span class='sr-only'></span>
                    </div>
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <label for="from_date" class="form-label">{{ __('user-mgt.start_date') }}</label>
                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                <div class="text-info" wire:loading wire:target='from_date'>
                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                        <span class='sr-only'></span>
                    </div>
                </div>
            </div>
            
            <div class="mb-3 col-md-2">
                <label for="to_date" class="form-label">{{ __('user-mgt.end_date') }}</label>
                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                <div class="text-info" wire:loading wire:target='to_date'>
                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                        <span class='sr-only'></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->
    </form>
</div>
