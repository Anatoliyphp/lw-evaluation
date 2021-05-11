import { Logo } from '../Logo/Logo';
import classes from './Header.module.css';

type HeaderProps = {
  title: string;
};

function Header(props: HeaderProps) {
  return (
    <header className={classes.Header}>
      <ul className={classes.Path}>
        <li className={classes.MainTittle}>{props.title}</li>
      </ul>
      <Logo letters='IH' />
    </header>
  );
}

export { Header };
