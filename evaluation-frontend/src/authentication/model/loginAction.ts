import { declareAction } from '@reatom/core';
import { AuthenticationApi } from '../../api/authenticationApi';
import { initUserDataAction } from './initUserDataAction';
import {
  closeAuthSpinnerAction,
  showAuthSpinnerAction,
} from '../../common/Spinner/model/authSpinnerAtom';

type LoginActionPayload = {
  login: string;
  password: string;
};

const loginAction = declareAction<LoginActionPayload>(
  (payload, { dispatch }) => {
    dispatch(showAuthSpinnerAction());
    AuthenticationApi.logIn(payload.login, payload.password)
      .then((resp) => {
        if (resp.status === 200) {
          setTimeout(() => {
            dispatch(initUserDataAction());
          }, 100);
        } else {
          dispatch(closeAuthSpinnerAction());
        }
      }) //dispatch API_SUCCESS
      .catch((err) => {
        // ошибка
      }); //dispatch API_ERROR
  }
);

export { loginAction };
export type { LoginActionPayload };
