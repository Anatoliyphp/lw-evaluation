<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Enrollment\Api\EnrollmentQueryServiceInterface;
use App\Course\Api\CourseQueryServiceInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Model\User;

class CourseController extends AbstractController
{
    /**
     * @Route("/api/enrolled_courses", methods={"GET"}, name="getEnrolledCourses")
     * @param EnrollmentQueryServiceInterface $enrollmentService
     * @return Response
     */
    public function getEnrolledCourses(EnrollmentQueryServiceInterface $enrollmentService): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $courses = $enrollmentService->listCoursesDataByUserId($userId);
        $result = [];
        foreach ($courses as $course) {
            $result[] = [
                'id' => $course['course_id'],
                'name' => $course['title'],
                'description' => $course['description']
            ];
        }
        return $this->json($result);
    }

    /**
     * @Route("/api/available_lab_works", methods={"GET"}, name="getAvailableLabWorks")
     * @param EnrollmentQueryServiceInterface $enrollmentService
     * @param Request $request
     * @return Response
     * @throws BadRequestHttpException
     */
    public function getAvailableLabWorks(EnrollmentQueryServiceInterface $enrollmentService, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();
        $courseId = $request->query->get('course_id');
        if (!$courseId) {
            throw new BadRequestHttpException();
        }
        $labWorks = $enrollmentService->listLabWorksData($userId, $courseId);
        $result = [];
        if ($labWorks) {
            $result = [
                'courseTitle' => $labWorks[0]['courseTitle'],
                'courseDescription' => $labWorks[0]['courseDescription']
            ];
            foreach ($labWorks as $lw) {
                $result['labList'][] = [
                    'id' => $lw['id'],
                    'name' => $lw['title'],
                    'maxScore' => (int) $lw['maxScore']
                ];
            }
        }
        return $this->json($result);
    }

    /**
     * @Route("api/available_tasks", methods={"GET"}, name="getAvailableTasks")
     * @param CourseQueryServiceInterface $courseService
     * @param Request $request
     * @return Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function getAvailableTasks(CourseQueryServiceInterface $courseService, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userId = $user->getId();
        $labWorkId = $request->query->get('labWork_id');
        if (!$labWorkId) {
            throw new BadRequestHttpException();
        }
        $tasks = $courseService->listTasks($userId, $labWorkId);
        $labWorkTitle = $courseService->getLabWorkTitle($labWorkId);
        if ($labWorkTitle === null) {
            throw new NotFoundHttpException();
        }
        $result = [
            'labWorkTitle' => $labWorkTitle
        ];
        $result['taskList'] = [];
        foreach ($tasks as $task) {
            $result['taskList'][] =
                [
                    'id' => $task['id'],
                    'title' => $task['title'],
                    'maxScore' => $task['max_score']
                ];
        }
        return $this->json($result);
    }
}