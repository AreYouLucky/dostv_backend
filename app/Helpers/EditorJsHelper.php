<?php

namespace App\Helpers;

class EditorJsHelper
{
    public static function toHtml($editorJson)
    {
        if (is_string($editorJson)) {
            $editorJson = json_decode($editorJson, true);
        }

        if (!isset($editorJson['blocks']) || !is_array($editorJson['blocks'])) {
            return '';
        }

        $html = '';

        foreach ($editorJson['blocks'] as $block) {
            $type = $block['type'] ?? '';
            $data = $block['data'] ?? [];

            switch ($type) {
                case 'paragraph':
                    $text = $data['text'] ?? '';
                    $html .= "<p>{$text}</p>";
                    break;

                case 'header':
                    $level = $data['level'] ?? 2;
                    $text = $data['text'] ?? '';
                    $html .= "<h{$level}>{$text}</h{$level}>";
                    break;

                case 'list':
                    $style = $data['style'] ?? 'unordered';
                    $items = $data['items'] ?? [];
                    $tag = $style === 'ordered' ? 'ol' : 'ul';
                    $html .= "<{$tag}>";
                    foreach ($items as $item) {
                        // Support nested text or sublists
                        if (is_array($item)) {
                            $html .= "<li>" . ($item['content'] ?? '') . "</li>";
                        } else {
                            $html .= "<li>{$item}</li>";
                        }
                    }
                    $html .= "</{$tag}>";
                    break;

                case 'quote':
                    $text = $data['text'] ?? '';
                    $caption = $data['caption'] ?? '';
                    $html .= "<blockquote>{$text}";
                    if (!empty($caption)) {
                        $html .= "<cite>{$caption}</cite>";
                    }
                    $html .= "</blockquote>";
                    break;

                case 'image':
                    $url = $data['file']['url'] ?? '';
                    $caption = $data['caption'] ?? '';
                    $withBorder = !empty($data['withBorder']) ? 'bordered' : '';
                    $withBackground = !empty($data['withBackground']) ? 'backgrounded' : '';
                    $withStretch = !empty($data['stretched']) ? 'stretched' : '';
                    $classes = trim("editor-image {$withBorder} {$withBackground} {$withStretch}");
                    $html .= "<figure class=\"{$classes}\"><img src=\"{$url}\" alt=\"\"><figcaption>{$caption}</figcaption></figure>";
                    break;

                case 'embed':
                    $embed = $data['embed'] ?? '';
                    $caption = $data['caption'] ?? '';
                    $width = $data['width'] ?? '100%';
                    $height = $data['height'] ?? '400';
                    $html .= "<div class=\"embed\"><iframe src=\"{$embed}\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" allowfullscreen></iframe>";
                    if ($caption) {
                        $html .= "<p class=\"caption\">{$caption}</p>";
                    }
                    $html .= "</div>";
                    break;

                case 'code':
                    $code = htmlspecialchars($data['code'] ?? '');
                    $html .= "<pre><code>{$code}</code></pre>";
                    break;

                case 'delimiter':
                    $html .= "<hr class=\"editor-delimiter\" />";
                    break;

                case 'table':
                    $content = $data['content'] ?? [];
                    $html .= "<table class=\"editor-table\">";
                    foreach ($content as $row) {
                        $html .= "<tr>";
                        foreach ($row as $cell) {
                            $html .= "<td>{$cell}</td>";
                        }
                        $html .= "</tr>";
                    }
                    $html .= "</table>";
                    break;

                default:
                    // For unrecognized block types
                    $html .= "<div class=\"unknown-block\">" . json_encode($data) . "</div>";
                    break;
            }
        }

        return $html;
    }
}
