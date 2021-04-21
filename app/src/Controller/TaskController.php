<?php

namespace App\Controller;

use App\Form\TaskFormType;
use App\Service\TaskService;
use App\Traits\ApiResponser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class TaskController extends AbstractController
{
    use ApiResponser;

    /**
     * @Route("/tasks", name="create_task", methods={"POST"})
     */
    public function create(Request $request, TaskService $taskService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $data['user'] = $this->getUser()->getId();

        $form = $this->createForm(TaskFormType::class);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $taskService->saveTask($task);
            return $this->successResponse($task, Response::HTTP_CREATED);
        }
        return $this->formErrorResponse($form);
    }

    /**
     * @Route("/tasks", name="list_tasks", methods={"GET"})
     */
    public function list(TaskService $taskService): JsonResponse
    {
        $tasks = $taskService->getUserTasks($this->getUser());
        return $this->successResponse($tasks, Response::HTTP_OK);
    }

    /**
     * @Route("/tasks/{id}", name="get_task", methods={"GET"})
     */
    public function view(TaskService $taskService, int $id): JsonResponse
    {
        $task = $taskService->getUserTask($id, $this->getUser());
        if (!$task) {
            return $this->errorMessage('task not found', Response::HTTP_NOT_FOUND);
        }
        return $this->successResponse($task, Response::HTTP_OK);
    }

    /**
     * @Route("/tasks/{id}", name="edit_task", methods={"PATCH"})
     */
    public function edit(Request $request, TaskService $taskService, int $id): JsonResponse
    {
        $task = $taskService->getUserTask($id, $this->getUser());
        if (!$task) {
            return $this->errorMessage('task not found', Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TaskFormType::class, $task, ['method' => 'PATCH']);
        $form->submit($data, false);
        if ($form->isSubmitted() && $form->isValid()) {
            $taskService->saveTask($task);
            return $this->successResponse($task, Response::HTTP_OK);
        }
        return $this->formErrorResponse($form);
    }
}
