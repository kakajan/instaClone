<template>
  <q-page padding>
    <!-- content -->
    <q-card v-if="post">
      <q-card-section>
        <h6 class="q-ma-none">{{ post.title }}</h6>
        <p>{{ post.caption }}</p>
        {{ post.user.profile.full_name }}
        <q-btn
          @click="unfollow(post.user.id)"
          v-if="post.user.isFollowing"
          label="UnFollow"
          class="q-ml-sm q-px-md"
          dense
          rounded
          icon="remove"
        />
        <q-btn
          @click="follow(post.user.id)"
          v-else
          label="Follow"
          class="q-ml-sm q-px-md"
          dense
          rounded
          icon="add"
        />
      </q-card-section>
      <q-card-actions align="around">
        <q-btn class="" flat color="grey-8" icon="more_horiz">
          <q-menu fit>
            <q-list>
              <q-item clickable>
                <q-item-section>
                  <q-icon
                    size="25px"
                    @click="$router.push(`/posts/edit/${post.id}`)"
                    name="edit"
                  />
                </q-item-section>
              </q-item>
              <q-separator />
              <q-item clickable>
                <q-item-section>
                  <q-icon
                    size="25px"
                    @click="showConfirmation(post.id, index)"
                    color="pink-6"
                    name="delete"
                  />
                </q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>
        <q-btn
          @click="likeToggle(post.id, index)"
          class=""
          flat
          :color="post.liked ? 'red' : 'grey-7'"
          :icon="post.liked ? 'favorite' : 'favorite_outline'"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script>
import { useAppDataStore } from "src/stores/appData";
import { api } from "src/boot/axios";
import { useRoute } from "vue-router";
import { ref } from "vue";
export default {
  // name: 'PageName',
  setup() {
    const route = useRoute();
    const appData = useAppDataStore();
    const post = ref(null);
    if (!appData.currentPost) {
      api.get("api/posts/" + route.params.id).then((r) => {
        post.value = r.data;
      });
    } else {
      post.value = appData.currentPost;
    }
    function follow(id) {
      api.post("api/users/" + id + "/follow");
          post.value.user.isFollowing = true
    }
    function unfollow(id) {
      api.post("api/users/" + id + "/unfollow").then((r) => {
        if (r.data.status) {
          post.value.user.isFollowing = false
        }
      });
    }
    return {
      appData,
      post,
      follow,
      unfollow,
    };
  },
};
</script>
