import { route } from "quasar/wrappers";
import {
  createRouter,
  createMemoryHistory,
  createWebHistory,
  createWebHashHistory,
} from "vue-router";
import routes from "./routes";
import { api } from "src/boot/axios";
import { Cookies } from "quasar";
/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default route(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === "history"
    ? createWebHistory
    : createWebHashHistory;

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE),
  });
  Router.beforeEach((to, from, next) => {
    let access_token_exist = false;
    if (Cookies.get("access_token")) {
      access_token_exist = true;
      api.defaults.headers = {
        Authorization: "Bearer " + Cookies.get("access_token"),
        "Content-Type": "application/json",
        Accept: "application/json;charset=UTF-8",
      };
    }
    if (to.matched.some((record) => record.meta.requireAuth)) {
      if (access_token_exist) {
        console.log(11111);
        next();
      } else {
        console.log(22222);
        next({
          path: "/login",
          query: { redirect: to.fullPath },
        });
      }
    } else {
      if (
        to.matched.some((record) => record.meta.login) ||
        to.matched.some((record) => record.meta.register)
      ) {
        if (access_token_exist) {
          next({
            path: "/",
            query: { redirect: to.fullPath },
          });
        } else {
          console.log(33333);
          next()
        }
      } else {
        console.log(6666);
        next();
      }
    }
  });

  return Router;
});
