<template>
  <q-page>
    <!-- Main Content -->
    <div class="row page flex-center">
      <div class="col-10 col-xl-3 col-lg-4 col-md-4 col-sm-4 hideme">
        <q-item-label header>
          <img
            data-aos="fade-in"
            data-aos-duration="3000"
            src="/Peesopic.png"
            alt="Logo"
            class="imagebackground"
          />
          <img />
        </q-item-label>
      </div>

      <div
        class="col-11 col-xl-4 col-lg-3 col-md-5 col-sm-5 div_wecanMakeitHappen"
      >
        <q-page-section>
          <div>
            <p
              data-aos="fade-right"
              data-aos-duration="1500"
              style="font-size: 15px; color: #48b544"
            >
              We can make it <span><b>HAPPEN</b></span>
            </p>
          </div>
          <h3 data-aos="fade-up" data-aos-duration="1500" class="CPEESO">
            <span style="">CPESCDO</span> <br />
          </h3>
          <h4 data-aos="fade-up" data-aos-duration="1500" class="tagumcity">
            TAGUM CITY
          </h4>

          <div class="row CPEECO_CONTENT">
            <div class="col-11 col-xl-8 col-lg-11 col-md-9 col-sm-10">
              <p
                data-aos="fade-left"
                data-aos-duration="1500"
                style="justify-content: space-around"
                class="publicEducation"
              >
                The Public Education and Employment Services Office (CPESCDO) is a
                government agency tasked in providing education and employment
                services under the Department of Labor and Employment (DOLE).
              </p>
            </div>
          </div>
        </q-page-section>
      </div>
      <div class="col-11 col-xl-2 col-lg-2 col-md-5 col-sm-5 loginform">
        <q-card
          class="shadow-24"
          style="width: 400px; height: auto; border-radius: 13px"
        >
          <q-card-section class="q-mx-md">
            <div>
              <img
                class="imagebackground"
                src="public/TagumLogo.png"
                alt="Tagum City"
                style="height: 14%; width: 14%"
              />
              <p class="CPEESO_ni">CPESCDO LOGIN</p>
            </div>
          </q-card-section>

          <q-card-section class="q-mt-md">
            <q-card-section style="margin-top: -90px">
              <h4><b> Welcome Back!</b></h4>
            </q-card-section>

            <q-card-section style="margin-top: -72px">
              <p>Please Enter Login Details Below</p>
            </q-card-section>

            <q-form class="q-px-md">
              <div class="custom-input-container">
                <input
                  @input="clearErrorMessage"
                  ref="username"
                  v-model="txtusername"
                  placeholder="UserName"
                  class="custom-input"
                  @keydown.enter="LOGIN"
                />
                <q-icon name="people" class="input-icon" />
              </div>
              <div class="custom-input-container" style="margin-top: 15px">
                <q-icon name="lock" class="input-icon" />
                <input
                  @input="clearErrorMessage"
                  type="password"
                  v-model="txtpassword"
                  class="custom-input"
                  placeholder="Password"
                  @keydown.enter="LOGIN"
                />
              </div>

              <div
                v-if="errorMessage"
                class="q-px-md q-mt-md tooltip"
                style="color: red; text-align: center"
              >
                {{ errorMessage }}
              </div>
            </q-form>

            <div class="q-px-lg q-mt-lg marginleft">
              <button class="custom_input_button" @click="LOGIN()">
                LOGIN
              </button>
            </div>

            <div class="q-px-lg marginleft_1">
              <q-card-section>
                <p style="font-size: medium">
                  Don't have an account?<span>
                    <q-btn
                      @click="goToPage('/SignUpPage')"
                      class="signup"
                      flat
                      rounded
                      >Sign Up</q-btn
                    >
                  </span>
                </p>
              </q-card-section>
            </div>
          </q-card-section>

          <q-card-section class="text-center q-pa-sm"> </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import AOS from "aos";
import "aos/dist/aos.css";
import { defineComponent, TrackOpTypes } from "vue";
import { useQuasar } from "quasar";
import { Loading } from "quasar";
import { useLoginCheck } from "src/stores/SignUp_Store";

export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        subject: "",
        message: "",
      },

      errorMessage: "",

      txtpassword: "",
      txtusername: "",

      startNumber: 0,
      dialog_sched: false,
      duration: 1500, // duration of the animation in milliseconds
      startTime: null,
      displayNumber_TotalJobs: 0,
      displayNumber_Vacancies: 0,
      totalJobs: 453, // Replace with actual data
      totalVacancies: 1500, // Replace with actual data
      LoginPage: [],
    };
  },
  setup() {
    const $q = useQuasar();

    return {
      /*  WrongEmail() {
        $q.notify({
          icon: "email",
          color: "red",
          message: "Invalid Email or Password",
          position: "center",
          timeout: "2000",
        });
      }, */
    };
  },

  methods: {
    clearErrorMessage() {
      this.errorMessage = "";
    },

    WrongEmail() {
      this.errorMessage = "Invalid Email or Password !"; // Update this line
    },

    goToPage(page) {
      this.$router.push(page);
    },

    showLoading() {
      this.$q.loading.show();
    },
    hideLoading() {
      this.$q.loading.hide();
    },

    async LOGIN() {
      /*  this.clearErrorMessage(); */
      const store = useLoginCheck();
      let data = new FormData();
      data.append("username", this.txtusername);
      data.append("password", this.txtpassword);

      try {
        await store.Login_Store(data).then((res) => {
          this.LoginPage = store.LogIn;
          console.log("Response from LOGIN:", this.LoginPage);
        });
      } catch (error) {
        console.error("Error LOGIN", error);
      } finally {
        if (this.LoginPage.authenticated == false) {
          this.WrongEmail();
        } else {
          localStorage.setItem("Login", this.LoginPage.LoginID);
          this.showLoading();
          setTimeout(() => {
            this.$router.push("/DashBoard");
            this.hideLoading();
          }, 3000); // 3-second delay
        }
      }
    },

    handleClick() {
      // Handle button click
      console.log("Button clicked");
    },

    animateNumber(timestamp) {
      if (!this.startTime) this.startTime = timestamp;
      const progress = timestamp - this.startTime;
      const progressFraction = progress / this.duration;
      this.displayNumber_Vacancies = Math.min(
        Math.floor(
          this.startNumber +
            progressFraction * (this.totalVacancies - this.startNumber)
        ),
        this.totalVacancies
      );
      if (progress < this.duration) {
        requestAnimationFrame(this.animateNumber);
      } else {
        this.displayNumber_Vacancies = this.totalVacancies;
      }
    },
    startAnimation() {
      this.startTime = null;
      requestAnimationFrame(this.animateNumber);
    },

    animateNumber_TotalJobs(timestamp) {
      if (!this.startTime) this.startTime = timestamp;
      const progress = timestamp - this.startTime;
      const progressFraction = progress / this.duration;
      this.displayNumber_TotalJobs = Math.min(
        Math.floor(
          this.startNumber +
            progressFraction * (this.totalJobs - this.startNumber)
        ),
        this.totalJobs
      );
      if (progress < this.duration) {
        requestAnimationFrame(this.animateNumber_TotalJobs);
      } else {
        this.displayNumber_TotalJobs = this.totalJobs;
      }
    },
    startAnimation_TotalJobs() {
      this.startTime = null;
      requestAnimationFrame(this.animateNumber_TotalJobs);
    },
  },

  components: {},

  mounted() {
    this.$refs.username.focus();
    AOS.init();
    this.startAnimation_TotalJobs();
    this.startAnimation();
  },
};
</script>

<style scoped>
.tooltip {
  position: absolute;
  left: 5%;
  /*   transform: translateX(-50%); */
  bottom: -95px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.custom-input-container {
  position: relative;
  width: 340px;
  margin-top: -20px;
}

.custom_input_button:active {
  background: linear-gradient(
    40deg,
    #343a31,
    /* Darker green for the background when clicked */ #2a3529
      /* Darker shade for the gradient */
  );
  border-color: #064d2c; /* Darker border color when clicked */
}

.signup {
  color: rgb(55, 55, 149);
}

.custom_input_button {
  width: 105%;
  height: 40px;
  padding-left: 20px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(253, 253, 253);
  background: linear-gradient(
    40deg,
    #279f27,
    #5fc331
  ); /* Gradient from green to white */
  color: white;

  cursor: pointer; /* Changes the cursor to a hand pointer */
}

.marginleft {
  margin-left: -8px;
  margin-right: 5px;
}

.marginleft_1 {
  margin-left: -15px;
  margin-right: 5px;
  margin-top: 10px;
}

.custom-input {
  width: 100%;
  height: 40px;
  padding-left: 40px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(113, 126, 126);
  outline: none;
  box-sizing: border-box;
}

.input-icon {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  font-size: 20px;
  color: gray;
}

.displayNumber {
  font-weight: 500;
}

.imagebackground {
  height: 300px;
  margin-right: 8px;
  border-radius: 12px;
}

.CPEESO_ni {
  margin-bottom: 22px;
  font-size: 20px;
  font-weight: bold;
  color: #585a58;
}

.CPEESO {
  margin-top: 15px;
  font-weight: bold;
  color: #3fb03f;
}

.CPEECO_CONTENT {
  margin-top: 40px;
  margin-left: 10px;
}

.div_wecanMakeitHappen {
  margin-left: -33px;
  margin-right: 95px;

  margin-top: 19px;
}

@media only screen and (max-width: 1799px) {
  .div_wecanMakeitHappen {
    margin-left: -120px;
    margin-right: 150px;
    margin-top: 19px;
  }
}

@media only screen and (max-width: 1564px) {
  .div_wecanMakeitHappen {
    margin-left: -80px;
    margin-top: 19px;
  }

  .loginform {
    margin-left: -70px;
  }
}

@media only screen and (max-width: 1488px) {
  .div_wecanMakeitHappen {
    margin-left: -40px;
    margin-top: 19px;
  }
}

@media only screen and (max-width: 1439px) {
  /*  .loginform {
    margin-top: px;
  } */

  .hideme {
    display: none;
  }
  .div_wecanMakeitHappen {
    display: none;
  }
}
.displayNumber_Margin_OverlAllVacancies {
  margin-top: 90px;
}

@media only screen and (max-width: 1432px) {
  .displayNumber_Margin_OverlAllVacancies {
    margin-top: 60px;
  }

  .displayNumber {
    font-weight: 500;
    font-size: 24px;
  }

  .imagebackground {
    height: 250px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .CPEESO {
    margin-top: 10px;
    font-weight: bold;
    color: #3fb03f;
  }

  .CPEECO_CONTENT {
    margin-top: 17px;
  }

  .div_wecanMakeitHappen {
    margin-left: -19px;
    margin-top: 19px;
  }
}

@media only screen and (max-width: 1353px) {
  .div_wecanMakeitHappen {
    margin-left: 20px;

    margin-top: 19px;
  }
}

@media only screen and (max-width: 1223px) {
  .div_wecanMakeitHappen {
    margin-left: 40px;
    margin-top: 19px;
  }

  .displayNumber {
    font-weight: 500;
    font-size: 20px;
  }

  .captionTotalOverAll {
    font-size: 10px;
    margin-top: -48px;
    font-family: sans-serif;
  }
}

@media only screen and (max-width: 1178px) {
  .div_wecanMakeitHappen {
    margin-left: 45px;
    margin-top: 19px;
  }

  .display_Content {
    margin-left: -20px;
  }
}

@media only screen and (max-width: 1144px) {
  .div_wecanMakeitHappen {
    margin-left: 55px;
  }

  /*  .loginform {
    margin-top: -150px;
  } */
}

.captionTotalOverAll {
  font-size: 20px;
  margin-top: -48px;
  font-family: sans-serif;
}

.flex-center1 {
  margin-top: -640px;
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
  height: 100vh; /* Full height to ensure vertical centering */
}

.flex-center {
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
  height: 100vh; /* Full height to ensure vertical centering */
}

.page {
  /*  margin-right: 100px;
  margin-left: 90px; */
  margin-top: 80px;
}

@media only screen and (max-width: 1119px) {
  .page {
    margin-right: 40px;
    margin-left: 90px;
    margin-top: 80px;
  }
}

@media only screen and (max-width: 1059px) {
  .page {
    margin-right: 20px;
    margin-left: 20px;
    margin-top: 80px;
  }
}

@media only screen and (max-width: 1023px) {
  .page {
    margin-right: 20px;
    margin-left: 15px;
    margin-top: 80px;
  }

  .CPEECO_CONTENT {
    margin-top: -12px;
  }
}

@media only screen and (max-width: 964px) {
  .page {
    margin-right: 20px;
    margin-left: -40px;
    margin-top: 80px;
  }

  .display_Content {
    display: none;
  }

  .div_wecanMakeitHappen {
    margin-left: 120px;
  }
}

@media only screen and (max-width: 700px) {
  .div_wecanMakeitHappen {
    margin-left: 150px;
    margin-right: -45px;
  }

  .CPEECO_CONTENT {
    margin-top: -17px;
  }
}
.tagumcity {
  margin-top: -35px;
  color: #48b544;
  font-size: 50px;
  margin-left: 20px;
}

@media only screen and (max-width: 659px) {
  .imagebackground {
    height: 200px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .CPEESO {
    margin-top: -17px;
    font-weight: bold;
    color: #3fb03f;
    font-size: 35px;
  }

  .CPEESO {
    margin-top: -20px;
    font-weight: bold;
    color: #3fb03f;
    font-size: 25px;
  }

  .tagumcity {
    margin-top: -50px;
    color: #48b544;
    font-size: 10px;
    margin-left: 10px;
  }

  .div_wecanMakeitHappen {
    margin-left: 110px;
    margin-top: 19px;
  }
  .publicEducation {
    font-size: 12px;
  }
}

.tagumcity {
  margin-top: -50px;
  color: #48b544;
  font-size: 18px;
  margin-left: 10px;
}

@media only screen and (max-width: 600px) {
  .imagebackground {
    height: 200px;
    margin-top: -10px;
    margin-left: 15px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .div_wecanMakeitHappen {
    margin-left: 55px;
    margin-top: -370px;
  }

  .loginform {
    margin-left: 180px;
    margin-right: 80px;
  }
}

@media only screen and (max-width: 375px) {
  .imagebackground {
    height: 200px;
    margin-top: -30px;
    margin-left: 15px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .div_wecanMakeitHappen {
    margin-left: 55px;
    margin-top: -210px;
  }

  .loginform {
    margin-left: 95px;
    margin-right: 80px;
  }

  .custom-input-container {
    position: relative;
    width: 320px;
    margin-top: -20px;
  }
}

.page2 {
  margin-right: 100px;
  margin-left: 120px;
  margin-top: 50px;
}

.page p {
  text-align: justify;
}
</style>
