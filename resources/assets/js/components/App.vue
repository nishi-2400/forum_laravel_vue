<template>
  <div class="h-screen bg-white">
    <div class="flex">
      <!-- Left Section -->
      <div class="bg-gray-200 w-48 h-screen border-r-2 border-gray-400">
        <nav>
          <h1 class="pl-3 pt-4 fill-current text-blue-600 text-2xl">
            <router-link to="/">Forum with Laravel / Vue</router-link>
          </h1>

          <p class="pl-3 pt-12 text-xs text-gray-500 uppercase font-bold">create</p>
          <router-link
            to="/contact/create"
            class="flex pl-3 items-center py-2 hover:text-blue-600 hover:bg-gray-300"
          >
            <div>
              <i class="far fa-plus-square text-blue-600"></i>
              <span class="tracking-wide pl-1">Add New</span>
            </div>
          </router-link>

          <p class="pl-3 pt-12 text-xs text-gray-500 uppercase font-bold">general</p>
          <router-link
            to="/contacts"
            class="flex pl-3 items-center py-2 hover:text-blue-600 hover:bg-gray-300"
          >
            <div>
              <i class="far fa-calendar-alt text-blue-600"></i>
              <span class="tracking-wide pl-1">Contacts</span>
            </div>
          </router-link>
          <router-link
            to="/"
            class="flex pl-3 items-center py-2 hover:text-blue-600 hover:bg-gray-300"
          >
            <div>
              <i class="fas fa-birthday-cake text-blue-600"></i>
              <span class="tracking-wide pl-1">Birthday</span>
            </div>
          </router-link>

          <p class="pl-3 pt-12 text-xs text-gray-500 uppercase font-bold">settings</p>
          <router-link
            to="/"
            class="flex pl-3 items-center py-2 hover:text-blue-600 hover:bg-gray-300"
          >
            <div>
              <i class="fas fa-sign-out-alt text-blue-600"></i>
              <span class="tracking-wide pl-1">Logout</span>
            </div>
          </router-link>
        </nav>
      </div>

      <!-- Right Section -->
      <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <!-- Right Top -->
        <div class="h-16 px-6 border-b border-gray-400 flex items-center justify-between">
          <div>Contacts</div>
          <UserCircle :name="user.name"></UserCircle>
        </div>

        <!-- Right Bottom -->
        <div class="flex flex-col overflow-y-hidden flex-1">
          <router-view class="p-6 overflow-x-hidden"></router-view>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import UserCircle from "./UserCircle";

export default {
  name: "App",
  props: ["user"],
  components: {
    UserCircle
  },
  created() {
    axios.interceptors.request.use(config => {
      if (config.method === "get") {
        config.url = config.url + "?api_token=" + this.user.api_token;
      } else {
        config.data = {
          ...config.data,
          api_token: this.user.api_token
        };
      }

      return config;
    });
  }
};
</script>