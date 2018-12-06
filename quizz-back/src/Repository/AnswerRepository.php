<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public function findCorrectByQuestionId($id)
    {
      $connection = $this->getEntityManager()
        ->getConnection();

      $sql =
        'SELECT answer.id
          FROM answer
          WHERE question_id = :id
          AND correct = 1
        ';

      $query = $connection->prepare($sql);
      $query->execute([':id' => $id]);
      return $query->fetchAll();
    }

}
