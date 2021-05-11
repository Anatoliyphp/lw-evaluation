import { useAction, useAtom } from '@reatom/react';
import { useEffect } from 'react';
import { tasksAtom } from '../model/tasksAtom';
import { Link, useParams, useRouteMatch } from 'react-router-dom';
import classes from './TaskList.module.css';
import { getTaskListAction } from '../model/getTaskListAction';
import { fetchSpinnerVisibilityAtom } from '../../../common/Spinner/model/fetchSpinnerAtom';
import { Spinner } from '../../../common/Spinner/view/Spinner';

function TaskList() {
  const tasks = useAtom(tasksAtom);
  const match = useRouteMatch();
  const spinner = useAtom(fetchSpinnerVisibilityAtom);

  const params: { labId: string } = useParams();

  const getTaskList = useAction(getTaskListAction);

  useEffect(() => {
    getTaskList(params.labId);
  }, [getTaskList, params.labId]);

  const taskViews = tasks?.taskList.map((task) => (
    <li className={classes.TaskLinkElement} key={task.id}>
      <Link to={`${match.url}/task/${task.id}`}>
        Задание {task.title.substr(0, task.title.lastIndexOf('.'))}
      </Link>
    </li>
  ));

  return (
    <div className={classes.TaskList}>
      <h2 className={classes.LabTitle}>{tasks?.labWorkTitle}</h2>
      <ul className={classes.TaskLinks}>
        {spinner ? <Spinner type='fetch' /> : taskViews}
      </ul>
    </div>
  );
}

export { TaskList };
