<div class="col-12 col-lg-4">
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body">
            <div class="profile-avatar text-center">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . $user->avatar) : asset('assets/images/users/user-vector.png') }}"
                    class="rounded-circle shadow" width="120" height="120" alt="">
            </div>
            <div class="text-center mt-1">
                <h4 class="mb-1">{{ $user->name }}</h4>
                <div class="mt-1"></div>
                {{-- @if ($user->institution)
                    <div class="mt-1"></div>
                    <h6 class="mb-1">{{ $user->institution->name ?? 'N/A' }}</h6>
                @endif --}}

            </div>
            <hr>
            <div class="text-start">
                <h5 >{{__('public.about')}}</h5>
            </div>

            <ul class="list-group list-group-flush">
                <li
                    class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                    {{__('public.name')}}
                    <span class="badge bg-primary rounded-pill">{{ $user->name }}</span>
                </li>
                
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                    {{__('public.email_address')}}
                    <span class="badge bg-primary rounded-pill">{{ $user->email ?? 'N/A' }}</span>
                </li>
 
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                    {{__('public.status')}}
                    @if ($user->is_active == 1)
                        <span class="badge bg-success rounded-pill">Active</span>
                    @else
                        <span class="badge bg-danger rounded-pill">Suspended</span>
                    @endif
    
                </li>
            </ul>
        </div>
    </div>
</div>