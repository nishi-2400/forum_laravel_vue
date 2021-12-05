// Vue Router
import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponentVue from "./components/ExampleComponent";
import ContactCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";
import ContactsEdit from "./views/ContactsEdit";
import ContactIndex from "./views/ContactsIndex";
import BirthdaysIndex from "./views/BirthdaysIndex";
import Logout from "./actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    {
      path: "/",
      component: ExampleComponentVue,
      meta: { title: "Welcome!!" }
    },
    {
      path: "/contacts",
      component: ContactIndex,
      meta: { title: "Contacts" }
    },
    {
      path: "/birthdays",
      component: BirthdaysIndex,
      meta: { title: "Brithdays" }
    },
    {
      path: "/contact/create",
      component: ContactCreate,
      meta: { title: "Create Contact" }
    },
    {
      path: "/contacts/:id",
      component: ContactsShow,
      meta: { title: "Contact Detail" }
    },
    {
      path: "/contacts/:id/edit",
      component: ContactsEdit,
      meta: { title: "Edit Contact" }
    },
    {
      path: "/logout",
      component: Logout,
      meta: { title: "Logout" }
    }
  ],
  mode: "history" // #を削除
});
