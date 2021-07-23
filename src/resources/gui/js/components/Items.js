import React from 'react';
import {useStoreActions} from "easy-peasy";

const Items = ({email}) => {
  const {toggle} = useStoreActions((actions) => ({
    toggle: actions.toggle
  }))
  return (
    <div onClick={() => {toggle(email.id)}} style={{cursor: 'pointer'}} >
      {email.email}
    </div>
  );
};

export default Items;
