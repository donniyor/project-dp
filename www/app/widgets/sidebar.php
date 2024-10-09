<?php

namespace app\widgets;

use app\models\Users;
use Yii;

class sidebar
{
    private array $row = [];
    private string $controller;
    private string $role;

    public function __construct()
    {
        $this->controller = Yii::$app->controller->id;
        $this->role = Users::getRole();
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
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
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

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public static function make(): static
    {
        return new static();
    }

    public function add(string $name, string $icon, string $url, array $roles = [], string $link = ''): self
    {
        if (!empty($roles) && !in_array($this->role, $roles)) {
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