<x-mailing-template-layout>
    <p>{{$details['message'] }}</p>
    <div style="font-size:14px;">
        <div><strong>#PGI EQA Support Request: </strong> {{ $details['request'] }}</div>
        <div><strong>Laboratory:</strong> {{ $details['lab'] }}</div>
        <div><strong>Country:</strong> {{ $details['country'] }}</div>
        <div><strong>Status:</strong> {{ $details['status'] }}</div>
    </div>
</x-mailing-template-layout>
