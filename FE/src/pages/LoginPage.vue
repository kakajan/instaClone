<template>
  <q-page padding>
    <!-- content -->
    <div class="row justify-center">
      <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 q-gutter-y-md">
        <q-input
          v-model="username"
          rounded
          outlined
          label="mobile"
          type="text"
          ref="usernameRef"
          placeholder="9112746075"
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
import { ref } from "vue";
import { useQuasar } from "quasar";
import { api } from "src/boot/axios";
import { useRouter } from 'vue-router';
import { useAppDataStore } from "src/stores/appData";

export default {
  // name: 'PageName',
  setup () {
    const appData = useAppDataStore();
    const q = useQuasar();
    const username = ref(null);
    const password = ref(null);
    const usernameRef = ref();
    const passwordRef = ref();
    const clientSecret = ref("gd9D3h8j2o2MYspgYHPPDIWjywO7yUkJYxwNnq41");
    const clientId = ref(2);
    const router = useRouter()
    function login () {
      appData.mobile = username.value
      usernameRef.value.validate();
      if (usernameRef.value.hasError) {
        q.notify({
          color: "negative",
          position: "top",
          message: "Please check your input!",
        });
      } else {
        api.post("api/verify", {
          grant_type: "password",
          client_id: clientId.value,
          client_secret: clientSecret.value,
          username: username.value,
        })
          .then(r => {
            router.push('/confirm')
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
