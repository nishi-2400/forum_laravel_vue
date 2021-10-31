// Vue Router
import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponentVue from "./components/ExampleComponent";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [{ path: "/", component: ExampleComponentVue }],
  mode: "history" // #を削除
});
