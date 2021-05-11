import { Link, useRouteMatch } from 'react-router-dom';
import { LabData } from '../../model/ApiLabListItemData';

import classes from './LabWork.module.css';

function LabWork(props: LabData) {
  const match = useRouteMatch();

  let buttonText = 'Приступить';
  let redMessage = '';
  let greenMessage = '';

  if (props.recievedScore && props.recievedScore > 0) {
    buttonText = '';
    greenMessage = `Ваш балл ${props.recievedScore} из ${props.maxScore}`;
  } else if (props.recievedScore !== undefined && props.recievedScore === 0) {
    buttonText = 'Выполнить повторно';
    redMessage = `Ваш балл из ${props.maxScore}`;
  }

  return (
    <div className={classes.LabWork}>
      <h4
        className={`${classes.LabWorkTitle} ${
          !props.isAvailable ? classes.Disabled : ''
        }`}
      >
        Лабораторная работа #{props.id}
      </h4>

      {redMessage ? (
        <span className={classes.ErrorMessage}>{redMessage}</span>
      ) : null}

      {greenMessage ? (
        <div className={classes.SuccessMessage}>
          <span>Проверено</span>
          <span>{greenMessage}</span>
        </div>
      ) : null}

      {buttonText ? (
        <Link to={`${match.url}/lab/${props.id}`}>
          <button className={classes.StartButton}>{buttonText}</button>
        </Link>
      ) : null}
    </div>
  );
}

export { LabWork };
