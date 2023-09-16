<template>
  <q-page class="">
    <q-input
      placeholder="username"
      label="User Name"
      rounded
      outlined
      class="q-mt-lg"
      v-model="username"
    ></q-input>
    <q-input
      placeholder="password"
      label="Password"
      rounded
      outlined
      type="password"
      class="q-mt-lg"
    ></q-input>
    <q-btn class="full-width q-mt-md q-py-sm" color="primary" rounded>Register</q-btn>
    {{ username }}
    <q-card>
      <img src="/" alt="">
    </q-card>
  </q-page>
</template>

<script>
import { defineComponent, ref } from "vue";

export default defineComponent({
  name: "IndexPage",
  setup () {
    const username = ref('')
    return {
      username
    }
  }
});
</script>
