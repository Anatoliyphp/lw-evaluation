import { declareAtom, declareAction } from '@reatom/core';
import { UserModel } from './UserModel';

const userMockData: UserModel = {
  isAuthUser: false,
};

const setUserDataAction = declareAction<UserModel>();

const userAtom = declareAtom<UserModel>(userMockData, (on) => [
  on(setUserDataAction, (_, payload) => payload),
]);

export { setUserDataAction, userAtom };
