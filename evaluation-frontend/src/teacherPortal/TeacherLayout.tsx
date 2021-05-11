import React from 'react';
import { Route, Switch, useRouteMatch } from 'react-router-dom';

import { Header } from '../common/Header/Header';
import { SideBar } from '../common/SideBar/SideBar';
import { LabsQueue } from './LabsQueue/view/LabsQueue';
import { CheckLab } from './ChechkLab/view/CheckLab';

function TeacherLayout() {
  let { path } = useRouteMatch();

  return (
    <React.Fragment>
      <Header title='Работы на проверку' />
      <SideBar />
      <Switch>
        <Route exact path={`${path}/labsQueue`}>
          <LabsQueue />
        </Route>
        <Route exact path={`${path}/checkLab/:labId`}>
          <CheckLab />
        </Route>
      </Switch>
    </React.Fragment>
  );
}

export { TeacherLayout };
