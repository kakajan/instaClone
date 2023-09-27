<template>
  <q-page padding class="row">
    <!-- content -->
    <div class="col-12 q-gutter-y-md">
      <q-input label="Post title" autofocus rounded outlined v-model="title" />
      <q-input
        label="Caption"
        type="textarea"
        rounded
        outlined
        v-model="caption"
      />
      <q-btn
        @click="createPost"
        label="Create"
        icon-right="send"
        outline
        rounded
        class="full-width"
        size="lg"
      />
    </div>
  </q-page>
</template>

<script>
import { reactive, toRefs } from "vue";
import { api } from 'src/boot/axios';
export default {
  // name: 'PageName',
  setup() {
    const props = reactive({
      title: null,
      caption: null,
    });
    function createPost () {
      api.post('api/posts', {
        title: props.title,
        caption: props.caption
      })
        .then(r => {
        console.log(r.data);
      })
    }
    return {
      ...toRefs(props),
      createPost
    };
  },
};
</script>
