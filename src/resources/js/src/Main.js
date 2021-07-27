import React from 'react';
import ReactDOM from 'react-dom';
import EmailList from "./EmailList";
import StoreModel from "./StoreModel";
import {StoreProvider, createStoreStore, createStore} from "easy-peasy";

const Main = () => {
  const model = createStore(StoreModel);
  return (
    <div>
      <StoreProvider store={model}>
          <EmailList/>
      </StoreProvider>
    </div>
  );
}

ReactDOM.render(<Main/>, document.getElementById('root'));
