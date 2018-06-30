<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class TourController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function getData(Request $request)
    {
        preg_match('`.*?((http|https)://[\w#$&+,\/:;=?@.-]+)[^\w#$&+,\/:;=?@.-]*?`i', $request->data, $url);
        preg_match_all('/\b(?:class|id)=[\'"].*?[\'"]/isu', $request->data, $match);

        $selector = implode(' ', $match[0]);
        $selector = str_replace(['class=', 'id=', '"', '\''], ['.', '#', '', ''], $selector);

        $html = file_get_contents($url[1]);
        $crawler = new Crawler(null, $url[1]);
        $crawler->addHtmlContent($html, 'UTF-8');
        $result = $crawler->filter($selector)->each(function (Crawler $node, $i) {
            return strip_tags($node->html(), '<p><h1><h2><h3><h4><h5><table><thead><th><tbody><tr>');
        });

        return $result;
    }
}
