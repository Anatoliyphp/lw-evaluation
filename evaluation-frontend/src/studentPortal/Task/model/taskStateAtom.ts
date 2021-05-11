import { declareAtom, declareAction } from '@reatom/core';
import { TaskStateData } from './TaskStateData';

const setTaskStateAction = declareAction<TaskStateData>();

const taskStateAtom = declareAtom<TaskStateData | null>(null, (on) => [
  on(setTaskStateAction, (_, taskState) => taskState),
]);

export { taskStateAtom, setTaskStateAction };
