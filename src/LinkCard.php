<?php

namespace App\Services;

/**
 * 渲染链接卡片
 * 负责将给定的 URL 和关键词转换为安全的 HTML 片段
 */
class LinkCard
{
    /**
     * 默认配置
     *
     * @var array
     */
    private static array $defaultConfig = [
        'url'     => 'https://ty-le-yu.com.cn',
        'keyword' => '乐鱼体育',
        'title'   => '乐鱼体育 - 精彩体育赛事',
        'description' => '乐鱼体育提供丰富的体育赛事直播与资讯，涵盖足球、篮球、网球等多种热门运动。',
        'image'   => '',
    ];

    /**
     * 渲染卡片
     *
     * @param array $config 可覆盖默认配置
     * @return string 转义后的 HTML 片段
     */
    public static function render(array $config = []): string
    {
        $merged = array_merge(self::$defaultConfig, $config);

        // 安全转义所有输出字段
        $escapedUrl         = htmlspecialchars($merged['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedKeyword     = htmlspecialchars($merged['keyword'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle       = htmlspecialchars($merged['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDescription = htmlspecialchars($merged['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedImage       = htmlspecialchars($merged['image'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 构建图片占位
        $imageHtml = '';
        if ($escapedImage !== '') {
            $imageHtml = sprintf(
                '<img src="%s" alt="%s" class="link-card-image" />',
                $escapedImage,
                $escapedKeyword
            );
        }

        // 构建卡片 HTML
        $html = sprintf(
            '<div class="link-card">' .
            '<a href="%s" target="_blank" rel="noopener noreferrer" class="link-card-link">' .
            '<div class="link-card-content">' .
            '<span class="link-card-keyword">%s</span>' .
            '<h3 class="link-card-title">%s</h3>' .
            '<p class="link-card-description">%s</p>' .
            '</div>' .
            '%s' .
            '</a>' .
            '</div>',
            $escapedUrl,
            $escapedKeyword,
            $escapedTitle,
            $escapedDescription,
            $imageHtml
        );

        return $html;
    }

    /**
     * 快速生成预定义卡片
     *
     * @param string $variant 变体名称，用于调整样式或数据
     * @return string
     */
    public static function quickCard(string $variant = 'default'): string
    {
        $config = self::$defaultConfig;

        switch ($variant) {
            case 'sports':
                $config['title']       = '乐鱼体育 - 足球专区';
                $config['description'] = '关注乐鱼体育足球专区，获取最新赛事比分与深度分析。';
                break;

            case 'basketball':
                $config['title']       = '乐鱼体育 - 篮球专区';
                $config['description'] = '乐鱼体育篮球专区，NBA、CBA精彩不断。';
                break;

            case 'esports':
                $config['title']       = '乐鱼体育 - 电竞专区';
                $config['description'] = '乐鱼体育电竞专区，英雄联盟、DOTA2等热门赛事。';
                break;

            default:
                // 保持默认
                break;
        }

        return self::render($config);
    }

    /**
     * 返回默认配置
     *
     * @return array
     */
    public static function getDefaultConfig(): array
    {
        return self::$defaultConfig;
    }
}