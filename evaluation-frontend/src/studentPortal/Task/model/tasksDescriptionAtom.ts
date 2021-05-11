import { declareAtom, declareAction } from '@reatom/core';
import { TaskDescriptionData } from './ApiTaskDescriptionData';

const setTaskDescriptionAction = declareAction<TaskDescriptionData>();

const tasksDescriptionAtom = declareAtom<TaskDescriptionData | null>(
  null,
  (on) => [
    on(setTaskDescriptionAction, (_, taskDescription) => taskDescription),
  ]
);

export { setTaskDescriptionAction, tasksDescriptionAtom };
