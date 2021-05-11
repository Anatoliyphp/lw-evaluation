export type UserModel = AuthenticatedUserModel | UnautenticatedUserModel;

type AuthenticatedUserModel = {
  isAuthUser: true;
  email: string;
  id: string;
  role: 'student' | 'teacher';
  firstname: string;
  lastname: string;
};

type UnautenticatedUserModel = {
  isAuthUser: false;
};
