import { useEffect } from 'react';

import classes from './CourseList.module.css';
import { Course } from './Course/Course';
import { useAction, useAtom } from '@reatom/react';
import { coursesAtom } from '../model/coursesAtom';

import { getCourseListAction } from '../model/getCourseListAction';
import { fetchSpinnerVisibilityAtom } from '../../../common/Spinner/model/fetchSpinnerAtom';
import { Spinner } from '../../../common/Spinner/view/Spinner';

function CourseList() {
  const courses = useAtom(coursesAtom);
  const spinner = useAtom(fetchSpinnerVisibilityAtom);

  const getCourseList = useAction(getCourseListAction);

  useEffect(() => {
    getCourseList();
  }, [getCourseList]);

  const courseViews = courses.map((course) => (
    <Course
      key={course.id}
      courseId={course.id}
      courseTitle={course.name}
      courseDescription={course.description}
    />
  ));

  return (
    <div className={classes.CourseList}>
      {spinner ? <Spinner /> : courseViews}
    </div>
  );
}

export { CourseList };
