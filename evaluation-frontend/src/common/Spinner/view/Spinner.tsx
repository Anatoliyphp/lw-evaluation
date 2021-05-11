import classes from './Spinner.module.css';

type SpinnerProps = {
  type?: string;
};

function Spinner(props: SpinnerProps) {
  const spinnerClass =
    props.type === 'auth' ? classes.AuthMode : classes.FetchMode;

  return (
    <div className={`${classes.Spinner} ${spinnerClass}`}>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  );
}

export { Spinner };
