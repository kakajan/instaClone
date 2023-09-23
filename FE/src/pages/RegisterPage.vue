<template>
  <q-page padding class="">
    <div class="row justify-center">
      <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <q-input
          placeholder="email"
          label="User Name"
          rounded
          outlined
          type="email"
          class="q-mt-lg"
          v-model="username"
        ></q-input>
        <q-input
          placeholder="password"
          label="Password"
          rounded
          outlined
          v-model="password"
          type="password"
          class="q-mt-lg"
        ></q-input>
        <q-input
          placeholder="confirm password"
          label="Confirm Password"
          rounded
          outlined
          v-model="confirmPassword"
          type="password"
          class="q-mt-lg"
        ></q-input>
        <q-btn
          outline
          class="full-width q-mt-md q-py-sm"
          color="primary"
          rounded
          @click="register"
          >Register</q-btn
        >
      </div>
    </div>
  </q-page>
</template>

<script>
import { api } from "src/boot/axios";
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
  name: "IndexPage",
  setup () {
    const router = useRouter();
    const username = ref("");
    const password = ref("");
    const confirmPassword = ref("");
    function register() {
      if (password.value && confirmPassword.value) {
        if (password.value === confirmPassword.value) {
          api
            .post("api/register", {
              email: username.value,
              password: password.value,
            })
            .then((r) => {
              console.log(r.data);
              if (r.data.status) {
                router.push('/login')
              } else {
                alert('مشکلی پیش اومده. میشه لطفا بعد تست کنی؟')
              }
            });
        } else {
          alert("password not match");
        }
      } else {
          alert("Enter Data");
        }
    }
    return {
      username,
      password,
      confirmPassword,
      register,
    };
  },
});
</script>
