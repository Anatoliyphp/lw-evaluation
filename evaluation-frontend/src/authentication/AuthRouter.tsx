import { useAtom } from '@reatom/react';
import { Redirect, Route, RouteProps } from 'react-router-dom';
import { userAtom } from './model/userAtom';

interface AuthRouterProps extends RouteProps {
  component: React.ComponentType;
  role: string;
  path: string;
}

function AuthRouter({ component: Component, ...rest }: AuthRouterProps) {
  const user = useAtom(userAtom);

  // перенести логику в другое место
  if (!user.isAuthUser) return <Redirect to='/login' />;
  if (rest.role === 'student' && user.role === 'teacher')
    return <Redirect to='/teacher/labsQueue' />;
  if (rest.role === 'teacher' && user.role === 'student')
    return <Redirect to='/student/courses' />;

  return <Route {...rest} render={() => <Component />} />;
}

export { AuthRouter };
