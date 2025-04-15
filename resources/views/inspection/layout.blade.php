<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>État des lieux</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Inter 18pt', sans-serif;
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
