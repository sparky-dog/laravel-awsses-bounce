const axios = window.axios;
const BASE_API_URL = 'http://127.0.0.1:8000/api';

export default
{
    getSesBounce : () => 
    axios.get(`${BASE_API_URL}/awsbounce/get`),
    getContacts : () =>
    axios.get(`${BASE_API_URL}/newsletters-contact`),
    BlockedContact : (data) => 
    axios.post(`${BASE_API_URL}/block-contact`,data,{
        Accept: 'application/json',
        'Content-Type': 'multipart/form-data',
    }),
    Unblocked : (id) =>
    axios.get(`${BASE_API_URL}/unblock-contact/${id}`),
   
}