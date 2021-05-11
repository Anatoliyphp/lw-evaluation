import {
  showFetchSpinnerAction,
  closeFetchSpinnerAction,
} from './../../../common/Spinner/model/fetchSpinnerAtom';
import { declareAction } from '@reatom/core';
import { StudentApi } from '../../../api/studentApi';
import { setTaskListAction } from './tasksAtom';

const getTaskListAction = declareAction<string>((payload, { dispatch }) => {
  dispatch(showFetchSpinnerAction());
  StudentApi.getTaskList(payload)
    .then((data) => {
      dispatch(setTaskListAction(data));
    })
    .catch((err) => console.log(err))
    .finally(() => dispatch(closeFetchSpinnerAction()));
});

export { getTaskListAction };
