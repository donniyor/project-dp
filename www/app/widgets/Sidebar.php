<?php

declare(strict_types=1);

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Sidebar
{
    private array $row = [];
    private string $controller;

    public function __construct()
    {
        $this->controller = Yii::$app->controller->getUniqueId();
    }

    public function setRow(string $row): void
    {
        $this->row[] = $row;
    }

    public static function make(): static
    {
        return new static();
    }

    public function getRow(): array
    {
        return $this->row;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function add(string $name, string $icon, string $url): self
    {
        if (!empty($roles)) {
            return $this;
        }

        $this->setRow(
            Html::tag(
                'li',
                Html::a(
                    sprintf(
                        '%s%s',
                        Html::tag(
                            'i',
                            $icon,
                            [
                                'class' => sprintf(
                                    'material-icons %s',
                                    $this->getController() === $url ? 'active' : ''
                                )
                            ]
                        ),
                        $name
                    ),
                    Url::to(sprintf('/%s', $url))
                ),
                ['class' => $this->getController() === $url ? 'active-page' : '']
            )
        );

        return $this;
    }

    public function all(): string
    {
        return implode("", $this->getRow());
    }
}