<x-mail::message>
# Book Export

The book export has been completed. You can download the files from the following links:

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 20px 0;">
    <thead>
        <tr>
            <th align="left" style="padding: 10px; border-bottom: 2px solid #0307129c;">Catalog</th>
            <th align="left" style="padding: 10px; border-bottom: 2px solid #0307129c;">Download Link</th>
        </tr>
    </thead>
    <tbody>
    @foreach($excels as $excel)
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $excel['catalog'] }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                <a href="{{ $excel['link'] }}" style="display: inline-block; padding: 8px 16px; background-color: #0307129c; color: white; text-decoration: none; border-radius: 5px;">
                    Download
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

Thanks!<br>
</x-mail::message>
