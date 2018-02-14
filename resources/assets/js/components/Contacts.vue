<template>
  <div>
      <h1>Contacts</h1>
      <input class="form-control" v-model="filterInput" placeholder="Type contact name here" id="search_contacts">
      <table class="table table-striped">
          <thead>
          <tr>
              <th>Name</th>
              <th>E-mail</th>
              <th>Phone</th>
              <th>Edit</th>
              <th>Delete</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="contact in  filterBy(list, filterInput)">
              <td><strong>{{contact.name}}</strong></td> <td>{{contact.email}}</td> <td>{{contact.phone}}</td>
              <td><button @click="showContact(contact.id)" class="btn btn-default btn-xs">Edit</button></td>
              <td><button @click="deleteContact(contact.id)" class="btn btn-danger btn-xs">Delete</button></td>
          </tr>
          </tbody>
      </table>
      <h1 v-show="!edit">Add Contact</h1>
      <h1 v-show="edit">Edit Contact</h1>
      <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()">
          <div class="form-group">
              <label>Name</label>
              <input v-model="contact.name" type="text" name="name" class="form-control">
          </div>
          <div class="form-group">
              <label>Email</label>
              <input v-model="contact.email" type="text" name="email" class="form-control">
          </div>
          <div class="form-group">
              <label>Phone</label>
              <input v-model="contact.phone" type="text" name="phone" class="form-control">
          </div>
          <div class="form-group">
              <button v-show="!edit" type="submit" class="btn btn-primary">New Contact</button>
              <button v-show="edit" type="submit" class="btn btn-primary">Update Contact</button>
          </div>
      </form>
  </div>
</template>

<script>
//    import Autocomplete from 'vue2-autocomplete-js';
    export default {
//        components:{Autocomplete},
        data: function(){
            return {
                edit:false,
                list:[],
                filterInput:'',
                contact:{
                    id:'',
                    name:'',
                    email:'',
                    phone:'',
                }
            }
        },

        mounted: function(){
            console.log('Contacts Component Loaded...');
            this.fetchContactList();
        },
        methods: {
            fetchContactList:function(){
                console.log('Fetching contacts...');
                axios.get('api/contacts')
                    .then((response) => {
                        console.log(response.data);
                        this.list = response.data;
                    }).catch((error) => {
                    console.log(error);
                });
            },
            createContact: function(){
                console.log('Creating contact...');
                let self = this;
                let params =Object.assign({}, self.contact);
                axios.post('api/contact/store', params)
                    .then(function(){
                        self.contact.name = '';
                        self.contact.email = '';
                        self.contact.phone = '';
                        self.edit = false;
                        self.fetchContactList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            showContact: function(id){
                let self = this;
                axios.get('api/contact/'+id)
                    .then(function(response){
                        self.contact.id = response.data.id;
                        self.contact.name = response.data.name;
                        self.contact.email = response.data.email;
                        self.contact.phone = response.data.phone;
                    })
                self.edit = true;
            },
            updateContact: function(id){
                console.log('Updating contact '+id+'...');
                let self = this;
                let params =Object.assign({}, self.contact);
                axios.patch('api/contact/'+id, params)
                    .then(function(){
                        self.contact.name = '';
                        self.contact.email = '';
                        self.contact.phone = '';
                        self.edit = false;
                        self.fetchContactList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            deleteContact: function(id){
                axios.delete('api/contact/'+id)
                    .then(function(response){
                        self.fetchContactList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            filterBy(lost, value){
                value = value.charAt(0).toUpperCase() + value.slice(1);
                return lost.filter(function(contact){
                    return contact.name.indexOf(value) > -1;
                });
            }
        }
    }
</script>
