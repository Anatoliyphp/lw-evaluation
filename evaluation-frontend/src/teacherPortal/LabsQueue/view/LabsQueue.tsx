import { useAtom } from '@reatom/react';
import { Link } from 'react-router-dom';
import { labsQueueAtom } from '../model/labsQueueAtom';
import classes from './LabsQueue.module.css';
import { parseDateDifference } from '../dateHelper';

function LabsQueue() {
  const labs = useAtom(labsQueueAtom);

  const labsQueueView = labs.map((course) => {
    return (
      <li key={course.courseName}>
        <h2 className={classes.CourseTitle}>Курс "{course.courseName}"</h2>
        <ul className={classes.GroupList}>
          {course.groups.map((group) => (
            <li key={group.groupName}>
              <h3 className={classes.GroupTitle}>Группа {group.groupName}</h3>
              <ul className={classes.LabList}>
                {group.labs.map((lab) => (
                  <li className={classes.LabListItem} key={lab.labId}>
                    <h4 className={classes.LabTitle}>
                      <Link to={`/teacher/checkLab/${lab.labId}`}>
                        ЛР #{lab.labId} {lab.labName}
                      </Link>
                    </h4>
                    <div className={classes.StudentName}>{lab.studentName}</div>
                    <div>{parseDateDifference(lab.date)}</div>
                  </li>
                ))}
              </ul>
            </li>
          ))}
        </ul>
      </li>
    );
  });

  return (
    <div className={classes.LabsQueue}>
      <ul className={classes.CourseList}>{labsQueueView}</ul>
    </div>
  );
}

export { LabsQueue };
