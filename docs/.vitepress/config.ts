export default {
  base: '/docs/',
  // dest: '/public/docs/',
  title: "ERPMASTER",
  description: "Inventory and Ecommerce management system",
  lastUpdated: true,
  // logo: "/logo.svg",
  head: [
    [
      'link',
      { rel: 'preconnect', href: 'https://fonts.googleapis.com' }
    ],
    [
      'link',
      { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' }
    ],
    [
      'link',
      { href: 'https://fonts.googleapis.com/css2?family=Roboto&display=swap', rel: 'stylesheet' }
    ]
  ],
  locales: {
    root: {
      label: "English",
      lang: "en-US",
      description: 'Inventory and Ecommerce management system',
      themeConfig: {
        nav: [
          { text: 'Home', link: '/' },
          { text: 'GitHub', link: 'https://github.com/zakarialabib/erpmaster' },
        ],
        sidebar: [
          {
            text: 'Get Started',
            items: [
              { text: 'Introduction', link: '/en/guide/introduction' },
              { text: 'Features', link: '/en/guide/features' },
              { text: 'Concepts', link: '/en/guide/concepts' },
              { text: 'Installation', link: '/en/guide/installation' },
              { text: 'Configuration', link: '/en/guide/configuration' },
              { text: 'Routes', link: '/en/guide/routes' },
              { text: 'Model', link: '/en/guide/models' },
              { text: 'Environment', link: '/en/guide/environment' },
              { text: 'Usage', link: '/en/guide/usage' },
            ]
          }
        ],
        footer: {
          message: 'crafted with love from Morocco.',
          copyright: 'Copyright © 2023 - Zakaria Labib'
        },
      },
    },
    "ar": {
      label: "العربية",
      lang: 'ar-MA',
      description: 'نظام إدارة المخزون والتجارة الإلكترونية المبني على Tall Stack',
      themeConfig: {
        nav: [
          { text: 'الصفحة الرئيسية', link: '/ar/' },
          { text: 'الثبيت', link: '/ar/guide/installation', target: '_self' },
          { text: 'GitHub', link: 'https://github.com/zakarialabib/erpmaster' },
        ],
        sidebar: [
          {
            text: 'ابدأ',
            items: [
              { text: 'مقدمة تعريفية', link: '/ar/guide/introduction' },
              { text: 'المميزات', link: '/ar/guide/features' },
              { text: 'المفاهيم', link: '/ar/guide/concepts' },
              { text: 'البيئة', link: '/ar/guide/environment' },
              { text: 'التثبيت', link: '/ar/guide/installation' },
              { text: 'الاعدادات الاولية', link: '/ar/guide/configuration' },
              { text: 'الاستخدام', link: '/ar/guide/usage' },
              // { text: 'المسارات', link: '/ar/guide/routes' },
              // { text: 'النموذج', link: '/ar/guide/models' },
            ]
          }
        ],
        footer: {
          message: 'crafted with love from Morocco.',
          copyright: 'Copyright © 2023 - Zakaria Labib'
        },
      },
    },
    "fr": {
      label: "Français",
      lang: "fr-FR",
      description: 'Système de gestion des stocks et de commerce électronique construit avec Tall Stack',
      themeConfig: {
        nav: [
          { text: 'Accueil', link: '/fr/' },
          { text: 'Documentation', link: '/fr/guide/installation', target: '_self' },
          { text: 'GitHub', link: 'https://github.com/zakarialabib/erpmaster' },
        ],
        sidebar: [
          {
            text: 'Commencer',
            items: [
              { text: 'Introduction', link: '/fr/guide/introduction' },
              { text: 'Fonctionnalités', link: '/fr/guide/features' },
              { text: 'Concepts', link: '/fr/guide/concepts' },
              { text: 'Installation', link: '/fr/guide/installation' },
              { text: 'Configuration', link: '/fr/guide/configuration' },
              { text: 'Routes', link: '/fr/guide/routes' },
              { text: 'Modèle', link: '/fr/guide/models' },
              { text: 'Environnement', link: '/fr/guide/environment' },
              { text: 'Utilisation', link: '/fr/guide/usage' },
            ]
          }
        ],
        footer: {
          message: 'crafted with love from Morocco.',
          copyright: 'Copyright © 2023 - Zakaria Labib'
        },
      }
    }
  },
  themeConfig: {
    search: {
      provider: "local",
    },
    socialLinks: [
      { icon: "github", link: "https://github.com/zakarialabib" },
      { icon: "twitter", link: "https://twitter.com/zakarialabib" },
    ],
  },
 
}
