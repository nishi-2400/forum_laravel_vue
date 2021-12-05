<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-if="contacts.length === 0">
        <p>
          No contacts yet.
          <router-link to="/contact/create">Add contact</router-link>
        </p>
      </div>

      <div v-for="contact in contacts">
        <router-link
          :to="'/contacts/' + contact.data.contact_id"
          class="flex items-center border-b borer-gray-400 p-4 hover:bg-gray-100"
        >
          <UserCircle :name="contact.data.name"></UserCircle>
          <div class="pl-4">
            <p class="text-blue-400 font-bold">{{ contact.data.name }}</p>
            <p class="text-gray-600">{{ contact.data.company }}</p>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import UserCircle from "./UserCircle";
export default {
  name: "ContactList",
  components: {
    UserCircle
  },
  props: ["endpoint"],
  data: function() {
    return {
      contacts: {},
      loading: true
    };
  },
  mounted() {
    axios
      .get(this.endpoint)
      .then(response => {
        this.contacts = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        console.log(error);
        alert("Unable to fetch contact data");
      });
  }
};
</script>
