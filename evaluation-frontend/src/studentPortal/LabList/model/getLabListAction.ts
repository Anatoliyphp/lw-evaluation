import {
  showFetchSpinnerAction,
  closeFetchSpinnerAction,
} from './../../../common/Spinner/model/fetchSpinnerAtom';
import { declareAction } from '@reatom/core';
import { StudentApi } from '../../../api/studentApi';

import { setLabListAction } from './labsAtom';

const getLabListAction = declareAction<string>((courseId, { dispatch }) => {
  dispatch(showFetchSpinnerAction());
  StudentApi.getLabList(courseId)
    .then((labListData) => {
      dispatch(setLabListAction(labListData));
    })
    .catch((err) => {
      // ошибка
    })
    .finally(() => dispatch(closeFetchSpinnerAction()));
});

export { getLabListAction };
