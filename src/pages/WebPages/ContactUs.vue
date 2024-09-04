<template>
  <q-page>
    <!-- Main Content -->
    <div class="row page flex-center">
      <div class="col-8 col-xl-3 col-lg-3 col-md-5">
        <div>
          <q-card
            data-aos="fade-in"
            data-aos-duration="3000"
            class="card_contact_us"
          >
            <div class="q-pa-md">
              <div class="text-left q-mb-md contact_us">
                <h5>Contact Us</h5>
              </div>
              <q-form class="q-gutter-md">
                <q-input
                  filled
                  color="blue-12"
                  v-model="text"
                  dense
                  label="Name"
                >
                  <template v-slot:prepend>
                    <q-icon name="people" />
                  </template>
                </q-input>
                <q-input
                  filled
                  color="blue-12"
                  v-model="text"
                  dense
                  label="Email"
                >
                  <template v-slot:prepend>
                    <q-icon name="mail" />
                  </template>
                </q-input>
                <q-input
                  filled
                  color="blue-12"
                  v-model="text"
                  dense
                  label="Subject"
                >
                  <template v-slot:prepend>
                    <q-icon name="subject" />
                  </template>
                </q-input>
                <div class="" style="max-width: 500px">
                  <q-input
                    v-model="text"
                    filled
                    type="textarea"
                    label="Message"
                  >
                    <template v-slot:prepend>
                      <q-icon name="sms" />
                    </template>
                  </q-input>
                </div>
                <div class="row justify-center">
                  <q-btn
                    type="submit"
                    label="Submit"
                    color="primary"
                    class="full-width q-mt-md"
                    style="border-radius: 12px"
                  />
                </div>
              </q-form>
            </div>
          </q-card>
        </div>
      </div>

      <div class="col-9 col-xl-4 col-lg-4 col-md-5 getintouch">
        <q-page-section>
          <div
            style="border-radius: 12px"
            data-aos="fade-in"
            data-aos-duration="3000"
            class="q-pa-md"
          >
            <q-card-section>
              <div class="text-h5">Get in Touch</div>
              <div class="text-subtitle1 q-mt-md">
                We'd love to hear from you! Whether you have a question,
                feedback, or need assistance, feel free to reach out to us.
                We're here to help.
              </div>
            </q-card-section>

            <q-card-section>
              <div class="q-mb-md">
                <q-icon name="location_on" /> <strong>Office Address:</strong>
                <p>
                  Public Education and Employment Services Office (CPESCDO)<br />
                  Tagum City Hall, 2nd Floor<br />
                  Tagum City, Davao del Norte<br />
                  Philippines
                </p>
              </div>
              <div class="q-mb-md">
                <q-icon name="phone" /> <strong>Phone Numbers:</strong>
                <p>
                  Landline: (084) 216-5291<br />
                  Mobile: 0917-123-4567
                </p>
              </div>
              <div class="q-mb-md">
                <q-icon name="email" /> <strong>Email Address:</strong>
                <p>info@peso-tagumcity.ph</p>
              </div>
              <div class="q-mb-md">
                <q-icon name="access_time" /> <strong>Office Hours:</strong>
                <p>
                  Monday to Friday: 8:00 AM - 5:00 PM<br />
                  Saturday: 8:00 AM - 12:00 PM<br />
                  Sunday: Closed
                </p>
              </div>
              <!--  <div class="q-mb-md">
                <q-icon name="share" /> <strong>Social Media:</strong>
                <p>
                  Follow us on:
                  <a
                    href="https://www.facebook.com/peso.tagumcity"
                    target="_blank"
                    >Facebook</a
                  >,
                  <a href="https://twitter.com/pesotagumcity" target="_blank"
                    >Twitter</a
                  >
                </p>
              </div> -->
            </q-card-section>
          </div>
        </q-page-section>
      </div>

      <div col="6">
        <div>
          <q-card class="q-pa-md marginbai">
            <!-- Google Map Embed -->
            <div data-aos="fade-in" data-aos-duration="3000" class="google_map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3926.526868673136!2d125.80145981435612!3d7.449605894630827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32ff982e88a6a8b9%3A0xf33e3f045c8c1f53!2sTagum%20City%20Hall!5e0!3m2!1sen!2sph!4v1626549209181!5m2!1sen!2sph"
                width="100%"
                height="100%"
                frameborder="0"
                style="border: 0; position: absolute; top: 0; left: 0"
                allowfullscreen=""
                aria-hidden="false"
                tabindex="0"
              ></iframe>
            </div>

            <!-- Form Section -->
          </q-card>
        </div>
      </div>
    </div>
    <div class="row"></div>
  </q-page>
</template>

<script>
import AOS from "aos";
import "aos/dist/aos.css";

export default {
  data() {
    return {
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
@media only screen and (max-width: 1023px) {
  .getintouch {
    margin-top: -40px;
  }
}

.getintouch {
  margin-left: 15px;
  margin-top: -45px;
}

.full-width {
  width: 100%;
}

.flex-center1 {
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
}

.flex-center {
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
  height: -100vh; /* Full height to ensure vertical centering */
}
.page {
  margin-right: 100px;
  margin-left: 90px;
  margin-top: 80px;
}

.card_contact_us {
  height: 550px;
  margin-right: 8px;
  margin-left: 13px;
  border-radius: 12px;
  margin-top: -35px;
}

.google_map {
  position: relative;
  overflow: hidden;
  padding-top: 56.25%;
  width: 450px;
  height: 510px;
}

.contact_us {
  margin-top: -28px;
}

@media only screen and (max-width: 375px) {
  .page {
    margin-right: 100px;
    margin-left: 90px;
    margin-top: 750px;
  }

  .google_map {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%;
    width: 450px;
    height: 510px;
    visibility: hidden;
  }

  .marginbai {
    visibility: hidden;
  }
  /*  .marginbai {
    margin-top: -10px;
  } */
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
