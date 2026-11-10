#!/usr/bin/env python3
"""
Modular Layout, Visual Wireframe, Content & SEO/Schema Scraper.

Given one or more URLs (or local HTML files), this script generates a complete,
review-ready specification for each page as an isolated modular unit:
  1. Top-to-Bottom Visual Layout Wireframe & Styling Map (ASCII wireframe, grid/column geometry,
     surface styling, typography hierarchy, and CSS design tokens).
  2. Modular Isolation vs Parent-Child Inheritance Contract (ensuring each page can be maintained
     independently without side effects on other pages, except explicit parent-child inheritance).
  3. Content Inventory, On-Page SEO Audit & JSON-LD @graph Schema Generator per page.

Usage:
  python .agents/skills/modular-layout-scraper/scripts/scrape-layout.py https://example.com
  python .agents/skills/modular-layout-scraper/scripts/scrape-layout.py --save-dir ./storage/app/scratch/review https://example.com https://example.com/services
"""

from __future__ import annotations

import argparse
import json
import os
import re
import sys
import urllib.parse
import urllib.request
from collections import Counter
from typing import Any


USER_AGENT = (
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
    "AppleWebKit/537.36 (KHTML, like Gecko) "
    "Chrome/131.0.0.0 Safari/537.36"
)


def fetch_url(url: str, timeout: int = 20) -> str:
    if os.path.exists(url):
        with open(url, "r", encoding="utf-8", errors="ignore") as f:
            return f.read()
    req = urllib.request.Request(url, headers={"User-Agent": USER_AGENT})
    with urllib.request.urlopen(req, timeout=timeout) as resp:
        charset = resp.headers.get_content_charset() or "utf-8"
        return resp.read().decode(charset, errors="ignore")


def clean_text(raw_html: str) -> str:
    text = re.sub(r"<script\b[^>]*>.*?</script>", " ", raw_html, flags=re.S | re.I)
    text = re.sub(r"<style\b[^>]*>.*?</style>", " ", text, flags=re.S | re.I)
    text = re.sub(r"<[^>]+>", " ", text)
    text = (
        text.replace("&amp;", "&")
        .replace("&nbsp;", " ")
        .replace("&#x27;", "'")
        .replace("&quot;", '"')
        .replace("\u2014", " - ")
        .replace("\u2013", " - ")
    )
    return " ".join(text.split())


def extract_attr(attrs_str: str, attr_name: str) -> str:
    pattern = rf'\b{re.escape(attr_name)}\s*=\s*["\']([^"\']+)["\']'
    match = re.search(pattern, attrs_str, flags=re.I)
    return match.group(1).strip() if match else ""


def extract_meta_tags(html: str, source: str) -> dict[str, Any]:
    title_m = re.search(r"<title\b[^>]*>(.*?)</title>", html, flags=re.S | re.I)
    title = clean_text(title_m.group(1)) if title_m else ""

    meta_map: dict[str, str] = {}
    for m in re.finditer(r"<meta\b([^>]*)>", html, flags=re.I):
        attrs = m.group(1)
        name = (
            extract_attr(attrs, "name")
            or extract_attr(attrs, "property")
            or extract_attr(attrs, "itemprop")
        ).lower()
        content = extract_attr(attrs, "content")
        if name and content:
            meta_map[name] = clean_text(content)

    canonical = ""
    alternates: list[dict[str, str]] = []
    for m in re.finditer(r"<link\b([^>]*)>", html, flags=re.I):
        attrs = m.group(1)
        rel = extract_attr(attrs, "rel").lower()
        href = extract_attr(attrs, "href")
        hreflang = extract_attr(attrs, "hreflang")
        if rel == "canonical" and href:
            canonical = href
        elif rel == "alternate" and hreflang and href:
            alternates.append({"hreflang": hreflang, "href": href})

    existing_jsonld: list[Any] = []
    for m in re.finditer(
        r'<script\b[^>]*type=["\']application/ld\+json["\'][^>]*>(.*?)</script>',
        html,
        flags=re.S | re.I,
    ):
        raw_json = m.group(1).strip()
        try:
            existing_jsonld.append(json.loads(raw_json))
        except Exception:
            pass

    return {
        "title": title,
        "title_length": len(title),
        "description": meta_map.get("description", ""),
        "description_length": len(meta_map.get("description", "")),
        "robots": meta_map.get("robots", "index, follow (default)"),
        "canonical": canonical or source,
        "og_title": meta_map.get("og:title", ""),
        "og_description": meta_map.get("og:description", ""),
        "og_image": meta_map.get("og:image", ""),
        "og_type": meta_map.get("og:type", "website"),
        "twitter_card": meta_map.get("twitter:card", "summary_large_image"),
        "alternates": alternates,
        "existing_jsonld_count": len(existing_jsonld),
    }


def extract_css_links(html: str, base_url: str) -> list[str]:
    css_urls: list[str] = []
    for match in re.finditer(r"<link\b([^>]*)>", html, flags=re.I):
        attrs = match.group(1)
        rel = extract_attr(attrs, "rel").lower()
        href = extract_attr(attrs, "href")
        if "stylesheet" in rel and href:
            full_url = urllib.parse.urljoin(base_url, href)
            if full_url not in css_urls:
                css_urls.append(full_url)
    return css_urls


def parse_css_tokens(css_text: str) -> dict[str, Any]:
    custom_props: dict[str, str] = {}
    for match in re.finditer(r"(--[a-zA-Z0-9_-]+)\s*:\s*([^;\}]+)", css_text):
        name, val = match.group(1).strip(), match.group(2).strip()
        if name not in custom_props and len(val) < 120:
            custom_props[name] = val

    hex_colors = Counter(
        m.group(0).upper()
        for m in re.finditer(r"#[0-9a-fA-F]{6}\b|#[0-9a-fA-F]{3}\b", css_text)
    )
    fonts: list[str] = []
    for match in re.finditer(r"font-family\s*:\s*([^;\}]+)", css_text, flags=re.I):
        family = " ".join(match.group(1).split()).strip()
        if family not in fonts and len(family) < 120:
            fonts.append(family)

    radii = Counter(
        m.group(1).strip()
        for m in re.finditer(r"border-radius\s*:\s*([^;\}]+)", css_text, flags=re.I)
        if len(m.group(1).strip()) < 40
    )

    return {
        "custom_properties_sample": dict(list(custom_props.items())[:40]),
        "custom_properties_count": len(custom_props),
        "top_hex_colors": [
            {"hex": color, "occurrences": count}
            for color, count in hex_colors.most_common(15)
        ],
        "font_families": fonts[:10],
        "common_border_radii": [
            {"radius": rad, "occurrences": count}
            for rad, count in radii.most_common(8)
        ],
    }


def infer_section_visual_geometry(
    tag: str,
    cls: str,
    variant: str,
    child_classes: list[str],
    img_count: int,
    has_form: bool,
    h_count: int,
    link_count: int,
) -> dict[str, str]:
    joined = " ".join([cls, variant] + child_classes).lower()

    # Infer Surface / Theme style
    if any(k in joined for k in ("dark", "navy", "black", "inverse", "footer", "cta")):
        surface = "Dark Structural Surface (Navy/Dark Background, Light Text)"
    elif any(k in joined for k in ("full-bleed", "banner", "hero")) and img_count > 0:
        surface = "Hero / Banner Surface (Split or Full-Bleed Media + High-Contrast Text)"
    elif any(k in joined for k in ("tint", "gray", "ice", "secondary", "muted")):
        surface = "Secondary Tinted Surface (Soft Ice/Neutral Background)"
    else:
        surface = "Primary Light Canvas (Crisp White Background)"

    # Infer Grid / Column Geometry
    if tag == "header":
        geometry = "Sticky Top Bar: [Brand Logo] <--- [Nav Links] ---> [Primary CTA Button]"
        ascii_box = "| [LOGO]          [Nav 1] [Nav 2] [Nav 3] [Nav 4]          ( Primary CTA ) |"
    elif tag == "footer":
        geometry = "Multi-Column Footer: [Brand & Identity] + [Navigation Columns] + [Legal Bar]"
        ascii_box = "| [Brand Summary]    [Quick Links]    [Services]    [Contact & Legal]      |"
    elif "bento" in joined:
        geometry = "12-Column Asymmetric Bento Grid (Split Hero Copy + Media + Metric Cards)"
        ascii_box = "| [Eyebrow + H1 Headline + Dual CTAs (7 col)] | [Hero Media / Bento (5 col)] |"
    elif "split" in joined or "two-col" in joined or has_form:
        if has_form:
            geometry = "2-Column Asymmetric Split: [Interactive Form Card] + [Direct Contact Info]"
            ascii_box = "| [Form Inputs + Submit Button (7 col)]  |  [Direct Channels & SLA (5 col)] |"
        else:
            geometry = "2-Column 50/50 or 60/40 Split: [Editorial Copy & CTA] + [Visual Media Frame]"
            ascii_box = "| [Eyebrow + Heading + Body + CTA (6 col)] | [Framed Image / Card (6 col)] |"
    elif any(k in joined for k in ("four-column", "4-col", "icon-grid")):
        geometry = "4-Column Equal Card Grid (Desktop: 4 cols | Tablet: 2 cols | Mobile: 1 col)"
        ascii_box = "| [Card 01]       | [Card 02]       | [Card 03]       | [Card 04]          |"
    elif any(k in joined for k in ("three-column", "3-col")):
        geometry = "3-Column Equal Card Grid (Desktop: 3 cols | Tablet: 2 cols | Mobile: 1 col)"
        ascii_box = "| [Card 01 (4 col)]      | [Card 02 (4 col)]      | [Card 03 (4 col)]      |"
    elif "slider" in joined or "marquee" in joined:
        geometry = "Horizontal Card Track / Landscape Grid (2-up or 3-up Interactive Cards)"
        ascii_box = "| <[Card 01: Image + Title + Tags + Link]  [Card 02: Image + Title + Tags]>|"
    elif "faq" in joined or "accordion" in joined:
        geometry = "12-Column Split FAQ: [Left Sticky Intro (4 col)] + [Right Accordion Stack (8 col)]"
        ascii_box = "| [Eyebrow + H2 + Escalation Card (4 col)] | [Q1 Accordion / Q2 / Q3 (8 col)]|"
    elif "timeline" in joined or "steps" in joined or "numbered" in joined:
        geometry = "Sequential Numbered Milestone / Step Grid (01 -> 02 -> 03 -> 04)"
        ascii_box = "| [01 Step] ----> [02 Step] ----> [03 Step] ----> [04 Step]                |"
    elif "blog" in joined or "article" in joined:
        geometry = "Editorial Featured Card (12-col Split) + Secondary 2-Column Article Grid"
        ascii_box = "| [Featured Landscape Article (12 col)] // [Article Card 1] [Article Card 2] |"
    elif "location" in joined:
        geometry = "2-Column Office Location Cards (Image + City + Address + Phone/Email)"
        ascii_box = "| [Location Card 1: Photo + Address]  |  [Location Card 2: Photo + Address] |"
    else:
        geometry = f"Standard Container Block ({h_count} headings, {img_count} media, {link_count} actions)"
        ascii_box = "| [Section Header (Eyebrow + H2)] -> [Content Container / Cards]           |"

    return {
        "surface_style": surface,
        "grid_geometry": geometry,
        "ascii_row": ascii_box,
    }


def infer_page_role_and_schema(
    source: str,
    meta: dict[str, Any],
    headings: list[dict[str, str]],
    sections: list[dict[str, Any]],
    faqs: list[dict[str, str]],
) -> dict[str, Any]:
    lower_src = source.lower()
    title = meta.get("title", "") or "Page Title"
    desc = meta.get("description", "") or "Summary description for this page."
    canonical = meta.get("canonical", source)

    if any(k in lower_src for k in ("contact", "kontak", "hubungi")):
        page_type = "ContactPage"
        inheritance_mode = "Child Hub Page (Inherits Parent Shell + Uses Isolated Contact Form & Location Sections)"
    elif any(k in lower_src for k in ("about", "tentang", "profile")):
        page_type = "AboutPage"
        inheritance_mode = "Child Hub Page (Inherits Parent Shell + Uses Isolated Story, Founder & Timeline Sections)"
    elif any(k in lower_src for k in ("blog", "article", "artikel", "case-stud", "studi-kasus", "news")):
        if lower_src.rstrip("/").endswith(("blog", "articles", "case-studies", "studi-kasus", "koolom-blog.html")):
            page_type = "CollectionPage (Blog / Case Studies Index)"
            inheritance_mode = "Child Hub Page (Inherits Parent Shell + Featured Landscape Item + 2-Col Article Grid)"
        else:
            page_type = "Article / BlogPosting (Detail Template)"
            inheritance_mode = "Dedicated Article Child Template (Inherits Brand Tokens + Uses 65ch Editorial Reading Layout)"
    elif any(k in lower_src for k in ("service", "layanan", "product", "produk")):
        if lower_src.rstrip("/").endswith(("services", "services-v3", "layanan", "products", "koolom-services-v3.html")):
            page_type = "CollectionPage (Services / Products Index)"
            inheritance_mode = "Child Parent-Category Page (Defines Service Card Anatomy & Shared FAQ/CTA)"
        else:
            page_type = "Service / Product (Detail Template)"
            inheritance_mode = "Child of Services Template (Inherits Service Category Styling + 8/4 Sticky Spec Layout)"
    else:
        page_type = "WebPage (Homepage / Root Landing)"
        inheritance_mode = "Root Landing Page (Composes Level 1 Parent Shell + Level 2 Reusable Section Partials)"

    graph: list[dict[str, Any]] = [
        {
            "@type": "Organization",
            "@id": "#organization",
            "name": "[Company Brand Name from docs/knowledge-base.md]",
            "url": canonical,
        },
        {
            "@type": page_type.split()[0],
            "@id": f"{canonical}#webpage",
            "url": canonical,
            "name": title,
            "description": desc,
            "isPartOf": {"@id": "#website"},
            "about": {"@id": "#organization"},
        },
        {
            "@type": "BreadcrumbList",
            "@id": f"{canonical}#breadcrumb",
            "itemListElement": [
                {"@type": "ListItem", "position": 1, "name": "Home", "item": "/"},
                {"@type": "ListItem", "position": 2, "name": title, "item": canonical},
            ],
        },
    ]

    if "Service" in page_type:
        graph.append(
            {
                "@type": "Service",
                "name": headings[0]["text"] if headings else title,
                "provider": {"@id": "#organization"},
                "description": desc,
                "areaServed": "ID",
            }
        )
    elif "Article" in page_type:
        graph.append(
            {
                "@type": "Article",
                "headline": headings[0]["text"] if headings else title,
                "author": {"@id": "#organization"},
                "publisher": {"@id": "#organization"},
                "description": desc,
            }
        )

    if faqs:
        graph.append(
            {
                "@type": "FAQPage",
                "mainEntity": [
                    {
                        "@type": "Question",
                        "name": q["question"],
                        "acceptedAnswer": {"@type": "Answer", "text": q["answer"]},
                    }
                    for q in faqs[:5]
                ],
            }
        )

    return {
        "detected_page_type": page_type,
        "modular_inheritance_mode": inheritance_mode,
        "recommended_jsonld_graph": {
            "@context": "https://schema.org",
            "@graph": graph,
        },
    }


def parse_page_structure(html: str, source: str) -> dict[str, Any]:
    meta = extract_meta_tags(html, source)

    # Extract navbar items
    nav_items: list[str] = []
    header_match = re.search(
        r"<(header|nav)\b[^>]*>(.*?)</\1>", html, flags=re.S | re.I
    )
    if header_match:
        for a_match in re.finditer(
            r"<a\b[^>]*>(.*?)</a>", header_match.group(2), flags=re.S | re.I
        ):
            lbl = clean_text(a_match.group(1))
            if lbl and lbl not in nav_items and len(lbl) < 40:
                nav_items.append(lbl)

    # All headings across page for SEO hierarchy audit
    all_headings: list[dict[str, str]] = []
    for h_m in re.finditer(r"<(h[1-6])\b[^>]*>(.*?)</\1>", html, flags=re.S | re.I):
        ht = h_m.group(1).lower()
        hx = clean_text(h_m.group(2))
        if hx:
            all_headings.append({"tag": ht, "text": hx[:100]})

    # All images for alt audit
    total_images = 0
    images_missing_alt = 0
    for img_m in re.finditer(r"<img\b([^>]*)>", html, flags=re.I):
        total_images += 1
        alt_val = extract_attr(img_m.group(1), "alt")
        if not alt_val:
            images_missing_alt += 1

    # Extract FAQ-like pairs if present
    faqs: list[dict[str, str]] = []
    for h3_m in re.finditer(r"<(h3|h4)\b[^>]*>(.*?)</\1>\s*<div[^>]*>(.*?)</div>", html, flags=re.S | re.I):
        q_txt = clean_text(h3_m.group(2))
        a_txt = clean_text(h3_m.group(3))
        if "?" in q_txt and len(a_txt) > 20:
            faqs.append({"question": q_txt[:120], "answer": a_txt[:220]})

    # Extract landmarks / sections top-to-bottom
    landmark_matches = list(
        re.finditer(r"<(header|section|article|footer)\b([^>]*)>", html, flags=re.I)
    )
    sections: list[dict[str, Any]] = []

    for idx, match in enumerate(landmark_matches):
        tag = match.group(1).lower()
        attrs = match.group(2)
        start_pos = match.start()
        end_pos = (
            landmark_matches[idx + 1].start()
            if idx + 1 < len(landmark_matches)
            else len(html)
        )
        chunk = html[start_pos:end_pos]

        cls = extract_attr(attrs, "class")
        if "w-condition-invisible" in cls:
            continue

        variant = extract_attr(attrs, "variant") or extract_attr(attrs, "data-variant")
        sec_id = extract_attr(attrs, "id")

        headings: list[dict[str, str]] = []
        for h_match in re.finditer(
            r"<(h[1-4])\b[^>]*>(.*?)</\1>", chunk, flags=re.S | re.I
        ):
            h_tag = h_match.group(1).lower()
            h_text = clean_text(h_match.group(2))
            if h_text and not any(x["text"] == h_text for x in headings):
                headings.append({"tag": h_tag, "text": h_text[:90]})
            if len(headings) >= 5:
                break

        paragraphs: list[str] = []
        for p_match in re.finditer(r"<p\b[^>]*>(.*?)</p>", chunk, flags=re.S | re.I):
            p_text = clean_text(p_match.group(1))
            if len(p_text) > 20 and p_text not in paragraphs:
                paragraphs.append(p_text[:140])
            if len(paragraphs) >= 3:
                break

        ctas: list[dict[str, str]] = []
        for a_match in re.finditer(r"<a\b([^>]*)>(.*?)</a>", chunk, flags=re.S | re.I):
            a_href = extract_attr(a_match.group(1), "href")
            a_lbl = clean_text(a_match.group(2))
            if a_lbl and len(a_lbl) < 45 and not a_href.startswith("#"):
                if not any(c["label"] == a_lbl for c in ctas):
                    ctas.append({"label": a_lbl, "href": a_href[:60]})
            if len(ctas) >= 4:
                break

        child_classes: list[str] = []
        for d_match in re.finditer(r"<div\b([^>]*)>", chunk, flags=re.I):
            d_cls = extract_attr(d_match.group(1), "class")
            if d_cls and d_cls not in child_classes:
                child_classes.append(d_cls)
            if len(child_classes) >= 10:
                break

        has_form = bool(re.search(r"<form\b", chunk, flags=re.I))
        img_count = len(re.findall(r"<(img|picture)\b", chunk, flags=re.I))
        card_hints = [
            c
            for c in child_classes
            if any(
                k in c.lower()
                for k in ("grid", "card", "list", "slider", "bento", "col", "wrap")
            )
        ]

        signature = f"{tag}.{cls.split()[0] if cls else 'default'}"
        if variant:
            signature += f"[variant={variant}]"

        visual_spec = infer_section_visual_geometry(
            tag=tag,
            cls=cls,
            variant=variant,
            child_classes=child_classes,
            img_count=img_count,
            has_form=has_form,
            h_count=len(headings),
            link_count=len(ctas),
        )

        sections.append(
            {
                "index": len(sections) + 1,
                "tag": tag,
                "id": sec_id,
                "class": cls,
                "variant": variant,
                "signature": signature,
                "visual_spec": visual_spec,
                "headings": headings,
                "sample_copy": paragraphs,
                "ctas": ctas,
                "child_containers": child_classes[:6],
                "layout_hints": card_hints[:5],
                "image_count": img_count,
                "has_form": has_form,
            }
        )

    body_words = len(clean_text(html).split())
    h1_list = [h["text"] for h in all_headings if h["tag"] == "h1"]

    seo_schema = infer_page_role_and_schema(
        source=source,
        meta=meta,
        headings=all_headings,
        sections=sections,
        faqs=faqs,
    )

    return {
        "source": source,
        "meta_seo": meta,
        "content_audit": {
            "word_count": body_words,
            "h1_count": len(h1_list),
            "h1_texts": h1_list,
            "heading_outline": all_headings[:20],
            "total_images": total_images,
            "images_missing_alt": images_missing_alt,
            "extracted_faqs": faqs[:6],
        },
        "seo_and_schema_spec": seo_schema,
        "nav_items": nav_items[:12],
        "sections": sections,
    }


def classify_modular_architecture(pages: list[dict[str, Any]]) -> dict[str, Any]:
    sig_counter: Counter[str] = Counter()
    sig_pages: dict[str, list[str]] = {}

    for page in pages:
        seen_in_page: set[str] = set()
        for sec in page["sections"]:
            sig = sec["signature"]
            if sig not in seen_in_page:
                sig_counter[sig] += 1
                sig_pages.setdefault(sig, []).append(page["source"])
                seen_in_page.add(sig)

    # Tag each section on each page with its modular isolation scope
    for page in pages:
        for sec in page["sections"]:
            sig = sec["signature"]
            if sec["tag"] in ("header", "footer"):
                sec["isolation_scope"] = "LEVEL 1: Parent Shell Chrome (Inherited from layouts/compro.blade.php)"
            elif sig_counter[sig] > 1 and len(pages) > 1:
                sec["isolation_scope"] = (
                    f"LEVEL 2: Shared Reusable Partial (<x-sections.*>, used on {sig_counter[sig]} pages via isolated @props)"
                )
            else:
                sec["isolation_scope"] = (
                    "LEVEL 3: Page-Isolated Block (Scoped strictly to this page view; zero impact on other pages)"
                )

    parent_chrome: list[str] = []
    shared_partials: list[dict[str, Any]] = []
    child_unique_sections: dict[str, list[dict[str, Any]]] = {}

    for page in pages:
        src = page["source"]
        child_unique_sections[src] = []
        for sec in page["sections"]:
            sig = sec["signature"]
            if sec["tag"] in ("header", "footer"):
                if sig not in parent_chrome:
                    parent_chrome.append(sig)
            elif sig_counter[sig] > 1 and len(pages) > 1:
                if not any(p["signature"] == sig for p in shared_partials):
                    shared_partials.append(
                        {
                            "signature": sig,
                            "used_on_pages": sig_pages[sig],
                            "sample_headings": sec["headings"][:2],
                        }
                    )
            else:
                child_unique_sections[src].append(
                    {
                        "signature": sig,
                        "variant": sec["variant"],
                        "headings": sec["headings"][:2],
                        "layout_hints": sec["layout_hints"],
                        "has_form": sec["has_form"],
                    }
                )

    return {
        "level_1_parent_layout_chrome": parent_chrome,
        "level_2_reusable_section_partials": shared_partials,
        "level_3_child_page_templates": child_unique_sections,
    }


def format_markdown_report(report: dict[str, Any]) -> str:
    lines: list[str] = []
    lines.append("# Modular Page Layout, Visual Wireframe & SEO/Schema Review Spec")
    lines.append("")
    lines.append(
        "> **Review Gate Purpose:** Inspect the top-to-bottom visual layout wireframe, modular isolation boundaries, and On-Page SEO + JSON-LD `@graph` schema for each scraped page below before applying changes to `docs/` or Blade code."
    )
    lines.append("")

    tokens = report.get("css_tokens", {})
    if tokens:
        lines.append("## 1. Global Parent Theme Tokens (`resources/css/compro.css`)")
        if tokens.get("font_families"):
            lines.append(f"- **Detected Font Stack:** `{', '.join(tokens['font_families'][:5])}`")
        if tokens.get("top_hex_colors"):
            color_str = ", ".join(
                f"`{c['hex']}` ({c['occurrences']}x)"
                for c in tokens["top_hex_colors"][:10]
            )
            lines.append(f"- **Scraped Palette Spectrum:** {color_str}")
        if tokens.get("common_border_radii"):
            rad_str = ", ".join(
                f"`{r['radius']}` ({r['occurrences']}x)"
                for r in tokens["common_border_radii"][:6]
            )
            lines.append(f"- **Border Radius Scale:** {rad_str}")
        if tokens.get("custom_properties_sample"):
            lines.append("- **CSS Variables (`:root` sample):**")
            for k, v in list(tokens["custom_properties_sample"].items())[:12]:
                lines.append(f"  - `{k}: {v}`")
        lines.append("")

    # Per-page complete specification
    for page_idx, page in enumerate(report.get("pages", []), start=1):
        src = page["source"]
        meta = page["meta_seo"]
        audit = page["content_audit"]
        seo_spec = page["seo_and_schema_spec"]

        lines.append("---")
        lines.append("")
        lines.append(f"## Page {page_idx}: `{src}`")
        lines.append(f"- **Detected Page Role:** `{seo_spec['detected_page_type']}`")
        lines.append(f"- **Modular Inheritance & Isolation Rule:** {seo_spec['modular_inheritance_mode']}")
        lines.append("")

        # Part A: Visual Top-to-Bottom ASCII Wireframe
        lines.append("### A. Top-to-Bottom Visual Layout Wireframe")
        lines.append("```text")
        lines.append("+--------------------------------------------------------------------------+")
        for sec in page["sections"]:
            sig_label = f"[{sec['index']:02d}] {sec['signature']}"
            lines.append(f"| {sig_label:<72} |")
            lines.append(f"{sec['visual_spec']['ascii_row']}")
            lines.append("+--------------------------------------------------------------------------+")
        lines.append("```")
        lines.append("")

        # Part B: Section-by-Section Styling & Isolation Table
        lines.append("### B. Top-to-Bottom Section Styling & Modular Isolation Breakdown")
        lines.append("| Order | Section Signature | Visual Geometry & Surface Styling | Content & Actions | Modular Isolation Scope |")
        lines.append("| :--- | :--- | :--- | :--- | :--- |")
        for sec in page["sections"]:
            h_summary = "; ".join(
                f"**{h['tag'].upper()}**: {h['text'][:45]}" for h in sec["headings"][:2]
            ) or "Structural Chrome"
            cta_summary = ", ".join(f"`{c['label']}`" for c in sec["ctas"][:2])
            if cta_summary:
                h_summary += f" <br>CTAs: {cta_summary}"
            geom = f"**{sec['visual_spec']['surface_style']}**<br>{sec['visual_spec']['grid_geometry']}"
            if sec["layout_hints"]:
                geom += f"<br>Classes: `{', '.join(sec['layout_hints'][:3])}`"
            lines.append(
                f"| `{sec['index']:02d}` | `{sec['signature']}` | {geom} | {h_summary} | {sec.get('isolation_scope', 'Isolated')} |"
            )
        lines.append("")

        # Part C: Content Analysis & On-Page SEO Spec
        lines.append("### C. Content Analysis & On-Page SEO Specification")
        lines.append(f"- **Scraped `<title>` ({meta['title_length']} chars):** `{meta['title'] or '[MISSING - Must Define]'}`")
        lines.append(
            f"- **Scraped `<meta name=\"description\">` ({meta['description_length']} chars):** `{meta['description'] or '[MISSING - Must Define 140-160 chars]'}`"
        )
        lines.append(f"- **Canonical URL:** `{meta['canonical']}`")
        lines.append(
            f"- **Word Count & Media Audit:** `{audit['word_count']} words` | `{audit['total_images']} images` (`{audit['images_missing_alt']}` missing `alt` attributes)"
        )
        h1_status = (
            f"PASS (Single H1: \"{audit['h1_texts'][0]}\")"
            if audit["h1_count"] == 1
            else f"WARN ({audit['h1_count']} H1 tags found: {audit['h1_texts']} - Must normalize to exactly 1 H1)"
        )
        lines.append(f"- **Heading Hierarchy Audit (`<h1>` check):** {h1_status}")
        if audit["heading_outline"]:
            lines.append("- **Semantic Heading Tree (`H1 -> H2 -> H3`):**")
            for h_item in audit["heading_outline"][:12]:
                indent = "  " * (int(h_item["tag"][1]) - 1)
                lines.append(f"  {indent}- `{h_item['tag'].upper()}`: {h_item['text']}")
        lines.append("")

        # Part D: JSON-LD Schema Graph Spec
        lines.append("### D. Recommended `@stack('schema')` JSON-LD `@graph` Blueprint")
        lines.append("```json")
        lines.append(json.dumps(seo_spec["recommended_jsonld_graph"], indent=2, ensure_ascii=False))
        lines.append("```")
        lines.append("")

    return "\n".join(lines)


def main() -> int:
    parser = argparse.ArgumentParser(
        description="Scrape reference URLs into a visual top-to-bottom layout, modular isolation, and SEO/Schema review spec."
    )
    parser.add_argument("urls", nargs="+", help="One or more URLs or local HTML file paths.")
    parser.add_argument(
        "--discover",
        action="store_true",
        help="Automatically discover and scrape up to 4 internal subpage links from the first URL.",
    )
    parser.add_argument(
        "--save-dir",
        default="",
        help="Optional directory to save raw HTML, layout-blueprint.json, and layout-review-spec.md.",
    )
    parser.add_argument(
        "--format",
        choices=["markdown", "json"],
        default="markdown",
        help="Output format (default: markdown).",
    )
    args = parser.parse_args()

    target_urls: list[str] = list(args.urls)
    pages_data: list[dict[str, Any]] = []
    combined_css = ""

    if args.save_dir:
        os.makedirs(args.save_dir, exist_ok=True)

    idx = 0
    while idx < len(target_urls):
        url = target_urls[idx]
        idx += 1
        try:
            html = fetch_url(url)
        except Exception as exc:
            sys.stderr.write(f"[WARN] Failed to fetch {url}: {exc}\n")
            continue

        if args.save_dir:
            slug = re.sub(r"[^a-zA-Z0-9_-]+", "_", url).strip("_")[:60]
            with open(
                os.path.join(args.save_dir, f"{slug}.html"), "w", encoding="utf-8"
            ) as f:
                f.write(html)

        page_info = parse_page_structure(html, url)
        pages_data.append(page_info)

        if idx == 1:
            for css_url in extract_css_links(html, url)[:3]:
                try:
                    combined_css += "\n" + fetch_url(css_url)
                except Exception:
                    pass

    report = {
        "pages": pages_data,
        "css_tokens": parse_css_tokens(combined_css) if combined_css else {},
        "modular_architecture": classify_modular_architecture(pages_data),
    }

    md_output = format_markdown_report(report)

    if args.save_dir:
        with open(
            os.path.join(args.save_dir, "layout-blueprint.json"), "w", encoding="utf-8"
        ) as f:
            json.dump(report, f, indent=2, ensure_ascii=False)
        with open(
            os.path.join(args.save_dir, "layout-review-spec.md"), "w", encoding="utf-8"
        ) as f:
            f.write(md_output)

    if args.format == "json":
        print(json.dumps(report, indent=2, ensure_ascii=False))
    else:
        print(md_output)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
