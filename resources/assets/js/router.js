// Vue Router
import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponentVue from "./components/ExampleComponent";
import ContactCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";
import ContactsEdit from "./views/ContactsEdit";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/", component: ExampleComponentVue },
    { path: "/contact/create", component: ContactCreate },
    { path: "/contacts/:id", component: ContactsShow },
    { path: "/contacts/:id/edit", component: ContactsEdit }
  ],
  mode: "history" // #を削除
});
