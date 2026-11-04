@props(['meta'])

<title>{{ $meta->title }}</title>
<meta name="description" content="{{ $meta->description }}">
<meta name="robots" content="{{ $meta->robots }}">
<link rel="canonical" href="{{ $meta->canonicalUrl }}">

@if (! empty($meta->alternates['id']))
    <link rel="alternate" hreflang="id" href="{{ $meta->alternates['id'] }}">
@endif
@if (! empty($meta->alternates['en']))
    <link rel="alternate" hreflang="en" href="{{ $meta->alternates['en'] }}">
@endif
@if (! empty($meta->alternates['xDefault']))
    <link rel="alternate" hreflang="x-default" href="{{ $meta->alternates['xDefault'] }}">
@endif
@if ($meta->ampUrl)
    <link rel="amphtml" href="{{ $meta->ampUrl }}">
@endif

<meta property="og:type" content="{{ $meta->ogType }}">
<meta property="og:title" content="{{ $meta->ogTitle }}">
<meta property="og:description" content="{{ $meta->ogDescription }}">
<meta property="og:url" content="{{ $meta->canonicalUrl }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'id' ? 'id_ID' : 'en_US' }}">
@if ($meta->ogImageUrl)
    <meta property="og:image" content="{{ $meta->ogImageUrl }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta->ogTitle }}">
<meta name="twitter:description" content="{{ $meta->ogDescription }}">

@if ($meta->schemaGraph !== [])
    @php
        $jsonLdPayload = [
            chr(64).'context' => 'https://schema.org',
            chr(64).'graph' => $meta->schemaGraph,
        ];
    @endphp
    @pushOnce('schema')
        <script type="application/ld+json">{!! json_encode($jsonLdPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endPushOnce
@endif
