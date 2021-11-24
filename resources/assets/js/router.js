// Vue Router
import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponentVue from "./components/ExampleComponent";
import ContactCreate from "./views/ContactsCreate";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/", component: ExampleComponentVue },
    { path: "/contact/create", component: ContactCreate }
  ],
  mode: "history" // #を削除
});
