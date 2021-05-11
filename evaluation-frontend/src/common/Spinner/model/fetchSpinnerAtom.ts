import { declareAtom, declareAction } from '@reatom/core';

const showFetchSpinnerAction = declareAction();
const closeFetchSpinnerAction = declareAction();

const fetchSpinnerVisibilityAtom = declareAtom<boolean>(false, (on) => [
  on(showFetchSpinnerAction, () => true),
  on(closeFetchSpinnerAction, () => false),
]);

export {
  showFetchSpinnerAction,
  closeFetchSpinnerAction,
  fetchSpinnerVisibilityAtom,
};
