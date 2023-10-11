<template>
  <q-page padding>
    <!-- content -->
    <div class="row justify-center">
      <div  class="col-auto text-center">
        <q-avatar size="80px">
          <q-img v-if="userData" src="/avatar.webp" />
          <q-skeleton v-else type="circle" />
        </q-avatar>
        <h4 v-if="userData" class="text-h6 q-ma-none">{{ userData.profile.full_name }}</h4>
        <q-skeleton v-else type="text" />
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
          <q-tab name="discover" label="Discover" />
          <q-tab name="posts" label="Posts" />
          <q-tab name="followers" label="Followers" />
          <q-tab name="followings" label="Followings" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="discover" class="q-gutter-y-md">
            <div class="text-h6">Friends Posts</div>
            <div
              v-if="AllPosts.length < 1"
              class="text-grey-8 text-h6 text-center"
            >
              You dont have any posts!
            </div>
            <div v-else class="row q-col-gutter-sm">
              <div
                class="col-6"
                v-for="(post, index) in AllPosts"
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
                              <q-icon size="25px" @click="$router.push(`/posts/edit/${post.id}`)" name="edit" />
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
                    <q-btn class="" flat color="grey-7" icon="favorite_outline" />
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
                              <q-icon size="25px" @click="$router.push(`/posts/edit/${post.id}`)" name="edit" />
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
    <q-dialog v-model="taeed" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <span class="q-ml-sm">
            R U Shure to delete the Post Titled "{{ selectedPost.title }}"?
          </span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="yes" @click="deletePost" color="pink-6" />
          <q-btn flat label="no" color="grey-7" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
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
    const AllPosts = ref([]);
    const taeed = ref(false);
    const selectedPost = ref(null);
    const selectedPostIndex = ref(null);
    const userData = ref(null)
    function deletePost() {
      api.delete("api/posts/" + selectedPost.value.id).then((r) => {
        if (r.data.status) {
          posts.value.splice(selectedPostIndex.value, 1)
          taeed.value = false
        }
      });
    }
    function fetchPost() {
      api.get("api/posts").then((r) => {
        posts.value = r.data;
      });
    }
    function fetchAllPost () {
      api.get("api/public/posts").then((r) => {
        AllPosts.value = r.data;
      });
    }
    fetchAllPost()
    function editPost () {

    }
    function showConfirmation(id, index) {
      selectedPost.value = posts.value[index];
      selectedPostIndex.value = index
      taeed.value = true;
    }
    function fetchUser() {
      api.get('api/user')
        .then(r => {
          userData.value = r.data
      })
    }
    onMounted(() => {
      fetchPost();
      fetchUser();
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
      showConfirmation,
      taeed,
      selectedPost,
      deletePost,
      selectedPostIndex,
      editPost,
      fetchAllPost,
      AllPosts,
      fetchUser,
      userData
    };
  },
};
</script>
