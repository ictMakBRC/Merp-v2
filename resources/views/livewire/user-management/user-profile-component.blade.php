<div>
    <div class="row">
        @include('livewire.user-management.user.profile-details')
        @include('livewire.user-management.user.edit-profile')
        <!--end row-->
    </div>

    @push('scripts')
        <script>
            @if (Session::has('password_change'))
                swal('Warning', "{{ session('password_change') }}", 'warning');
            @endif
        </script>
    @endpush
</div>
