<?php

namespace App\Controller;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Enrollment\Api\EnrollmentQueryServiceInterface;
use App\Evaluation\Api\EvaluationQueryServiceInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Model\User;
use Exception;

class EvaluationController extends AbstractController
{
    /**
     * @Route("/api/task/state", methods={"GET"}, name="getTaskState")
     * @param EnrollmentQueryServiceInterface $enrollmentService
     * @param EvaluationQueryServiceInterface $evaluationQueryService
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function getTaskState(
        EnrollmentQueryServiceInterface $enrollmentService,
        EvaluationQueryServiceInterface $evaluationQueryService,
        Request $request
    ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $taskId = $request->query->get('taskId');

        if (!$taskId) {
            throw new BadRequestHttpException();
        }

        $isAvailable = $enrollmentService->isTaskAvailableToUser($userId, $taskId);
        if (!$isAvailable) {
            throw new AccessDeniedHttpException();
        }

        try {
            $taskState = $evaluationQueryService->getTaskState($userId, $taskId);
            return $this->json($taskState);
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException();
        }
    }
}
