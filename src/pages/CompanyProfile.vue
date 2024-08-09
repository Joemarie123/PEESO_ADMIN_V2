<template>
  <q-page>
    <q-card class="profile-card" style="border-radius: 12px">
      <input
        type="file"
        @change="onBannerUpload"
        accept="image/*"
        ref="bannerInput"
        class="banner-upload-input"
      />
      <q-img
        style="border-radius: 12px"
        :src="bannerSrc"
        class="banner-image"
      />

      <div class="text-right" style="margin-right: 30px; margin-top: 12px">
        <q-btn icon="camera" @click="triggerBannerUpload"> EDIT BANNER</q-btn>
      </div>

      <div class="profile-picture-wrapper">
        <input
          type="file"
          @change="onProfilePictureUpload"
          accept="image/*"
          ref="profilePictureInput"
          class="profile-picture-upload-input"
        />
        <q-avatar
          size="100px"
          class="profile-picture"
          @click="triggerProfilePictureUpload"
        >
          <img :src="imgurl" />
        </q-avatar>
      </div>
      <div class="profile-info">
        <h2 class="profile-name">
          <b>
            <span v-if="userinfo.data && userinfo.data.length > 0">
              {{ userinfo.data[0].Company_name }}
            </span></b
          >
        </h2>
        <p
          v-if="userinfo.data && userinfo.data.length > 0"
          
          class="title profile-description"
        >
          {{ userinfo.data[0].Company_address }}
        </p>
      </div>
    </q-card>

    <div class="row q-mx-lg">
      <div style="margin: -35px; margin-left: 7px">
        <h5><b>ABOUT US</b></h5>
      </div>
      <q-card class="about-us-card custom-card">
  <div class="q-pa-xs">
    <q-editor
      v-model="txtdescription"
      :dense="$q.screen.lt.md"
      :toolbar="toolbarOptions"
      :fonts="{
        arial: 'Arial',
        arial_black: 'Arial Black',
        comic_sans: 'Comic Sans MS',
        courier_new: 'Courier New',
        impact: 'Impact',
        lucida_grande: 'Lucida Grande',
        times_new_roman: 'Times New Roman',
        verdana: 'Verdana',
      }"
    />
  </div>
</q-card>
    </div>
  </q-page>
</template>

<script>
import { useLoginCheck } from "src/stores/SignUp_Store";
import { useQuasar } from "quasar";
import { ref } from "vue";
export default {
  name: "ProfilePage",
  data() {
    return {
      userinfo: [],
      userData: null, // Initialize userData
      imgurl: "",
      txtdescription: "",
      bannerSrc: "/banner_1.jpg",
      profilePictureSrc: "https://cdn.quasar.dev/img/avatar1.jpg",
    };
  },

  created() {
    this.retrievedLogin = localStorage.getItem("Login");
    console.log("Retrieved Login Local Storage:", this.retrievedLogin);

    if (!this.retrievedLogin) {
      console.error("No login found in localStorage.");
      return;
    }

    const store = useLoginCheck();
    let data = new FormData();
    data.append("LoginID", this.retrievedLogin);

    store
      .RetrievedData_function(data)
      .then((res) => {
        this.userinfo = store.RetrievedData;

        // Check if userinfo and the data array exist
        if (
          !this.userinfo ||
          !this.userinfo.data ||
          !this.userinfo.data.length
        ) {
          console.error("Invalid user info retrieved.");
          return;
        }

        // Directly access the first element of the data array
        this.userData = this.userinfo.data[0];
        if (!this.userData) {
          console.error("Invalid user info retrieved.");
          return;
        }

        console.log("Data Retrieved:", this.userData);

        const baseUrl =
          "http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/";
        const companyName = encodeURIComponent(this.userData.Company_name);
        const companyLogo = this.userData.Company_Logo
          ? encodeURIComponent(this.userData.Company_Logo)
          : "Company_Profile/e5d3982a1f7a511f789d.jpg";

        this.imgurl =
          companyLogo === "Company_Profile/e5d3982a1f7a511f789d.jpg"
            ? `${baseUrl}${companyLogo}`
            : `${baseUrl}${companyName}/${companyLogo}`;
        console.log("Image URL:", this.imgurl);
      })
      .catch((error) => {
        console.error("Error retrieving data:", error);
      });
  },

  methods: {
    triggerBannerUpload() {
      this.$refs.bannerInput.click();
    },
    triggerProfilePictureUpload() {
      this.$refs.profilePictureInput.click();
    },
    onBannerUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.bannerSrc = URL.createObjectURL(file);
      }
    },
    onProfilePictureUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.profilePictureSrc = URL.createObjectURL(file);
      }
    },
  },
  computed: {
    toolbarOptions() {
      if (this.$q.screen.lt.sm) {
        // Toolbar options for small screens
        return [
          ['bold', 'italic', 'underline'],
          [{ label: this.$q.lang.editor.align, icon: this.$q.iconSet.editor.align, fixedLabel: true, list: 'only-icons', options: ['left', 'center', 'right', 'justify'] }],
          ['undo', 'redo'],
        ];
      } else if (this.$q.screen.lt.md) {
        // Toolbar options for medium screens
        return [
          [{ label: this.$q.lang.editor.align, icon: this.$q.iconSet.editor.align, fixedLabel: true, list: 'only-icons', options: ['left', 'center', 'right', 'justify'] }],
          ['bold', 'italic', 'underline'],
          [{ label: this.$q.lang.editor.fontSize, icon: this.$q.iconSet.editor.fontSize, fixedLabel: true, fixedIcon: true, list: 'no-icons', options: ['size-1', 'size-2', 'size-3', 'size-4', 'size-5', 'size-6', 'size-7'] }],
          ['undo', 'redo'],
        ];
      } 
      else {
        // Toolbar options for large screens
        return [
          [{ label: this.$q.lang.editor.align, icon: this.$q.iconSet.editor.align, fixedLabel: true, list: 'only-icons', options: ['left', 'center', 'right', 'justify'] }],
          ['bold', 'italic', 'underline', 'subscript'],
          [{ label: this.$q.lang.editor.fontSize, icon: this.$q.iconSet.editor.fontSize, fixedLabel: true, fixedIcon: true, list: 'no-icons', options: ['size-1', 'size-2', 'size-3', 'size-4', 'size-5', 'size-6', 'size-7'] }],
          [{ label: this.$q.lang.editor.defaultFont, icon: this.$q.iconSet.editor.font, fixedIcon: true, list: 'no-icons', options: ['default_font', 'arial', 'arial_black', 'comic_sans', 'courier_new', 'impact', 'lucida_grande', 'times_new_roman', 'verdana'] }],
          ['removeFormat'],
          ['unordered', 'ordered', 'outdent', 'indent'],
          ['undo', 'redo'],
        ];
      }
    },
  },
};
</script>

<style scoped>
.profile-card {
  position: relative;
  margin: 20px;
}

.banner-image {
  width: 100%;
  height: 200px;
  object-fit: cover; /* Ensure the image covers the container while maintaining aspect ratio */
  cursor: pointer;
}

.profile-picture-wrapper {
  position: absolute;
  top: 200px; /* Adjust based on banner height */
  left: 20px;
  transform: translateY(-50%);
  border-radius: 12px;
  border-radius: 50%;
}

.profile-picture {
  width: 100px;
  height: 100px;
  cursor: pointer;
}

.profile-info {
  margin-top: -40px;
  text-align: left;
  padding: 60px 20px 20px; /* Adjust padding based on profile picture position */
}

.profile-name {
  margin: 0;
  font-size: 24px;
  font-weight: bold;
}

.profile-description {
  margin: 0;
  color: #666;
}

.banner-upload-input,
.profile-picture-upload-input {
  display: none;
}

.about-us-card{
  width: 1800px;
}


</style>
