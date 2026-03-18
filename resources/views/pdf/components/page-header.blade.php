@props([
  'headline',
  'subheadline' => 'Dokumentenuntertitel'
])

<div class="header">
    <div class="title-wrapper">
      <h1>
        @foreach ($headline as $idx => $line)
          @if ($headline[$idx]['smaller'])
            <span class="smaller">
              {{$headline[$idx]['text']}}
            </span>
          @else
            {{$headline[$idx]['text']}}
          @endif
          <br>
        @endforeach
      </h1>
      <img src="{{public_path('assets/DRC_Logo.png')}}" alt="" />
    </div>
    <h2 class="subheadline">{{$subheadline}}</h2>
</div>