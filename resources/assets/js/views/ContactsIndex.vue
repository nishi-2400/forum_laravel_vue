<template>
  <ContactList endpoint="/api/contacts"></ContactList>
</template>

<script>
import ContactList from "../components/ContactList";
export default {
  name: "ContactsIndex",
  components: {
    ContactList
  }
};
</script>