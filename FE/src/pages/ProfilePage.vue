<template>
  <q-page padding>
    <!-- content -->
    <q-form @submit="updateProfile">
      <q-input name="full_name" v-model="fullName" label="Full Name" />
      <q-file name="picture" filled v-model="file" label="Filled" />
      <input type="hidden" name="_method" value="PUT">
      <q-input name="work_email" v-model="workEmail" label="Work Email" />
      <q-input name="work_mobile" v-model="workMobile" label="Work Moblie" />
      <!-- <q-select v-model="gender" :options="options" label="Choose Your Gender" /> -->

      <q-btn type="submit" class="q-my-md" color="green" label="submit" />
    </q-form>
    <form action="" enctype="multipart/form-data"></form>
  </q-page>
</template>

<script>
import { api } from 'src/boot/axios';
import { onMounted, ref } from 'vue';

export default {
  // name: 'PageName',
  setup() {
    const file = ref(null)
    const fullName = ref(null);
    const workEmail = ref(null);
    const workMobile = ref(null);
    const gender = ref(null);
    const profileId = ref(null)
    // const public = ref(null);

    function fetchProfile() {
      api.get('api/profile')
        .then(res => {
          console.log(res.data);
          fullName.value = res.data.full_name;
          file.value = res.data.image?.res.data.image.url
          workEmail.value = res.data.work_email;
          workMobile.value = res.data.work_mobile;
          profileId.value = res.data.id;
        }).catch(err => {
          console.log(err.data);
        })
    }

    onMounted(() => {
      fetchProfile()
    })

    function updateProfile(event) {
      const formData = new FormData(event.target);
      api
        .post(`api/profile/${profileId.value}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(res => {
          console.log(res.data);
        })
        .catch(err => {
          console.log(err.data);
        })
    }
    return {
      file,
      fullName,
      workMobile,
      gender,
      workEmail,
      updateProfile
    }
  }
}
</script>
