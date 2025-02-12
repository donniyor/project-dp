<?php

declare(strict_types=1);

namespace app\Repository;

use app\models\Projects;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class ProjectRepository extends BaseEntityRepository
{
    public function getEntity(): Projects
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
    public function create(
        string $title,
        string $description,
        int $status,
        int $authorId,
    ): Projects {
        $model = $this
            ->getEntity()
            ->setTitle($title)
            ->setDescription($description)
            ->setStatus($status)
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
}