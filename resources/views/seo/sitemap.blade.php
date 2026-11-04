{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['loc'] }}</loc>
        @if (! empty($entry['alternates']['id']))
            <xhtml:link rel="alternate" hreflang="id" href="{{ $entry['alternates']['id'] }}" />
        @endif
        @if (! empty($entry['alternates']['en']))
            <xhtml:link rel="alternate" hreflang="en" href="{{ $entry['alternates']['en'] }}" />
        @endif
        @if (! empty($entry['alternates']['xDefault']))
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ $entry['alternates']['xDefault'] }}" />
        @endif
        <changefreq>{{ $entry['changefreq'] }}</changefreq>
        <priority>{{ $entry['priority'] }}</priority>
    </url>
@endforeach
</urlset>

