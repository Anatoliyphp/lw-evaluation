import { useAtom } from '@reatom/react';
import { labAtom } from '../model/labAtom';
import classes from './CheckLab.module.css';
import { Evaluation } from './Evaluation/Evaluation';
import DownloadIcon from '../../../assets/img/download.svg';
import CheckedIcon from '../../../assets/img/done.svg';
import { useState } from 'react';

function CheckLab() {
  const [totalScore, setTotalScore] = useState<number>(-1);
  const lab = useAtom(labAtom);

  function checkHandler(checkbox: HTMLInputElement, taskScore: number) {
    if (totalScore === -1) {
      setTotalScore(taskScore);
    } else if (totalScore !== -1 && checkbox.checked) {
      setTotalScore(totalScore + taskScore);
    } else if (totalScore !== -1 && !checkbox.checked) {
      setTotalScore(totalScore - taskScore);
    }
  }

  function downloadHandler(file: File) {
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = URL.createObjectURL(file);
    a.download = file.name;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }

  const taskViews = lab.tasks.map((task) => {
    return (
      <li className={classes.TaskItem} key={task.taskId}>
        <label className={classes.TaskItemWrapper}>
          <input
            type='checkbox'
            onChange={(e) => checkHandler(e.target, task.score)}
          />
          <h4 className={classes.TaskTitle}>
            Задание {lab.labId}.{task.taskId}
          </h4>
        </label>

        <ul>
          {task.files.map((file) => {
            return (
              <li className={classes.FileItem} key={file.name}>
                <div className={classes.FileName}>{file.name}</div>
                <div className={classes.DownloadInner}>
                  <img src={DownloadIcon} alt='download' />
                  <button
                    className={classes.DownloadButton}
                    onClick={() => downloadHandler(file)}
                  >
                    Скачать
                  </button>
                </div>
              </li>
            );
          })}
        </ul>
        {task.autoEvaluation ? (
          <span className={classes.AutoCompile}>Автоматическая проверка </span>
        ) : null}
        {task.compiled ? (
          <div className={classes.CompiledWrapper}>
            <span>Compile</span>
            <img src={CheckedIcon} alt='ok' />
          </div>
        ) : null}
      </li>
    );
  });

  return (
    <div className={classes.CheckLab}>
      <h2 className={classes.LabTitle}>Лабараторная работа #{lab.title}</h2>
      <ul className={classes.TaskList}>{taskViews}</ul>
      <Evaluation score={totalScore} maxScore={lab.maxScore} />
    </div>
  );
}

export { CheckLab };
