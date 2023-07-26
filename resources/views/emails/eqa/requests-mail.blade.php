@component('mail::message')
# {{ $details['title'] }}

__Tracker:__ {{ $details['tracker'] }}<br>
__Laboratory:__ {{ $details['lab'] }}<br>
__Country:__ {{ $details['country'] }}<br>
__Test Event Round:__ {{ $details['round']??'' }}<br>
__Sequencing Platform:__ {{ $details['seq_platform'] }}<br>
__Bioinfomatics Pipeline:__ {{ $details['bioinfo_pipeline'] }}<br>
__Pathogen:__ {{ $details['pathogen']??'' }}<br>
__Status:__ {{ ucfirst($details['status']) }}<br>
__Date:__ {{ $details['date'] }}<br>
{{-- {{ config('app.name') }} --}}
@endcomponent
