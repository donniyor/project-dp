<?php

namespace app\widgets;

use Yii;

class Sidebar
{
    private array $row = [];
    private string $controller;

    public function __construct()
    {
        $this->controller = Yii::$app->controller->id;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return array
     */
    public function getRow(): array
    {
        return $this->row;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param array $row
     */
    public function setRow(array $row): void
    {
        $this->row = $row;
    }

    public static function make(): static
    {
        return new static();
    }

    public function add(string $name, string $icon, string $url, string $link = ''): self
    {
        if (!empty($roles)) {
            return $this;
        }

        $check = $this->controller === $url ? 'class="active-page"' : '';
        $check2 = $this->controller === $url ? 'class="active"' : '';
        $link = $link === '' ? $url : $link;
        $this->row[] = "<li $check>
                    <a href=\"/$link\" >
                        <i class=\"material-icons\" $check2>$icon</i> $name
                    </a>
                </li>";

        return $this;
    }

    public function all(): string
    {
        return implode("", $this->row);
    }
}