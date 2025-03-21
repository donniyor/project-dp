<?php

declare(strict_types=1);

namespace app\Service;

use app\Decorator\ProjectDecorator;
use app\models\Projects;
use app\Repository\ProjectRepository;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class ProjectService
{
    private ProjectRepository $repository;
    private ProjectDecorator $decorator;

    public function __construct(
        ProjectRepository $repository,
        ProjectDecorator $decorator,
    ) {
        $this->repository = $repository;
        $this->decorator = $decorator;
    }

    public function search(
        ?int $status = null,
        ?array $authors = null,
    ): ActiveDataProvider {
        return $this->repository->search($status, $authors);
    }

    /**
     * @throws Exception
     */
    public function create(
        string $title,
        string $description,
        int $status,
        int $authorId,
    ): Projects {
        return $this->repository->create(
            $title,
            $description,
            $status,
            $authorId,
        );
    }

    public function findById(int $id): ?Projects
    {
        return $this->repository->findById($id);
    }

    public function findBy(int $limit = 10): array
    {
        return $this->repository->findBy($limit);
    }

    public function searchByTitle(string $title, int $limit = 10): array
    {
        return $this->repository->searchByTitle($title, $limit);
    }

    public function processProjects(array $projects): array
    {
        $result = [];
        /** @var Projects $project */
        foreach ($projects as $project) {
            $result[] = $this->decorator->getFormattedData($project);
        }

        return $result;
    }

    public function updateOne(
        string $title,
        string $description,
        int $status,
    ): Projects {
        return $this->repository->updateOne(
            $title,
            $description,
            $status,
        );
    }
}