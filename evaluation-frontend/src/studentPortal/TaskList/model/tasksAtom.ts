import { declareAtom, declareAction } from '@reatom/core';
import { TaskData } from './ApiTaskListItemData';

type GetTaskListResponseData = {
  labWorkTitle: string;
  taskList: Array<TaskData>;
};

const setTaskListAction = declareAction<GetTaskListResponseData>();

const tasksAtom = declareAtom<GetTaskListResponseData | null>(null, (on) => [
  on(setTaskListAction, (_, taskList) => taskList),
]);

export { setTaskListAction, tasksAtom };
