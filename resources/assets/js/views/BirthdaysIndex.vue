<template>
  <ContactList endpoint="/api/birthdays"></ContactList>
</template>

<script>
import ContactList from "../components/ContactList";
export default {
  name: "BirthdaysIndex",
  components: {
    ContactList
  }
};
</script>