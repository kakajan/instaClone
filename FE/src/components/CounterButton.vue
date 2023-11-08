<template>
  <div>
    <button @click="plus()">{{ sum }}</button>
  </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
  // name: 'ComponentName',
  props: ["counter"],
  emits: ["sumed"],
  setup(props, {emit}) {
    const sum = ref(props.counter);
    emit("sumed", sum.value);

    function plus() {
      sum.value++;
      emit("sumed", sum.value);
    }
    return {
      ...toRefs(props),
      sum,
      plus,
    };
  },
};
</script>
