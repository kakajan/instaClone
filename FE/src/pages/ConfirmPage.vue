<template>
  <q-page padding>
    <!-- content -->
    <div class="row justify-center">
      <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 q-gutter-y-md">
        <q-input
          v-model="password"
          rounded
          outlined
          type="text"
          ref="usernameRef"
          autocomplete="off"
          :rules="[
            (val) => !!val || 'Field is required'
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
import { onMounted, ref } from "vue";
import { useQuasar } from "quasar";
import { api } from "src/boot/axios";
import { useRoute, useRouter } from 'vue-router';
import { useAppDataStore } from 'src/stores/appData';

export default {
  // name: 'PageName',
  setup () {
    const appData = useAppDataStore();
    const route = useRoute();
    const q = useQuasar();
    const username = ref(null);
    const password = ref(null);
    const usernameRef = ref();
    const passwordRef = ref();
    const clientSecret = ref("0xX1CkSYUbEKCBIscu3P3ETkZeDc3MpXMzNDV3A4");
    const clientId = ref(2);
    const router = useRouter()
    function login() {
      usernameRef.value.validate();
      if (usernameRef.value.hasError) {
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
          username: appData.mobile,
          password: password.value,
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
    onMounted(() => {
      console.log(appData.mobile);
    })
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
