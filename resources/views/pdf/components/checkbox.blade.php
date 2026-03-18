@props(['checked' => false])
@props(['crossed' => false])
<div {{
    $attributes->merge([
        'checked' => $checked,
        'crossed' => $crossed,
        'class' => 'x-checkbox ' . ($crossed ? 'crossed ' : '') . ($checked ? 'checked' : '')
    ])    
    }}>
    <div class="checkmark">
        @if ($checked == true)
            <!-- <img src="../../../assets/Checkmark.svg" alt=""> -->
            <img src="{{ public_path('assets/Checkmark.svg') }}" alt="">
        @elseif ($crossed == true)
            <!-- <img src=" ../../../assets/Xmark.svg" alt=""> -->
            <img src="{{ public_path('assets/Xmark.svg') }}" alt="">
        @endif
    </div>
</div>