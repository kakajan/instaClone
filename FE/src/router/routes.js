const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/DashboardPage.vue"),
        meta: {
          requireAuth: true
        }
      }
    ]
  },
  {
    path: "/test",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/testPage.vue"),
        meta: {
          requireAuth: true
        }
      }
    ]
  },
  {
    path: "/register",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/RegisterPage.vue"),
        meta: {
          requireAuth: false,
          register: true
        }
      }
    ]
  },
  {
    path: "/login",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/LoginPage.vue"),
        meta: {
          requireAuth: false,
          login: true
        }
      }
    ]
  },
  {
    path: "/confirm",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/ConfirmPage.vue"),
        meta: {
          requireAuth: false,
          login: true
        }
      }
    ]
  },
  {
    path: "/posts",
    component: () => import("layouts/MainLayout.vue"),
    meta: {
      requireAuth: true
    },
    children: [
      {
        path: "",
        component: () => import("src/pages/AllPosts.vue")
      },
      {
        path: "create",
        component: () => import("src/pages/CreatePost.vue")
      },
      {
        path: "edit/:id",
        component: () => import("src/pages/EditPost.vue")
      }
    ]
  },
  {
    path: "/profile",
    component: () => import("layouts/MainLayout.vue"),
    meta: {
      requireAuth: true
    },
    children: [
      {
        path: "",
        component: () => import("src/pages/ProfilePage.vue")
      }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue")
  }
];

export default routes;
