import { declareAtom, declareAction } from '@reatom/core';

const setUserInitialized = declareAction();
const setUserUnitialized = declareAction();

const isUserDataInitializedAtom = declareAtom<boolean>(false, (on) => [
  on(setUserInitialized, () => true),
  on(setUserUnitialized, () => false),
]);

export { setUserInitialized, setUserUnitialized, isUserDataInitializedAtom };
