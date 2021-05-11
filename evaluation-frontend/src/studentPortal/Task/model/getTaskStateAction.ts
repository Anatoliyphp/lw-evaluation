import {
  showFetchSpinnerAction,
  closeFetchSpinnerAction,
} from './../../../common/Spinner/model/fetchSpinnerAtom';
import { declareAction } from '@reatom/core';
import { setTaskStateAction } from './taskStateAtom';
import { StudentApi } from '../../../api/studentApi';
import { setFilesAction } from '../../Task/model/filesAtom';
import { ActionType } from './TaskStateData';
import { setTaskDescriptionAction } from './tasksDescriptionAtom';

const getTaskStateAction = declareAction<string>((payload, { dispatch }) => {
  dispatch(showFetchSpinnerAction());
  StudentApi.getTaskState(payload)
    .then((data) => {
      dispatch(
        setTaskDescriptionAction({
          taskDescription: data.taskDescription,
          taskTitle: data.taskTitle,
        })
      );
      dispatch(
        setTaskStateAction({
          lastActionId: data.lastActionId,
          actions: data.actions,
        })
      );

      const fileUploadAction = data.actions.find(
        (action: any) => action.type == ActionType.FILE_UPLOAD
      );

      if (fileUploadAction) {
        dispatch(setFilesAction(fileUploadAction.files));
      }
    })
    .catch((err) => {
      // ошибка
    })
    .finally(() => dispatch(closeFetchSpinnerAction()));
});

export { getTaskStateAction };
