<?php

declare(strict_types=1);

namespace app\Repository;

use app\DTO\ProjectCreateDTO;
use app\DTO\ProjectUpdateDTO;
use app\models\Projects;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;

class ProjectRepository extends BaseEntityRepository
{
    protected function getEntity(): Projects
    {
        return new Projects();
    }

    public function search(
        ?int $status = null,
        ?array $authors = null,
    ): ActiveDataProvider {
        $query = $this
            ->getEntity()
            ->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($status !== null) {
            $query->andFilterWhere([
                'projects.status' => $status,
            ]);
        }

        if ($authors !== null) {
            $query->andWhere([
                'in',
                'projects.author_id',
                $authors,
            ])->joinWith('author');
        }

        return $dataProvider;
    }

    /**
     * @throws Exception
     */
    public function create(ProjectCreateDTO $project, $authorId): Projects
    {
        $model = $this
            ->getEntity()
            ->setTitle($project->getTitle())
            ->setDescription($project->getDescription())
            ->setStatus($project->getStatus())
            ->setAuthorId($authorId);

        $model->save();

        return $model;
    }

    public function findById(int $id): ?Projects
    {
        return $this
            ->getEntity()
            ->findOne(['id' => $id]);
    }

    public function findBy(int $limit = 10): array
    {
        return $this
            ->getEntity()
            ->find()
            ->limit($limit)
            ->all();
    }

    public function findByIds(int ...$ids): array
    {
        return $this
            ->getEntity()
            ->find()
            ->where(['in', 'id', $ids])
            ->all();
    }

    public function searchByTitle(string $title, int $limit = 10): array
    {
        return $this
            ->getEntity()
            ->find()
            ->select(['id', 'title'])
            ->where(['like', 'LOWER(title)', strtolower($title)])
            ->limit($limit)
            ->all();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function updateOne(Projects $project, ProjectUpdateDTO $projectDTO): Projects
    {
        $project
            ->setTitle($projectDTO->title)
            ->setDescription($projectDTO->description)
            ->setStatus($projectDTO->status);

        $project->save();

        return $project;
    }
}