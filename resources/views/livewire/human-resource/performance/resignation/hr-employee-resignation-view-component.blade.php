<div>
    <x-general-view>
        <h4 class="text-center">EMPLOYEE RESIGNATION REQUEST</h4>
        @include('livewire.partials.user-info')
        <div class="col-12">
            <h5><b>Resigination Reason:</b>{{ $info->reason }}</h5>
            <h5><b>Subject:</b>{{ $info->subject }}</h5>
        </div>
        <div class="col-md-12">            
            {!! $info->letter !!}
        </div>
    </x-general-view>
</div>
