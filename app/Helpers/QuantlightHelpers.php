<?php

if (!function_exists('quantlight_fragment')) {
    /**
     * Get processed header or footer HTML for Quantlight theme (for Blade layout).
     */
    function quantlight_fragment(string $name): string
    {
        $file = $name === 'header' ? 'header.html' : 'footer.html';
        $path = public_path('quantlight/' . $file);

        if (!file_exists($path)) {
            return '';
        }

        $content = file_get_contents($path);
        $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
        $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
        $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
        $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
        $content = str_replace('href="index.html"', 'href="/"', $content);
        $content = str_replace('href="about.html"', 'href="/about"', $content);
        $content = str_replace('href="contact.html"', 'href="/contact"', $content);
        $content = str_replace('href="researches-capabilities.html"', 'href="/researches-capabilities"', $content);
        $content = str_replace('href="citations.html"', 'href="/citations"', $content);
        $content = str_replace('href="gallery.html"', 'href="/gallery"', $content);
        $content = str_replace('href="blog.html"', 'href="/updates"', $content);
        $content = str_replace('href="news.html"', 'href="/updates"', $content);
        $content = str_replace('<li><a href="contact.html">Contact</a></li>', '<li><a href="/contact">Contact</a></li>', $content);
        $content = str_replace('href="index.html#capabilities"', 'href="/#capabilities"', $content);

        return $content;
    }
}
