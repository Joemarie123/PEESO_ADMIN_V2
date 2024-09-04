<template>
  <q-layout view="lHh Lpr lFf">
    <q-header class="headercolor" elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          style="color: black"
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          <div class="row">
            <div class="col-6">
              <q-input borderless v-model="text">
                <template v-slot:prepend>
                  <q-icon name="search" />
                </template>
              </q-input>
            </div>
          </div>
        </q-toolbar-title>

        <div>
          <q-icon style="color: black" name="notifications" size="25px" />
        </div>
        <div class="q-pa-md">
          <q-icon style="color: black" name="message" size="25px" />
        </div>

        <div class="q-pa-sm">
          <q-btn
            flat
            round
            dense
            style="position: relative"
            class="transparent-btn"
          >
            <q-avatar>
              <img :src="imgurl" />
            </q-avatar>
            <q-badge class="badge">
              <q-icon name="arrow_drop_down" color="black" />
            </q-badge>
            <q-menu auto-close>
              <q-list dense>
                <!--  <q-item class="GL__menu-link-signed-in">
                  <q-item-section>
                    <div>Signed in as <strong>Go</strong></div>
                  </q-item-section>
                </q-item> -->

                <q-item
                  clickable
                  class="GL__menu-link"
                  @click="$router.push({ path: '/Profile' })"
                >
                  <q-item-section>Company Profile</q-item-section>
                </q-item>
                <!--     <q-item
                  clickable
                  class="GL__menu-link"
                  @click="$router.push({ path: '/PDS' })"
                >
                  <q-item-section>Personal Data Sheet</q-item-section>
                </q-item> -->
                <q-item clickable class="GL__menu-link">
                  <q-item-section>Settings</q-item-section>
                </q-item>
                <q-separator></q-separator>
                <q-item clickable class="GL__menu-link">
                  <q-item-section @click="$router.push({ path: '/LoginPage' })"
                    >Sign out</q-item-section
                  >
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <div class="row">
          <div class="col-2">
            <q-item-label header>
              <img
                src="/TagumLogo.png"
                alt="Logo"
                style="height: 32px; margin-right: 8px"
              />
              <img />
            </q-item-label>
          </div>

          <div class="col-10">
            <q-item-label class="q-mt-sm" header>
              <span style="color: green; font-weight: bold; font-size: 20px"
                >CPESCDO TAGUM CITY</span
              >
            </q-item-label>
            <div style="margin-top: -27px">
              <q-item-label header>
                <p style="font-size: 12px; font-weight: inherit">
                  Welcome to Tagum City PESCDO
                </p>
              </q-item-label>
            </div>
          </div>
        </div>

        <div class="row q-mt-md">
          <div class="col-12 text-center">
            <q-avatar size="80px" square="">
              <img :src="imgurl" alt="Avatar" style="border-radius: 10px" />
            </q-avatar>
            <q-item-label class="q-mt-md">
              <span
                v-if="userinfo.data && userinfo.data.length > 0"
                style="font-size: 16px; font-weight: bold"
              >
                {{ userinfo.data[0].Company_name }}
              </span>
            </q-item-label>
            <div style="margin-top: -18px">
              <q-item-label header>
                <p
                  v-if="userinfo.data && userinfo.data.length > 0"
                  style="font-size: 12px; font-weight: inherit"
                >
                  {{ userinfo.data[0].Company_address }}
                </p>
              </q-item-label>
            </div>
          </div>
        </div>

        <div class="q-mt-sm">
          <!-- <EssentialLink
            class="q-px-lg essential-link"
            v-for="link in essentialLinks"
            :key="link.title"
            v-bind="link"
          /> -->
          <q-list>
            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/DashBoard"
            >
              <q-item-section avatar>
                <q-icon name="school" />
              </q-item-section>

              <q-item-section> Dashboard</q-item-section>
            </q-item>

            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/CompanyProfile"
            >
              <q-item-section avatar>
                <q-icon name="add_business" />
              </q-item-section>

              <q-item-section> Company Profile</q-item-section>
            </q-item>

            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/ViewAllJobs"
            >
              <q-item-section avatar>
                <q-icon name="chat" />
              </q-item-section>

              <q-item-section> Job Postings</q-item-section>
            </q-item>

            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/MyCalendar_Jobs"
            >
              <q-item-section avatar>
                <q-icon name="event_available" />
              </q-item-section>

              <q-item-section> My Calendar</q-item-section>
            </q-item>

            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/"
            >
              <q-item-section avatar>
                <q-icon name="notifications" />
              </q-item-section>

              <q-item-section>Notification</q-item-section>
            </q-item>

            <q-item
              class="q-px-lg essential-link"
              clickable
              v-ripple
              exact
              to="/SetTings"
            >
              <q-item-section avatar>
                <q-icon name="settings" />
              </q-item-section>

              <q-item-section>Settings</q-item-section>
            </q-item>
          </q-list>
        </div>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { useLoginCheck } from "src/stores/SignUp_Store";
import { defineComponent, ref } from "vue";
/* import EssentialLink from "components/EssentialLink.vue"; */

const linksList = [
  {
    title: "Dash Board",

    icon: "school",
  },
  {
    title: "Company Profile",

    icon: "add_business",
  },
  {
    title: "View All Jobs",

    icon: "chat",
  },
  {
    title: "My Calendar",

    icon: "record_voice_over",
  },
  {
    title: "Notifications",

    icon: "rss_feed",
  },
];

export default defineComponent({
  name: "MainLayout",

  data() {
    return {
      // other data properties
      retrievedLogin: "",
      userinfo: [],
      imgurl: "",
    };
  },

  components: {
    /*   EssentialLink, */
  },

  created() {
    this.retrievedLogin = localStorage.getItem("Login");
    console.log("Retrieved Login:", this.retrievedLogin); // Check the retrieved login

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

        if (!this.userinfo || !this.userinfo.data || !this.userinfo.data[0]) {
          console.error("Invalid user info retrieved.");
          return;
        }

        console.log("Data Retrieved:", this.userinfo); // Check the retrieved data

        const baseUrl =
          "http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/";
        const companyName = encodeURIComponent(
          this.userinfo.data[0].Company_name
        );
        const companyLogo = this.userinfo.data[0].Company_Logo
          ? encodeURIComponent(this.userinfo.data[0].Company_Logo)
          : "Company_Profile/e5d3982a1f7a511f789d.jpg";

        this.imgurl =
          companyLogo == "Company_Profile/e5d3982a1f7a511f789d.jpg"
            ? `${baseUrl}${companyLogo}`
            : `${baseUrl}${companyName}/${companyLogo}`;
        console.log("Image URL:", this.imgurl); // Check the final image URL
      })
      .catch((error) => {
        console.error("Error retrieving data:", error); // Log any errors
      });
  },

  setup() {
    const leftDrawerOpen = ref(false);

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },
});
</script>

<style scoped>
.essential-link:hover {
  padding: 8px;
  border: 1px solid transparent;
  border-radius: 20px;
  border-color: rgb(47, 151, 236);

  margin-right: 10px;
  margin-left: 10px;
}

.badge {
  position: absolute;
  bottom: -5px;
  right: -3px;
  background-color: rgba(229, 231, 235, 0.7);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 18px;
  height: 18px;
  font-size: 10px;
  color: black;
}

.headercolor {
  background-color: rgb(255, 255, 255);
}
</style>
