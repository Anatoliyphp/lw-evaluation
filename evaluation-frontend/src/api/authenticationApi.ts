import { setUserDataAction } from '../authentication/model/userAtom';

function logIn(login: string, password: string): Promise<Response> {
  const promise = fetch('http://localhost/api/login_check', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ username: login, password: password }),
  });

  promise
    .then((resp) => resp.json())
    .then((data) => {
      if (data.token) {
        saveToken(data.token);
      }
    })
    .catch((err) => {
      // ошибка
    });

  return promise;
}

function logOut(): Promise<Response> {
  const promise = new Promise<any>((resolve, reject) => {
    setTimeout(() => {
      resolve({ code: 200 });
    }, 2000);
  });

  setUserDataAction({ isAuthUser: false });
  removeToken();

  return promise;
}

function saveToken(token: string): void {
  localStorage.setItem('token', token);
}

type GetUserDataType = {
  email: string;
  firstname: string;
  id: string;
  lastname: string;
  role: 'student' | 'teacher';
  code?: number;
  message?: string;
};

function getUserData(): Promise<GetUserDataType> {
  return fetch('http://localhost/api/logged_user', {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${getToken()}`,
    },
  }).then((resp) => {
    if (resp.status === 401) {
      // незалогинен
    }
    return resp.json();
  });
}

function getToken(): string {
  return localStorage.getItem('token') || '';
}

function removeToken(): void {
  localStorage.removeItem('token');
}

const AuthenticationApi = {
  logIn,
  logOut,
  getUserData,
};

export { AuthenticationApi, getToken, saveToken, removeToken, getUserData };
