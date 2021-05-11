import React, { useState } from 'react';
import { useAction, useAtom } from '@reatom/react';

import { loginAction } from '../model/loginAction';
import classes from './Login.module.css';
import { userAtom } from '../model/userAtom';
import { Redirect } from 'react-router-dom';
import { authSpinnerVisibilityAtom } from '../../common/Spinner/model/authSpinnerAtom';
import { Spinner } from '../../common/Spinner/view/Spinner';

function Login() {
  const spinner = useAtom(authSpinnerVisibilityAtom);

  const [login, setLogin] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const handleLogin = useAction(loginAction);
  const user = useAtom(userAtom);

  function submitForm(e: React.MouseEvent) {
    e.preventDefault();
    if (login === '' || password === '') {
      setError('Fields are required');
      return;
    }
    handleLogin({ login, password });
  }

  if (user.isAuthUser && user.role === 'student') {
    return <Redirect to='/student/courses' />;
  } else if (user.isAuthUser && user.role === 'teacher') {
    return <Redirect to='/teacher/labsQueue' />;
  }

  return (
    <div className={classes.LoginWrapper}>
      {spinner ? (
        <Spinner type='auth' />
      ) : (
        <div className={classes.Login}>
          <h2 className={classes.Title}>LOG IN</h2>
          <form className={classes.Form}>
            <input
              className={classes.Input}
              value={login}
              type='text'
              placeholder='Login'
              onChange={(e) => setLogin(e.target.value)}
            />
            <input
              className={classes.Input}
              value={password}
              type='password'
              placeholder='Password'
              onChange={(e) => setPassword(e.target.value)}
            />
            <button className={classes.LoginBtn} onClick={submitForm}>
              Log in
            </button>

            {error && (
              <div className={classes.Error} onClick={() => setError('')}>
                {error}
              </div>
            )}
          </form>
        </div>
      )}
    </div>
  );
}

export { Login };
