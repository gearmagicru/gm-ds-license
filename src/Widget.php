<?php
/**
 * Виджет информационной панели (Dashboard).
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Dashboard\License;

use Gm;
use Gm\Helper\Html;
use Gm\Panel\Helper\Ext;

/**
 * Виджет информационной панели "Лицензия".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Dashboard\License
 * @since 1.0
 */
class Widget extends \Gm\Panel\Widget\DashboardWidget
{
    /**
     * {@inheritdoc}
     */
    public bool $useToolRefresh = false;

    /**
     * {@inheritdoc}
     */
    public bool $useToolSettings = false;

    /**
     * {@inheritdoc}
     */
    public array $css = ['/widget.css'];

    /**
     * {@inheritdoc}
     */
    protected string $id = 'gm.ds.license';

    /**
     * {@inheritdoc}
     */
    protected string $contentType = 'html';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this->title = $this->t('License key');
        $this->color = 'yellow';
        $this->headerNoColor = true;
        $this->autoHeight = true;
        $this->cls = 'gm-widget-license';
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        /** @var \Gm\License\License $license */
        $license = Gm::$app->license;
        /** @var string|null Лицензионный ключ */
        $key = $license->getKey();
        $html = [];
        $html[] = Html::tag('h2', $this->t('Key: "{0}"', [$key ?: '0000-0000-000-000']), ['class' => 'gm-widget-license__key']);
        if (empty($key)) {
            $html[] = Html::tag('div', 
                $this->t('The key is not installed. You cannot fully use all the functionality of your web application components.'), 
                ['class' => 'gm-widget-license__msg-warning']
            );
            $html[] = Html::tag('div',
                Html::button(
                    $this->t('Activate'), 
                    ['onclick' => Ext::jsAppWidgetLoad('@backend/config/license')]
                ),
                ['style' => 'text-align:right']
            );
        } else {
            $html[] = Html::tag('div', 
                [
                    $this->t('The key has been activated') . ', ',
                    Html::a($this->t('read more'), '#', 
                        ['onclick' => Ext::jsAppWidgetLoad('@backend/config/license')]
                    ) . '.'
                ], 
                ['class' => 'gm-widget-license__msg']
            );
        }
        
        return Html::tags($html);
    }
}