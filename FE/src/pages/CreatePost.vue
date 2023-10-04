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
        :loading="loading"
        :disable="loading"
        rounded
        class="full-width"
        size="lg"
      />
    </div>
  </q-page>
</template>

<script>
import { reactive, toRefs } from "vue";
import { api } from "src/boot/axios";
import { useQuasar } from "quasar";
import { useRouter } from 'vue-router';
export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar();
    const router = useRouter()
    const props = reactive({
      title: null,
      caption: null,
      loading: false,
    });
    function createPost() {
      props.loading = true;
      api
        .post("api/posts", {
          title: props.title,
          caption: props.caption,
        })
        .then((r) => {
          props.loading = false;
          if (r.data.status) {
            q.notify({
              color: "light-blue-6",
              position: "top",
              message: "Post added successfully!",
              icon: "done_all",
            });
            router.push('/')
          } else {
            q.notify({
              color: "orange-6",
              position: "top",
              message: "Error!",
            });
          }
        })
        .catch((e) => {
          props.loading = false;
          console.log(e);
        });
    }
    return {
      ...toRefs(props),
      createPost,
    };
  },
};
</script>
