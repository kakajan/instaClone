<template>
  <q-page padding>
    <!-- content -->
    <div class="row justify-center">
      <div class="col-auto text-center">
        <q-avatar size="80px">
          <q-img src="/avatar.webp" />
        </q-avatar>
        <h4 class="text-h6 q-ma-none">Usher</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <q-tabs
          v-model="tab"
          dense
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab name="posts" label="Posts" />
          <q-tab name="followers" label="Followers" />
          <q-tab name="followings" label="Followings" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="posts" class="q-gutter-y-md">
            <div class="text-h6">Posts</div>
            <div
              v-if="posts.length < 1"
              class="text-grey-8 text-h6 text-center"
            >
              You dont have any posts!
            </div>
            <div v-else class="row q-col-gutter-sm">
              <div
                class="col-6"
                v-for="(post, index) in posts"
                :key="'post' + index + 1"
              >
                <q-card>
                  <q-card-section>
                    <h6 class="q-ma-none">{{ post.title }}</h6>
                    <p>{{ post.caption }}</p>
                  </q-card-section>
                  <q-card-actions align="around">
                    <q-btn class="" flat color="grey-8" icon="more_horiz">
                      <q-menu fit>
                        <q-list>
                          <q-item clickable>
                            <q-item-section>
                              <q-icon size="25px" name="edit" />
                            </q-item-section>
                          </q-item>
                          <q-separator />
                          <q-item clickable>
                            <q-item-section>
                              <q-icon size="25px" color="pink-6" name="delete" />
                            </q-item-section>
                          </q-item>
                        </q-list>
                      </q-menu>
                    </q-btn>
                    <q-btn class="" flat color="pink-7" icon="visibility" />
                  </q-card-actions>
                </q-card>
              </div>
            </div>
            <q-btn
              label="create your first Post"
              class="full-width"
              outline
              rounded
              @click="$router.push('/posts/create')"
            />
          </q-tab-panel>

          <q-tab-panel name="followers">
            <div class="text-h6">Alarms</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>

          <q-tab-panel name="followings">
            <div class="text-h6">Movies</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>
        </q-tab-panels>
      </div>
    </div>
  </q-page>
</template>

<script>
import { onMounted, ref } from "vue";
import { api } from "src/boot/axios";
export default {
  // name: 'PageName',
  setup() {
    const title = ref("");
    const titleRef = ref("");
    const file = ref();
    const description = ref("");
    const descriptionRef = ref("");
    const tab = ref("posts");
    const posts = ref([]);
    function fetchPost() {
      api.get("api/posts").then((r) => {
        posts.value = r.data;
      });
    }
    onMounted(() => {
      fetchPost();
    });
    return {
      posts,
      tab,
      title,
      titleRef,
      file,
      description,
      descriptionRef,
      fetchPost,
    };
  },
};
</script>
