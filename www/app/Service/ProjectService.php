<?php

declare(strict_types=1);

namespace app\Service;

use app\DTO\Arrayable;
use app\Repository\ProjectRepository;
use yii\data\ActiveDataProvider;

class ProjectService
{
    private ProjectRepository $repository;

    public function __construct(
        ProjectRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function search(Arrayable $params): ActiveDataProvider
    {
        return $this->repository->search($params);
    }
}