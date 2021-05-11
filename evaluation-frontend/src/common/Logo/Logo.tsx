import React, { useState } from 'react';
import classes from './Logo.module.css';
import { AuthenticationApi } from '../../api/authenticationApi';
import { Redirect } from 'react-router';

type LogoProps = {
  letters: string;
};

function Logo(props: LogoProps) {
  const [showMenu, setShowMenu] = useState(false);

  let userNameLetters = '';
  for (let i = 0; i < props.letters.length; i++) {
    userNameLetters += props.letters[i];
  }

  function clickHandler() {
    AuthenticationApi.logOut();
    window.location.href = '/login';
    return <Redirect to='/login' />;
  }

  return (
    <React.Fragment>
      <div className={classes.Logo} onClick={() => setShowMenu(!showMenu)}>
        <span>{userNameLetters}</span>
        <div
          className={`${classes.Menu} ${showMenu ? classes.Active : ''}`}
          onClick={clickHandler}
        >
          Log out
        </div>
      </div>
    </React.Fragment>
  );
}

export { Logo };
