<template>
  <div>
    <button class="text-h6">
      {{ age }}
    </button>
  </div>
</template>

<script>
import { reactive } from "vue";
export default {
  // name: 'PageName',
  setup() {
    const person = reactive({
      name: 'usher',
      fname: 'sm',
      age:34
    });
    console.log(person.age);
    return {
      ...toRefs(person),
    };
  },
};
</script>
