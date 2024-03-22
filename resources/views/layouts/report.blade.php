<div>
    <div class="modal-bod">
        <table style="border-collapse:collapse;margin-left:5.5566pt" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td style="width: 10%">
                        <img src="http://merp.brc.online/images/logos/brc.png" alt="mak logo" type="image/svg+xml"
                            width="120px" alt="SVG Image">
                    </td>

                    <td class="text-center">
                        <div class="w-100 overflow-hidde">
                            <h4 style="text-indent: 0pt;text-align: center;" class="t-bold text-upper"><a
                                    name="bookmark0">
                                    {{ $facilityInfo?->company_name }}</a></h4>
                            <p style="text-align: center;">{{ $facilityInfo?->address2 ?? 'N/A' }}
                                <span> || {{ $facilityInfo?->physical_address }}</span> <br>
                                <span><strong>Tel:</strong> {{ $facilityInfo?->contact ?? 'N/A' }}
                                </span>
                                ||
                                <span><strong>Email:</strong> {{ $facilityInfo?->email ?? 'N/A' }}</span>
                                ||
                                <span><strong>Web:</strong> {{ $facilityInfo?->website ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </td>
                    <td style="width: 10%">
                        <img src="http://merp.brc.online/images/logos/mak.png" alt="BRC logo" type="image/svg+xml"
                            width="120px" alt="SVG Image">
                    </td>
                </tr>
            </tbody>
        </table>


        <div class="card p-">
            {{ $slot }}
        </div>

        <hr>
        <div class="row d-flex justify-content-center">
            {{ $action }}
        </div>
    </div>
</div>
