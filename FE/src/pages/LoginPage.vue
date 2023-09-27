<template>
  <q-page padding>
    <!-- content -->
    <div class="row justify-center">
      <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 q-gutter-y-md">
        <q-input
          v-model="username"
          rounded
          outlined
          label="email"
          type="email"
          ref="usernameRef"
          placeholder="somemail@gmail.com"
          autocomplete="off"
          :rules="[
            (val) => !!val || 'Field is required',
            (val) => val.length > 10 || 'Please use at least 10 characters',
          ]"
        />
        <q-input
          v-model="password"
          rounded
          outlined
          label="password"
          type="password"
          ref="passwordRef"
          placeholder="Enter your password"
          autocomplete="off"
          :rules="[
            (val) => !!val || 'Field is required',
            (val) => val.length > 3 || 'Please use at least 3 characters',
          ]"
        />
        <q-btn
          @click="login"
          class="full-width q-py-sm"
          outline
          color="light-blue-6"
          rounded
          label="Login"
          icon="security"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import { ref } from "vue";
import { useQuasar } from "quasar";
import { api } from "src/boot/axios";
import { useRouter } from 'vue-router';

export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar();
    const username = ref(null);
    const password = ref(null);
    const usernameRef = ref();
    const passwordRef = ref();
    const clientSecret = ref("gd9D3h8j2o2MYspgYHPPDIWjywO7yUkJYxwNnq41");
    const clientId = ref(2);
    const router = useRouter()
    function login() {
      usernameRef.value.validate();
      passwordRef.value.validate();
      if (usernameRef.value.hasError || passwordRef.value.hasError) {
        q.notify({
          color: "negative",
          position: "top",
          message: "Please check your input!",
        });
      } else {
        api.post("oauth/token", {
          grant_type: "password",
          client_id: clientId.value,
          client_secret: clientSecret.value,
          username: username.value,
          password: password.value
        })
          .then(r => {
            console.log(r.data);
            if (r.data.access_token) {
              q.cookies.set('access_token',r.data.access_token,{expires: '365d'})
              q.cookies.set('refresh_token',r.data.refresh_token, {expires: '365d'})
              q.cookies.set('expires_in',r.data.expires_in, {expires: '365d'})
            }
            router.push('/')
          });
      }
    }
    return {
      username,
      usernameRef,
      password,
      passwordRef,
      login,
    };
  },
};
</script>
