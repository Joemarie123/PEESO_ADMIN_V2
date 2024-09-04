<template>
  <q-layout view="hHh lpR fFf" class="backgroundcolor">
    <q-header class="page flex-center" justify="center">
      <q-toolbar class="text-black">
        <q-toolbar-title class="hidememobile" style="font-weight: bold">
          <span style="color: #3eb13c"> #WEARE</span>
          <span style="color: #e3db06">TAGUM</span>
        </q-toolbar-title>
        <!-- Burger menu for smaller screens -->
        <q-btn-dropdown
          flat
          class="custom-hover fontnibai"
          v-if="$q.screen.width <= 793"
          label="Menu"
          icon="menu"
        >
          <q-item clickable @click="scroll('HomePage')">
            <q-btn class="custom-hover" flat>Home</q-btn></q-item
          >
          <q-item clickable @click="scroll('WhatisPeeso')">
            <q-btn class="custom-hover" flat>About Us</q-btn></q-item
          >
          <q-item clickable @click="scroll('ContactUs')"
            ><q-btn class="custom-hover" flat>Contact Us</q-btn></q-item
          >
          <!--  <q-item clickable @click="goToPage('')"
            ><q-btn class="custom-hover" flat>Sign up</q-btn></q-item
          > -->
          <q-item clickable @click="goToPage('/LoginPage')"
            ><q-btn class="custom-hover" flat>Log in</q-btn></q-item
          >
        </q-btn-dropdown>

        <!-- Regular buttons for larger screens -->
        <div v-else>
          <q-btn flat class="custom-hover" @click="scroll('HomePage')"
            >Home</q-btn
          >
          <q-btn flat class="custom-hover" @click="scroll('WhatisPeeso')"
            >What is CPESCDO</q-btn
          >
          <q-btn flat class="custom-hover" @click="scroll('ContactUs')"
            >Contact Us</q-btn
          >
          <!--  <q-btn flat class="custom-hover" @click="goToPage('/SignUpPage')"
            >Sign up</q-btn
          > -->
          <q-btn
            flat
            class="custom_hover_loginpage"
            @click="goToPage('/LoginPage')"
            >Log in</q-btn
          >
        </div>

        <q-space />
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page>
        <router-view />
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
/* import FooterPage from "pages/WebPages/FooterPage.vue"; */

export default {
  name: "WebLayout",
  components: {
    /*  FooterPage, */
  },
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
    scroll(refName) {
      const element = document.getElementById(refName);
      if (element) {
        element.scrollIntoView({ behavior: "smooth" });
      }
    },
  },
};
</script>

<style scoped>
.page {
  margin-right: auto;
  margin-left: 200px;
  margin-top: 20px;
  background-color: rgba(252, 250, 250, 0.943);
}

@media only screen and (max-width: 1048px) {
  .page {
    margin-right: auto;
    margin-left: 120px;

    margin-top: 20px;
    background-color: rgba(252, 250, 250, 0.943);
  }
}

@media only screen and (max-width: 968px) {
  .page {
    margin-right: auto;
    margin-left: 30px;

    margin-top: 20px;
    background-color: rgba(252, 250, 250, 0.943);
  }
}

@media only screen and (max-width: 878px) {
  .page {
    margin-right: -70px;
    margin-left: 10px;
    margin-top: 20px;
    background-color: rgba(252, 250, 250, 0.943);
  }
}

@media only screen and (max-width: 375px) {
  .page {
    margin-right: -800px;
    margin-left: 200px;

    margin-top: 20px;
    background-color: rgba(252, 250, 250, 0.943);
  }
}

.transparent-color {
  background-color: rgba(0, 0, 0, 0.5);
}
.backgroundcolor {
  background-color: rgba(252, 250, 250, 0.943);
}

.flex-center {
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

@media only screen and (max-width: 375px) {
  /*  .fontnibai {
    font-size: 9px;
  } */

  .hidememobile {
    display: none;
  }

  .page {
    margin-right: 10px;
    margin-left: 10px;
    margin-top: 20px;
    background-color: rgba(252, 250, 250, 0.943);
  }
}

.q-toolbar.bg-black {
  background-color: rgba(250, 250, 250, 0);
}

.q-btn.text-white {
  color: white;
}

.custom_hover_loginpage {
  background: linear-gradient(40deg, #279f27, #5fc331);
  transition: background-color 0.3s ease;
  color: white;
  border-radius: 18px;
}

.custom-hover:hover {
  background: linear-gradient(40deg, #279f27, #5fc331);
  transition: background-color 0.3s ease;
  color: white;
  border-radius: 18px;
}
</style>
