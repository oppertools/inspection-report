<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>État des lieux</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @font-face {
            font-family: 'Inter';
            src: url({{ asset('fonts/Inter_18pt-Regular.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Inter';
            src: url({{ asset('fonts/Inter_18pt-Medium.ttf') }}) format('truetype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Inter';
            src: url({{ asset('fonts/Inter_18pt-SemiBold.ttf') }}) format('truetype');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Inter';
            src: url({{ asset('fonts/Inter_18pt-Bold.ttf') }}) format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

    </style>
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="h-[5px] bg-primary w-full absolute top-0 left-0"></div>
@include('inspection.partials.header')
@include('inspection.blocks.stakeholders')
@pageBreak
@include('inspection.blocks.nomenclatures')
@pageBreak
@include('inspection.blocks.meters')
@pageBreak
@include('inspection.blocks.rooms')
@include('inspection.blocks.keys')
@pageBreak
@include('inspection.blocks.observations')
@include('inspection.blocks.signatures')
</body>
</html>
