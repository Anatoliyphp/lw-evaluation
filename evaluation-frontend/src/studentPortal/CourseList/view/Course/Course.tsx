import { Link, useRouteMatch } from 'react-router-dom';

import classes from './Course.module.css';

type CoursePropsData = {
  courseId: string;
  courseTitle: string;
  courseDescription: string;
};

function Course(props: CoursePropsData) {
  const match = useRouteMatch();

  return (
    <div className={classes.Course}>
      <h3 className={classes.CourseTitle}>{props.courseTitle}</h3>
      <p className={classes.CourseDescription}>{props.courseDescription}</p>
      <Link
        to={{
          pathname: `${match.path}/${props.courseId}`,
          state: {
            courseTitle: props.courseTitle,
            courseDescription: props.courseDescription,
          },
        }}
        className={classes.StartButton}
      >
        Приступить
      </Link>
    </div>
  );
}

export { Course };
