import { declareAction } from '@reatom/core';
import { AuthenticationApi } from '../../api/authenticationApi';
import { setUserUnitialized } from './isUserDataInitializedAtom';

const logoutAction = declareAction((payload, { dispatch }) => {
  AuthenticationApi.logOut()
    .then((resp) => {
      console.log(resp);
      dispatch(setUserUnitialized());
    })
    .catch((err) => console.log(err));
});

export { logoutAction };
