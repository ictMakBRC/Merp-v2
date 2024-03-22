<table style="border-collapse:collapse;margin-left:5.5566pt" width="100%" cellspacing="0">
    <tbody>
        <tr>
            <td>Name: {{ $info->employee->fullName ?? 'N/A' }}</td>
            <td>Department: {{ $info->employee?->department?->name ?? 'N/A' }}</td>
            <td>Designation: {{ $info->employee?->designation?->name ?? 'N/A' }}</td>
        </tr>
    </tbody>
</table>
