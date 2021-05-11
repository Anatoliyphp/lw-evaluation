import { useAtom } from '@reatom/react';
import React from 'react';
import { fetchSpinnerVisibilityAtom } from '../../../../common/Spinner/model/fetchSpinnerAtom';
import { Spinner } from '../../../../common/Spinner/view/Spinner';
import { tasksDescriptionAtom } from '../../model/tasksDescriptionAtom';
import classes from './TaskDescription.module.css';

function TaskDescription() {
  const tasksDescription = useAtom(tasksDescriptionAtom);
  const spinner = useAtom(fetchSpinnerVisibilityAtom);

  let taskTitle = tasksDescription?.taskTitle.substr(
    0,
    tasksDescription?.taskTitle.lastIndexOf('.')
  );

  return (
    <div className={classes.TaskDescription}>
      {spinner ? (
        <Spinner />
      ) : (
        <React.Fragment>
          <h2 className={classes.TaskTitle}>Задание {taskTitle}</h2>
          <h3 className={classes.TaskName}>Какая-то программа</h3>
          <p className={classes.TaskDescription}>
            {tasksDescription?.taskDescription}
          </p>
        </React.Fragment>
      )}
    </div>
  );
}

export { TaskDescription };
