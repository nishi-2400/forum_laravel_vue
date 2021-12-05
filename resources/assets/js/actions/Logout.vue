<template>
  <div></div>
</template>

<script>
import axios from "axios";
export default {
  name: "Logtout",
  created() {
    axios.post("/logouot").finally(error => {
      window.location = "/login";
    });
  }
};
</script>