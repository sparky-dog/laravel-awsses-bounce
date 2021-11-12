import {action, thunk, thunkOn} from "easy-peasy";
import uuid from 'uuid';
import 'regenerator-runtime/runtime';
import axios from "axios";

export default {
  emails: [],
  fetchEmails: thunk(async actions => {
    const response = await fetch('http://127.0.0.1:8000/api/awsbounce/get');

    const emails = await response.json();

    actions.setEmails(emails);
  }),
  toggle: action( (state, id) => {
    state.emails.map(email => {
      if (email.id === id) {
        state.emails = state.emails.filter(email => email.id !== id)
      }

      return email
    })
  }),

  setEmails: action((state, emails) => {
    state.emails = emails;
  }),

  onRemove: thunkOn(actions => actions.toggle,
    async (actions, target) => {

      await axios.post('http://127.0.0.1:8000/api/awsbounce/edit', {
        id: target.payload
      }).then(r => {console.log(r)})
    }
    )
}
