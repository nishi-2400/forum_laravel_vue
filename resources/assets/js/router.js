// Vue Router
import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponentVue from "./components/ExampleComponent";
import ContactCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/", component: ExampleComponentVue },
    { path: "/contact/create", component: ContactCreate },
    { path: "/contact/:id", component: ContactsShow }
  ],
  mode: "history" // #を削除
});
