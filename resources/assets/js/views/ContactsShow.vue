<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div class="flex justify-between">
        <div class="text-blue-400">Back</div>
        <div>
          <router-link
            :to="'/contact/' + contact.id + '/edit'"
            class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 font-bold mr-2"
          >Edit</router-link>
          <a
            href="#"
            class="px-4 py-2 rounded text-sm text-red-500 border border-red-500 font-bold"
          >Delete</a>
        </div>
      </div>

      <div class="flex items-center pt-6">
        <UserCircle :name="contact.name"></UserCircle>
        <p class="pl-5 text-sl">{{ contact.name }}</p>
      </div>
      <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
      <p class="pt-2 text-blue-400">{{ contact.email }}</p>
      <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
      <p class="pt-2 text-blue-400">{{ contact.company }}</p>
      <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
      <p class="pt-2 text-blue-400">{{ contact.birthday }}</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UserCircle from "../components/UserCircle";

export default {
  name: "ContactsShow",
  components: { UserCircle },
  data: function() {
    return {
      contact: {},
      loading: true
    };
  },
  mounted() {
    axios
      .get("/api/contacts/" + this.$route.params.id)
      .then(response => {
        this.contact = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        console.log(error);
        this.loading = false;
      });
  }
};
</script>
