import { useEffect } from 'react';

import classes from './Task.module.css';
import { TaskDescription } from './TaskDescription/TaskDescription';
import { NocompileFiles } from './NocompileFiles/NocompileFiles';
import { getTaskStateAction } from '../model/getTaskStateAction';
import { useAction } from '@reatom/react';
import { useParams } from 'react-router';

function Task() {
  const getTaskState = useAction(getTaskStateAction);
  const params: { taskId: string } = useParams();

  useEffect(() => {
    getTaskState(params.taskId);
  }, [getTaskState, params.taskId]);

  return (
    <div className={classes.Task}>
      <TaskDescription />
      <NocompileFiles />
    </div>
  );
}

export { Task };
