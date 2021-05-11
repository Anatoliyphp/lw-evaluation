import React, { useEffect } from 'react';
import { useAction, useAtom } from '@reatom/react';

import { Route, Switch } from 'react-router-dom';
import { Login } from './authentication/view/Login';
import { StudentLayout } from './studentPortal/StudentLayout';
import { TeacherLayout } from './teacherPortal/TeacherLayout';
import { AuthRouter } from './authentication/AuthRouter';
import { Spinner } from './common/Spinner/view/Spinner';
import { initUserDataAction } from './authentication/model/initUserDataAction';
import { authSpinnerVisibilityAtom } from './common/Spinner/model/authSpinnerAtom';
import { isUserDataInitializedAtom } from './authentication/model/isUserDataInitializedAtom';

function App() {
  const spinner = useAtom(authSpinnerVisibilityAtom);
  const initUserData = useAction(initUserDataAction);
  const isUserDataChecked = useAtom(isUserDataInitializedAtom);

  useEffect(() => {
    initUserData();
  }, [initUserData]);

  return (
    <React.Fragment>
      {spinner || !isUserDataChecked ? (
        <Spinner type='auth' />
      ) : (
        <Switch>
          <AuthRouter
            path='/student'
            role='student'
            component={StudentLayout}
          />
          <AuthRouter
            path='/teacher'
            role='teacher'
            component={TeacherLayout}
          />
          <Route path='/' component={Login} />
        </Switch>
      )}
    </React.Fragment>
  );
}

export default App;
