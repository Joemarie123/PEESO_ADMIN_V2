<template>
  <!--   <q-page> -->

  <div class="custom-mx-xxl q-my-md">
    <div class="profile-container">
      <div class="profile-avatar">
        <q-avatar class="avatar">
          <img :src="imgurl" />
        </q-avatar>
      </div>
      <div class="profile-details" style="margin-top: -40px">
        <h2 class="title" style="margin-bottom: -10px">
          <b>
            <span
              v-if="userinfo.data && userinfo.data.length > 0"
              style="font-size: 16px; font-weight: bold"
            >
              {{ userinfo.data[0].Company_name }}
            </span></b
          >
        </h2>
        <p
          v-if="userinfo.data && userinfo.data.length > 0"
          style="font-size: 12px; font-weight: inherit"
          class="title"
        >
          {{ userinfo.data[0].Company_address }}
        </p>
        <br />
        <br />
        <p style="margin-bottom: -10px; margin-top: 20px; font-weight: 500">
          <!--   SALARY -->
        </p>
        <p></p>
        <p style="margin-bottom: -10px; margin-top: -2px; font-weight: 500"></p>
        <p></p>
        <p style="margin-bottom: -10px; margin-top: -2px; font-weight: 500"></p>
        <p></p>
      </div>
    </div>
  </div>
  <div class="row">
    <div
      class="q-my-sm q-mx-lg q-ml-xl col-xl-6 col-lg-6 col-md-11 col-sm-11 col-xs"
    >
      <q-card style="border-radius: 12px">
        <MyCalendar />
      </q-card>
    </div>
    <div
      class="q-my-sm q-mx-sm col-xl-5 col-lg-5 col-md-11 col-sm-11 responsive"
    >
      <q-card style="border-radius: 12px">
        <ShortListed_Scheduled />
      </q-card>
    </div>
  </div>

  <!--   </q-page> -->
</template>

<script>
import { useLoginCheck } from "src/stores/SignUp_Store";
import MyCalendar from "../components/MyCalendar.vue";
import ShortListed_Scheduled from "../components/ShortListed_Scheduled.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "MonthSlotWeek",
  data() {
    return {
      userinfo: [],
      imgurl: "",
    };
  },
  components: {
    MyCalendar,
    ShortListed_Scheduled,
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
});
</script>

<style scoped>
@media only screen and (max-width: 1439px) {
  .responsive {
    margin-left: 45px; /* or any desired value */
  }
}

.custom-mx-xxl {
  margin-left: 45px; /* or any desired value */
  margin-right: 60px; /* or any desired value */
}

@media only screen and (max-width: 1904px) {
  .custom-mx-xxl {
    margin-left: 45px; /* or any desired value */
    margin-right: 35px; /* or any desired value */
  }
}

.profile-card {
  max-width: 100%;
  margin: auto;
  margin-top: 2%;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.skill-card {
  max-width: 70%;
  margin: auto;
  margin-top: 2%;
  border-radius: 5px;
  overflow: hidden;
}

.profile-container {
  border-radius: 12px;
  display: flex;
  align-items: center;
  background: linear-gradient(to bottom, rgb(0, 0, 0) 50%, #f0ecec 50%);
  padding: 20px;
}

.profile-avatar {
  flex: 0 0 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 20px;
  background: white;
  padding: 10px;
  border-radius: 50%;
}

.avatar {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
}

.profile-details {
  flex: 1;
  padding: 10px;
  text-align: left;
}
.title {
  color: white;
}

.profile-details h2 {
  margin: 0 0 10px 0;
  font-size: 24px;
}

.profile-details p {
  margin: 5px 0;
  font-size: 15px;
}

/* Responsive design */
@media (max-width: 768px) {
  .profile-container {
    flex-direction: column;
    align-items: center;
    background: linear-gradient(to bottom, rgb(3, 69, 113) 50%, #ffffff 50%);
    padding: 20px;
  }

  .profile-avatar {
    margin-right: 0;
    margin-bottom: 20px;
    background: white; /* Blue background for the avatar */
  }

  .profile-details {
    text-align: center;
    background: #ffffff; /* White background for the details */
    padding: 20px;
    border-radius: 8px;
  }
  .title {
    color: black;
  }
}
</style>
