@props(['url', 'text' => 'Mehr erfahren'])

<table cellpadding="0" cellspacing="0" style="margin: 20px 0;">
    <tr>
        <td style="background-color: #002e7f; border-radius: 4px; text-align: center;">
            <a href="{{ $url }}" 
               style="display: inline-block; padding: 12px 24px; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 16px;">
                {{ $text }}
            </a>
        </td>
    </tr>
</table>
