<x-mailing-template-layout>
    <p>The Africa Centers for Disease Control and Prevention(Africa CDC), would like to hereby notify you
        of the status of your EQA Support Request Ref: {{ $details['date'] }}:
    </p>
    <div style="font-size:14px;">
        <div><strong>EQA Support Request Status</strong></div>
        <div><strong>Tracker:</strong> {{ $details['tracker'] }}</div>
        <div><strong>Laboratory:</strong> {{ $details['lab'] }}</div>
        <div><strong>Country:</strong> {{ $details['country'] }}</div>
        <div><strong>Test Event Round:</strong> {{ $details['round'] }}</div>
        <div><strong>Sequencing Platform:</strong> {{ $details['seq_platform'] }}</div>
        <div><strong>Bioinfomatics Pipeline:</strong> {{ $details['bioinfo_pipeline'] }}</div>
        <div><strong>Pathogen:</strong> {{ $details['pathogen'] }}</div>
        <div><strong>Status:</strong> {{ Str::ucfirst($details['status']) }}</div>
        <div><strong>Comment:</strong> {{ $details['comment'] }}</div>
        <div><strong>Date:</strong> {{ $details['date'] }}</div>
    </div>

</x-mailing-template-layout>
