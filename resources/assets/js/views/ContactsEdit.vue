<template>
  <div>
    <div class="flex justify-between">
      <a href="#" class="text-blue-400" @click="$router.back()">Back</a>
    </div>
    <form @submit.prevent="submitForm">
      <InputField
        name="name"
        label="Contact Name"
        :errors="errors"
        placeholder="Contact Name"
        @update:field="form.name = $event"
        :data="form.name"
      ></InputField>
      <InputField
        name="email"
        label="Contact Email"
        :errors="errors"
        placeholder="Contact Email"
        @update:field="form.email = $event"
        :data="form.email"
      ></InputField>
      <InputField
        name="company"
        label="Company"
        :errors="errors"
        placeholder="Company"
        @update:field="form.company = $event"
        :data="form.company"
      ></InputField>
      <InputField
        name="birthday"
        label="Birthday"
        :errors="errors"
        placeholder="MM/DD/YYYY"
        @update:field="form.birthday = $event"
        :data="form.birthday"
      ></InputField>

      <div class="flex justify-end">
        <button class="py-2 px-5 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
        <button class="bg-blue-500 py-2 px-5 text-white rounded hover:bg-blue-400">Update</button>
      </div>
    </form>
  </div>
</template>  
<script>
import InputField from "../components/InputField";
import axios from "axios";

export default {
  name: "ContactsCreate",
  components: {
    InputField
  },
  data: function() {
    return {
      form: {
        name: "",
        email: "",
        company: "",
        birthday: ""
      },
      errors: null,
      loading: false
    };
  },
  methods: {
    submitForm: function() {
      axios
        .patch("/api/contacts/" + this.$route.params.id, this.form)
        .then(response => {
          this.$router.push(response.data.links.self);
        })
        .catch(error => {
          this.errors = error.response.data.errors;
        });
    }
  },
  mounted() {
    axios
      .get("/api/contacts/" + this.$route.params.id)
      .then(response => {
        this.form = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        console.log(error);
        this.loading = true;
        if (error.response.status == 404) {
          this.$router.push("/contacts");
        }
      });
  }
};
</script>