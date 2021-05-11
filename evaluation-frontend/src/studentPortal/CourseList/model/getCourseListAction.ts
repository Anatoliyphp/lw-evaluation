import {
  showFetchSpinnerAction,
  closeFetchSpinnerAction,
} from './../../../common/Spinner/model/fetchSpinnerAtom';
import { declareAction } from '@reatom/core';
import { StudentApi } from '../../../api/studentApi';
import { setCourseListAction } from './coursesAtom';

const getCourseListAction = declareAction((payload, { dispatch }) => {
  dispatch(showFetchSpinnerAction());
  StudentApi.getCourseList()
    .then((data) => {
      dispatch(setCourseListAction(data));
    })
    .catch((err) => {
      // ошибка
    })
    .finally(() => dispatch(closeFetchSpinnerAction()));
});

export { getCourseListAction };
