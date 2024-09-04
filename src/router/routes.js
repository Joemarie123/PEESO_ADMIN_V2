const routes = [
  /* {
    path: "/",
    component: () => import("layouts/LoginPage.vue"),
  }, */

  {
    path: "/",
    component: () => import("layouts/WebLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("pages/WebPages/HomeContainer.vue"),
      },

      {
        path: "/ContactUs",
        component: () => import("pages/WebPages/ContactUs.vue"),
      },

      {
        path: "/WhatisPeeso",
        component: () => import("pages/WebPages/WhatisPeeso.vue"),
      },

      {
        path: "/HomePage",
        component: () => import("pages/WebPages/HomePage.vue"),
      },

      {
        path: "/LoginPage",
        component: () => import("layouts/LoginPage.vue"),
      },

      {
        path: "/SignUpPage",
        component: () => import("layouts/SignUpPage.vue"),
      },

      /*  {
        path: "/FooterPage",
        component: () => import("pages/WebPages/FooterPage.vue"),
      }, */
    ],
  },

  {
    path: "/DashBoard",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      { path: "", component: () => import("pages/DashBoard.vue") },

      {
        path: "/CompanyProfile",
        component: () => import("pages/CompanyProfile.vue"),
      },

      {
        path: "/ViewAllJobs",
        component: () => import("pages/ViewAllJobs.vue"),
      },
      {
        path: "/MyCalendar_Jobs",
        component: () => import("pages/MyCalendar_Jobs.vue"),
      },

      {
        path: "/CreateJobPost",
        name: "CreateJobPost",
        component: () => import("pages/CreateJobPost.vue"),
      },

      {
        path: "/ShortListed_Scheduled",
        name: "ShortListed_Scheduled",
        component: () => import("pages/ShortListed_Scheduled.vue"),
      },

      {
        path: "/SetTings",
        name: "SetTings", // Ensure this matches exactly
        component: () => import("pages/SetTings.vue"),
      },
    ],
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
