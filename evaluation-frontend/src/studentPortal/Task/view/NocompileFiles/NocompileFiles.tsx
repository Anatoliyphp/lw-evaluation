import { ToastContainer, toast } from 'react-toastify';
import classes from './NocompileFiles.module.css';

import { useAction, useAtom } from '@reatom/react';
import {
  addFileAction,
  deleteFileAction,
  filesAtom,
} from '../../model/filesAtom';

import 'react-toastify/dist/ReactToastify.css';
import { taskStateAtom } from '../../model/taskStateAtom';
import { FileItem } from '../FileItem/FileItem';
import { ActionState, ActionType } from '../../model/TaskStateData';

function NocompileFiles() {
  const files = useAtom(filesAtom);
  const taskState = useAtom(taskStateAtom);

  const deleteFile = useAction(deleteFileAction);
  const addFile = useAction(addFileAction);

  const fileUploadAction = taskState?.actions.find(
    (action) => action.type === ActionType.FILE_UPLOAD
  );

  function importFileHandler(e: React.FormEvent<HTMLInputElement>) {
    if (e.currentTarget && e.currentTarget.files) {
      const file = e.currentTarget.files[0] as File;
      const reader = new FileReader();
      if (!reader || !file) return;
      reader.readAsDataURL(file);
      reader.addEventListener('load', () => {
        if (!reader.result) {
          return;
        }
        if (!files.find((f) => f.name === file.name)) {
          addFile({ name: file.name, downloadUrl: URL.createObjectURL(file) });
        }
      });
    }
    e.currentTarget.value = '';
  }

  const fileViews = files.map((file) => {
    return (
      <FileItem
        onDeleteHandler={deleteFile}
        downloadUrl={file.downloadUrl}
        fileName={file.name}
        fileId={file.name}
        disabled={fileUploadAction?.state === ActionState.COMPLETED}
      />
    );
  });

  return (
    <div>
      <div className={classes.ButtonsWrapper}>
        <div className={classes.InputWrapper}>
          <input
            name='file'
            type='file'
            id='input__file'
            className={classes.InputFile}
            onChange={(e) => importFileHandler(e)}
          />
          <label htmlFor='input__file' className={classes.InputFileButton}>
            <span className={classes.InputFileButtonText}>Загрузить файл</span>
          </label>
        </div>
        {/* Если экшн загрузки успешный, т.е. мы уже отправили на проверку, не показываем кнопку отправить */}
        {fileUploadAction?.state != 2 && files.length ? (
          <button
            className={classes.SendButton}
            onClick={() => toast.success('Отправлено на проверку')}
          >
            Отправить на проверку
          </button>
        ) : null}
      </div>
      <div className={classes.Line}></div>
      <ul className={classes.FileList}>{fileViews}</ul>
      <ToastContainer
        position='top-center'
        draggable={false}
        pauseOnHover={false}
        hideProgressBar={false}
      />
    </div>
  );
}

export { NocompileFiles };
