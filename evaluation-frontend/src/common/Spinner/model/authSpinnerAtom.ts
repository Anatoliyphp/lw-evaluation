import { declareAtom, declareAction } from '@reatom/core';

const showAuthSpinnerAction = declareAction();
const closeAuthSpinnerAction = declareAction();

const authSpinnerVisibilityAtom = declareAtom<boolean>(false, (on) => [
  on(showAuthSpinnerAction, () => true),
  on(closeAuthSpinnerAction, () => false),
]);

export {
  showAuthSpinnerAction,
  closeAuthSpinnerAction,
  authSpinnerVisibilityAtom,
};
