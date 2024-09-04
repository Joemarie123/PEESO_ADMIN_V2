<template>
  <q-page>
    <!-- Main Content -->
    <div class="row page flex-center">
      <div class="col-10 col-xl-3 col-lg-4 col-md-4 col-sm-4">
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
        class="col-11 col-xl-6 col-lg-5 col-md-5 col-sm-5 div_wecanMakeitHappen"
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
            <div class="col-11 col-xl-6 col-lg-7 col-md-9 col-sm-10">
              <p
                data-aos="fade-left"
                data-aos-duration="1500"
                style="justify-content: space-around"
                class="publicEducation"
              >
                The Public Education and Employment Services Office (CPESCDO) is
                a government agency tasked in providing education and employment
                services under the Department of Labor and Employment (DOLE).
              </p>
            </div>
          </div>
        </q-page-section>
      </div>

      <div col="2" class="display_Content">
        <div>
          <h4 style="margin-top: 30px">
            <span class="displayNumber">{{ displayNumber_TotalJobs }}+</span>
          </h4>
          <h4 class="captionTotalOverAll">Over All Job Postings</h4>
        </div>

        <div>
          <h4 class="displayNumber_Margin_OverlAllVacancies">
            <span class="displayNumber">{{ displayNumber_Vacancies }}+</span>
          </h4>
          <p class="captionTotalOverAll">Over All Vacancies</p>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import AOS from "aos";
import "aos/dist/aos.css";

export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        subject: "",
        message: "",
      },

      startNumber: 0,
      dialog_sched: false,
      duration: 1500, // duration of the animation in milliseconds
      startTime: null,
      displayNumber_TotalJobs: 0,
      displayNumber_Vacancies: 0,
      totalJobs: 453, // Replace with actual data
      totalVacancies: 1500, // Replace with actual data
    };
  },

  methods: {
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
    AOS.init();
    this.startAnimation_TotalJobs();
    this.startAnimation();
  },
};
</script>

<style scoped>
.displayNumber {
  font-weight: 500;
}

.imagebackground {
  height: 300px;
  margin-right: 8px;
  border-radius: 12px;
}

.CPEESO {
  margin-top: 15px;
  font-weight: bold;
  color: #3fb03f;
}

.CPEECO_CONTENT {
  margin-top: 40px;
}

.div_wecanMakeitHappen {
  margin-left: 15px;
  margin-top: 19px;
}

@media only screen and (max-width: 1564px) {
  .div_wecanMakeitHappen {
    margin-left: 10px;
    margin-top: 19px;
  }
}

/* @media only screen and (max-width: 1919px) {
  .div_wecanMakeitHappen {
    margin-left: -19px;
    margin-top: 19px;
  }
} */
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
  margin-right: 100px;
  margin-left: 90px;
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
  margin-top: -55px;
  color: #48b544;
  font-size: 20px;
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
