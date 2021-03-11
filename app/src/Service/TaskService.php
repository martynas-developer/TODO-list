<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveTask(Task $task): Task
    {
        $this->em->persist($task);
        $this->em->flush();
        return $task;
    }

    public function getUserTask(int $id, User $user): ?Task
    {
        return $this->em->getRepository(Task::class)->findOneBy(['id' => $id, 'user' => $user]);
    }

    public function getUserTasks(User $user): array
    {
        return $this->em->getRepository(Task::class)->findBy(['user' => $user]);
    }
}