import React from 'react';
import {useStoreState} from "easy-peasy";
import Items from "../components/Items";

const WhiteListed = () => {
  const emails = useStoreState((state) => state.emails);
  return (
    <div className="column col-6">
      <table>
        <thead>
        <tr>
          <th>
            White Listed
          </th>
        </tr>
        </thead>

        <tbody>
        <tr>
          <td>
            <ul>
              {
                emails.map((email) => {
                  if (!email.blacklist){
                    return <Items email={email} key={email.id}/>
                  }
                })
              }
            </ul>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  );
};

export default WhiteListed;
