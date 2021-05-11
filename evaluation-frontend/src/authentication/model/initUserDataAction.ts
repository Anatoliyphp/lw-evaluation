import { setUserDataAction } from './userAtom';
import { declareAction } from '@reatom/core';
import { AuthenticationApi } from '../../api/authenticationApi';
import {
  closeAuthSpinnerAction,
  showAuthSpinnerAction,
} from '../../common/Spinner/model/authSpinnerAtom';
import { setUserInitialized } from './isUserDataInitializedAtom';

const initUserDataAction = declareAction((_, { dispatch }) => {
  dispatch(showAuthSpinnerAction());
  AuthenticationApi.getUserData()
    .then((data) => {
      if (data.code) {
        // пользователь не найден
      } else {
        dispatch(setUserDataAction({ ...data, isAuthUser: true }));
      }
      dispatch(setUserInitialized());
    })
    .finally(() => dispatch(closeAuthSpinnerAction()));
});

export { initUserDataAction };
