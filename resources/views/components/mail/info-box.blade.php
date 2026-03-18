@props(['title'])

<div style="background-color: #f8f9fa; border-left: 4px solid #002e7f; padding: 15px; margin: 20px 0; border-radius: 4px;">
    @if($title ?? false)
        <h4 style="color: #002e7f; margin-top: 0; margin-bottom: 10px;">{{ $title }}</h4>
    @endif
    <div style="color: #333333;">
        {{ $slot }}
    </div>
</div>
