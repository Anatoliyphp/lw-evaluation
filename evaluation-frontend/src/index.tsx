import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';

import App from './App';
import { BrowserRouter } from 'react-router-dom';
import { context } from '@reatom/react';
import { createStore } from '@reatom/core';
import { userAtom } from './authentication/model/userAtom';

const store = createStore(userAtom);

ReactDOM.render(
  <BrowserRouter>
    <context.Provider value={store}>
      <App />
    </context.Provider>
  </BrowserRouter>,
  document.getElementById('root')
);
