import classes from './FileItem.module.css';

import FileCancelIcon from '../../../../assets/img/file_cancel.svg';
import FileIcon from '../../../../assets/img/file.svg';

type FileItemProps = {
  onDeleteHandler: Function;
  downloadUrl: string;
  fileName: string;
  fileId: string;
  disabled: boolean;
};

function FileItem(props: FileItemProps) {
  function onClick() {
    const a = document.createElement('a');
    a.href = props.downloadUrl;
    a.download = props.fileName;
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
  return (
    <li className={classes.FileListItem} key={props.fileId}>
      <div style={{ position: 'relative', cursor: 'pointer' }}>
        <img
          className={classes.FileIcon}
          onClick={onClick}
          src={FileIcon}
          alt='Icon'
        />
        {!props.disabled ? (
          <img
            className={classes.FileCancelIcon}
            src={FileCancelIcon}
            onClick={() => props.onDeleteHandler(props.fileId)}
            alt='Icon'
          />
        ) : null}
      </div>
      <span className={classes.FileName}>{props.fileName}</span>
    </li>
  );
}
export { FileItem };
