import React from 'react';
import {useStoreState,useStoreActions} from "easy-peasy";
import Items from "../components/Items";

const BlackListed = () => {
  const emails = useStoreState(state => state.emails)
  const fetchEmails = useStoreActions(actions => actions.fetchEmails)

  React.useEffect(() => {
    fetchEmails()
  }, [])

  return (
    <div className="column col-6">
      <table>
        <thead>
        <tr>
          <th>
            Black Listed
          </th>
        </tr>
        </thead>

        <tbody>
        <tr>
          <td>
            <ul>
              {
                emails.map((email) => {
                  return <Items email={email} key={email.id}/>
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

export default BlackListed;
