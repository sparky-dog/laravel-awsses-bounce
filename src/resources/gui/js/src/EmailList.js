import React from 'react';
import {Fragment} from "react";
import BlackListed from "./BlackListed";

const EmailList = () => {

  return (
    <Fragment>
      <div className="columns">
        <BlackListed/>
      </div>
    </Fragment>
  );
};

export default EmailList;
