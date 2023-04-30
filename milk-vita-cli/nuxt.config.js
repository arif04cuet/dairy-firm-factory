export default {
    // Global page headers: https://go.nuxtjs.dev/config-head
    loading:'~/components/system/SideLoader.vue',
    head: {
      title: "milk-vita",
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        { hid: "description", name: "description", content: "" },
        { name: "format-detection", content: "telephone=no" },
      ],
      link: [
        { rel: "icon", type: "image/x-icon", href: "/icon.png"},
        {
          rel: "stylesheet",
          href: "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css",
        },
        {
          rel: "stylesheet",
          href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
        },
      ],
      script: [
        {
          src: "https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js",
        },
        {
          src: "https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js",
        },
        {
          src: "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js",
        },
        {
          src: "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js",
        },
        {
          src: "http://dashboard.rdcd.orangebd.com/components/app-switcher/app-switcher.js",
          // src: "http://127.0.0.1:8000/components/app-switcher/app-switcher.js",
        }
      ],
    },
  
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: ["@/assets/css/master.css"],
  
    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
      "@/plugins/axios.js",
      "@/plugins/inject.js",
      "@/services/guard.js",
      {src: '@/plugins/custom.js', mode: 'client'},
      {src: '@/plugins/filter.js', mode: 'client'},
    ],
  
    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,
  
    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
      '@nuxtjs/dotenv'
    ],
  
    // Modules: https://go.nuxtjs.dev/config-modules
    modules: [
      ['nuxt-apache-config',
        {
          https: true,
          redirection: true,
          redirectUrl: '200.html',
          indexes: true,
          onlyGET: true,
        }
      ],
      // https://go.nuxtjs.dev/bootstrap
      "bootstrap-vue/nuxt",
      // https://go.nuxtjs.dev/axios
      "@nuxtjs/axios",
      // https://go.nuxtjs.dev/pwa
      "@nuxtjs/pwa",
      //
      "@nuxtjs/auth-next",
      //npm install @nuxtjs/auth@4.5.1 @nuxtjs/axios@5.3.1 --save
      // '@nuxtjs/auth'
    ],
    auth: {
      strategies: {
        local: {
          endpoints: {
            login: { url: "login", method: "post" },
            logout: { url: "logout", method: "post"},
            user: { url: "user", method: "post" },
          },
          user: {
            property: '',
          },
          tokenType:''
        },
      },
      redirect: {
        login: "/user/dashboard",
        home: "/user/dashboard",
      },
    },
    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
      // baseURL: "http://localhost:8080/api",
      baseURL: process.env.API_SERVER,
      // baseURL: "http://54.255.3.210/milk-vita-server/api",
    },
  
    // PWA module configuration: https://go.nuxtjs.dev/pwa
    pwa: {
      manifest: {
        lang: "en",
      },
    },
    //serverMiddleware:['middleware/auth'],
  
    router: {
      // base: process.env.BASE_PATH,
      // middleware:'auth'
    },
  
    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},
  };
  