@use('App\Utilities\Constants')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>

    <style>
        @font-face {
            font-family: "canada-type-gibson";
            src: url('assets/fonts/gibson/CanadaGibson-Bold.ttf') format("truetype");
            font-style: normal;
            font-weight: 700;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url("assets/fonts/gibson/CanadaGibson-Bold-Italic.ttf") format("truetype");
            font-style: italic;
            font-weight: 700;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url("assets/fonts/gibson/CanadaGibson-SemiBold.ttf") format("truetype");
            font-style: normal;
            font-weight: 600;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url("assets/fonts/gibson/CanadaGibson-Medium.ttf") format("truetype");
            font-style: normal;
            font-weight: 500;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url("assets/fonts/gibson/CanadaGibson-Regular.ttf") format("truetype");
            font-style: normal;
            font-weight: 400;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url('assets/fonts/gibson/CanadaGibson-Regular-Italic.ttf') format("truetype");
            font-style: italic;
            font-weight: 400;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url('assets/fonts/gibson/CanadaGibson-Light.ttf') format("truetype");
            font-style: normal;
            font-weight: 300;
        }

        @font-face {
            font-family: "canada-type-gibson";
            src: url('assets/fonts/gibson/CanadaGibson-Light-Italic.ttf') format("truetype");
            font-style: italic;
            font-weight: 300;
        }

        @php
            $marginTop = $lessMarginTop ? 39 : 48;
        @endphp
        @page {
            margin-top: {{ $marginTop }}mm !important;
        }

        @page :first {
            margin-top: 0px !important;
        }
    </style>

    <!-- <link rel="stylesheet" href="https://use.typekit.net/lpn0mnm.css"> -->
    <link rel="stylesheet" media="all" href="{{ public_path('stylesheets/app.css') }}">
    <!-- <link rel="stylesheet" media="all" href="../stylesheets/app.css"> -->
    <!-- TODO: Replace Font -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

@php
    $showColors = false;
    if (Route::getCurrentRequest()->has(Constants::QUERY_TAGS['SHOW_DEBUG_COLORS'])) {
        $showColors = true;
    }

    if (Route::getCurrentRequest()->has(Constants::QUERY_TAGS['DEBUG_ALL'])) {
        $showColors = true;
        // ... add all debug-options
    }
@endphp

<body @class([
    'show-colors' => $showColors,
])>
    <div class="page">
        @stack('scripts')

        <div class="cols invisible">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>

        <!-- Upper punch-hole indicator -->
        <div
            style="position: absolute; top: 102.5mm; left: 10mm; width: 5mm; height: 5mm; border: 0.25mm solid #ccc; border-radius: 50%;">
        </div>

        <!-- Lower punch-hole indicator -->
        <div
            style="position: absolute; top: 182.5mm; left: 10mm; width: 5mm; height: 5mm; border: 0.25mm solid #ccc; border-radius: 50%;">
        </div>

        <!-- <div style="position: relative; background: #eee; width: 178mm; height: 22mm; padding: 0cm 10mm 0cm 22mm;"></div> -->

        <!-- TODO: Top-padding -->
        <x-page-header :headline="json_decode($headline, true)" subheadline="{{ $subheadline }}" />
         


        <div class="content copy">
            @include('pdf.templates.' . $include)
        </div>

        <!-- <div class="line line-height-normal" style="position: relative;bottom: -12.5mm;">
            <div class="left copy line-height-normal">
                Erstellt am [dd.mm.yyyy] von [Ersteller]
            </div>

            <div class="right copy line-height-normal page-count">
                Seite
            </div>
        </div> -->

        <!-- <div style="position: absolute; bottom: 0; left: 10mm;">
            <p>Erstellt am [DD.mm.YYYY]</p>
        </div> -->
    </div>
</body>

</html>