<template>
  <q-page padding class="row">
    <!-- <form enctype="multipart/form-data" action="http://localhost:8000/api/upload" method="POST">
      <input type="file" accept="image/png, image/jpeg" name="picture" >
      <input type="submit" value="send" >
    </form> -->
    <!-- content -->
    <q-form class="col-12 row" @submit="createPost">
      <div class="col-12 q-gutter-y-md">
        <q-input
          name="title"
          label="Post title"
          autofocus
          rounded
          outlined
          v-model="title"
        />
        <q-file
          name="picture"
          v-model="file"
          filled
          label="Select post image"
        />
        <q-input
          name="caption"
          label="Caption"
          type="textarea"
          rounded
          outlined
          v-model="caption"
        />
        <q-btn
          type="submit"
          label="Create"
          icon-right="send"
          outline
          :loading="loading"
          :disable="loading"
          rounded
          class="full-width"
          size="lg"
        /></div
    ></q-form>
  </q-page>
</template>

<script>
import { reactive, ref, toRefs } from "vue";
import { api } from "src/boot/axios";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";
export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar();
    const router = useRouter();
    const props = reactive({
      title: null,
      caption: null,
      loading: false,
      file: null,
    });
    function handleFile(e) {
      props.file = e.target.files[0];
      console.log(props.file);
    }
    function createPost(event) {
      const formData = new FormData(event.target);
      props.loading = true;
      api
        .post("api/posts", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
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
            router.push("/");
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
      handleFile,
    };
  },
};
</script>
