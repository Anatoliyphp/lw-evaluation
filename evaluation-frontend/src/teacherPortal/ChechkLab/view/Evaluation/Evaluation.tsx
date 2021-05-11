import classes from './Evaluation.module.css';

type EvaluationProps = {
  score: number;
  maxScore: number;
};

function Evaluation(props: EvaluationProps) {
  return (
    <div className={classes.Evaluation}>
      <span className={classes.ScoreTitle}>Балл</span>
      <input
        readOnly
        type='number'
        placeholder={`max ${props.maxScore}`}
        value={props.score !== -1 ? props.score : ''}
      />
      <button
        className={classes.EvaluateButton}
        onClick={() => alert('Оценено!')}
      >
        Оценить
      </button>
    </div>
  );
}

export { Evaluation };
