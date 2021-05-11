import { declareAtom, declareAction } from '@reatom/core';
import { CourseData } from './ApiCourseListItemData';

const setCourseListAction = declareAction<Array<CourseData>>();

const coursesAtom = declareAtom<Array<CourseData>>([], (on) => [
  on(setCourseListAction, (_, courseList) => [...courseList]),
]);

export { setCourseListAction, coursesAtom };
