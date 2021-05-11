import React from 'react';
import { Redirect, Route, Switch, useRouteMatch } from 'react-router-dom';

import { Header } from '../common/Header/Header';
import { SideBar } from '../common/SideBar/SideBar';
import { CourseList } from './CourseList/view/CourseList';
import { LabList } from './LabList/view/LabList';
import { TaskList } from './TaskList/view/TaskList';
import { Task } from './Task/view/Task';

function StudentLayout() {
  const { path } = useRouteMatch();

  return (
    <React.Fragment>
      <Header title='Мои курсы' />
      <SideBar />
      <Switch>
        <Route exact path='/student'>
          <Redirect to='/student/courses' />
        </Route>
        <Route exact path={`${path}/courses`}>
          <CourseList />
        </Route>
        <Route exact path={`${path}/courses/:courseId`}>
          <LabList />
        </Route>
        <Route exact path={`${path}/courses/:courseId/lab/:labId`}>
          <TaskList />
        </Route>
        <Route path={`${path}/courses/:courseId/lab/:labId/task/:taskId`}>
          <Task />
        </Route>
      </Switch>
    </React.Fragment>
  );
}

export { StudentLayout };
