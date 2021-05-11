import { LabData } from '../studentPortal/LabList/model/ApiLabListItemData';
import { TaskData } from './../studentPortal/TaskList/model/ApiTaskListItemData';
import { CourseData } from './../studentPortal/CourseList/model/ApiCourseListItemData';
import { ActionData } from '../studentPortal/Task/model/TaskStateData';
import { getToken } from './authenticationApi';

const API_BASE_URL = 'http://localhost/api';

type GetLabListResponseData = {
  courseTitle: string;
  courseDescription: string;
  labList: LabData[];
};

type GetTaskListResponseData = {
  labWorkTitle: string;
  taskList: Array<TaskData>;
};

type GetTaskStateResponseData = {
  taskTitle: string;
  taskDescription: string;
  lastActionId: string;
  actions: Array<ActionData>;
};

function getCourseList(): Promise<Array<CourseData>> {
  return fetch(`${API_BASE_URL}/enrolled_courses`, {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${getToken()}`,
    },
  }).then((resp) => {
    if (resp.status === 401) {
      // TODO
    }
    return resp.json();
  });
}

function getLabList(courseId: string): Promise<GetLabListResponseData> {
  return fetch(`${API_BASE_URL}/available_lab_works?course_id=${courseId}`, {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${getToken()}`,
    },
  }).then((resp) => {
    if (resp.status === 401) {
      // TODO
    }
    return resp.json();
  });
}

function getTaskList(labWorkId: string): Promise<GetTaskListResponseData> {
  return fetch(`${API_BASE_URL}/available_tasks?labWork_id=${labWorkId}`, {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${getToken()}`,
    },
  }).then((resp) => {
    if (resp.status === 401) {
      // TODO
    }
    return resp.json();
  });
}

function getTaskState(taskId: string): Promise<GetTaskStateResponseData> {
  return fetch(`${API_BASE_URL}/task/state?taskId=${taskId}`, {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${getToken()}`,
    },
  }).then((resp) => {
    if (resp.status === 401) {
      // TODO
    }
    return resp.json();
  });
}

const StudentApi = {
  getCourseList,
  getLabList,
  getTaskList,
  getTaskState,
};

export { StudentApi };
