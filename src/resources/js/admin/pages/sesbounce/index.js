import React,{useState,useEffect,useRef,} from 'react'
import api from '../../api'
import Table from 'react-tailwind-table'
import Fab from '@material-ui/core/Fab';
import { HiPlusCircle } from "react-icons/hi";
import { HiPencil,HiTrash,HiOutlineX } from "react-icons/hi";
import IconButton from '@material-ui/core/IconButton';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import Paper from '@material-ui/core/Paper';
import Draggable from 'react-draggable';
import swal from 'sweetalert2';
import Select from 'react-select';
const columns = [
    {
       field : 'action',
       use : " "
    },
    {
        field : 'email',
        use : 'Email'
    },
    {
        field : 'source_ip',
        use : 'IP'
    },
    {
        field : 'status',
        use : 'Status'
    },
    {
        field : 'code',
        use : 'Code'
    },
    {
        field : 'send_count',
        use : 'Send count'
    },
    {
        field : 'created_at',
        use : 'Date created'
    }
]
const SesBounce = () =>
{
    const [rows,setRows] = useState([])
    const [open,setOpen] = useState(false)
    const [content,setContent] = useState('')
    const form = useRef(null)
    const [id,setId] = useState('');
    const [contacts,setContacts] = useState([]);
    const [block_contact,setBlockContact] = useState('')
     useEffect(() => {
          const fetch = async () =>
          {
                const {data} = await api.getSesBounce()
                await api.getContacts().then(response=>{
                    setContacts(response.data)
                })
                setRows(data)
          }
          fetch()
     }, [])
    const Create = () =>
    {
   
      setOpen(true)
      setBlockContact('')
    }
    const handleSubmit = async (e) =>
    {
        e.preventDefault()
        
            const formdata = new FormData()
            formdata.append('id',block_contact)
            const {data} = await api.BlockedContact(formdata)
            setRows(data)
            setOpen(false)
            swal.fire("Blocked successfully!");
        
        
    }
  
    const rowCheck = (rows,columns) => 
    {
        let id = rows.id
        if(columns.field ==="action")
        {
            return  <div className="inline-flex items-center"><div onClick={()=>deleteData(id)}><IconButton color="secondary" aria-label="edit" component="span">
            <HiTrash />
          </IconButton></div></div>
        }
    }
    const PaperComponent = (props) => {
        return (
          <Draggable handle="#draggable-dialog-title" cancel={'[class*="MuiDialogContent-root"]'}>
            <Paper {...props} />
          </Draggable>
        );
      }
      const handleClose = () => 
      {
          setOpen(false)
          console.log('modal',open)
      }
      const deleteData =  (id) => 
      {
        swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            api.Unblocked(id).then(res=>{
              setRows(res.data)
              swal.fire(
                'Deleted!',
                'Email has been unblocked.',
                'success'
              )
            })
           
           
          }
        })
      }
    const handleSelect = (e) =>
    {
        if(e)
        {
            setBlockContact(e.value)
        }
    }
    useEffect(() => {
       console.log(contacts)
    }, [contacts])
    return ( <div  className="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
                        <div className="float-right">
                        <Fab  color="primary" aria-label="add" onClick={()=>Create()}>
                        <HiPlusCircle />
                    </Fab>
                    </div>
           <Table columns={columns} rows={rows} row_render={rowCheck} per_page={10} />
     <Dialog
        open={open}
        PaperComponent={PaperComponent}
        aria-labelledby="draggable-dialog-title"
        fullWidth
        maxWidth="md"
      >
        <DialogTitle style={{ cursor: 'move' }} id="draggable-dialog-title">
        <p className="inline-flex items-center"> Block Contacts</p>
        <div onClick={handleClose} className="float-right"><IconButton color="secondary" aria-label="edit" component="span">
            <HiOutlineX />
          </IconButton></div>
        </DialogTitle>
        <DialogContent>
        <form  onSubmit={e=>handleSubmit(e)} >
        <div className="mb-6 w-ful">
        <Select
          className="basic-single"
          classNamePrefix="select"
          isClearable
          isSearchable={true}
          value={contacts[contacts.findIndex(obj=>obj.value === block_contact)]}
          name="contacts"
          onChange ={handleSelect}
          options={contacts}
        />
        </div>
  
    

          <button type="submit" className="w-full mt-6 text-indigo-50 font-bold bg-indigo-600 py-3 rounded-md hover:bg-indigo-500 transition duration-300">
       Block
    </button>
   

     </form>
        </DialogContent>
       
      </Dialog>
        </div>)
}

export default SesBounce